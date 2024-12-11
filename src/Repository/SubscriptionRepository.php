<?php

namespace App\Repository;

use App\Exception\SubscriptionNotFoundException;
use App\Interface\CacheInterface;
use App\Interface\SubscriptionRepositoryInterface;
use App\Model\Subscription;
use App\Utils\Email;
use App\Utils\PaginatedSubscriptions;
use App\Utils\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CacheInterface $cache,
        private int $paginationCacheExpire = 3600
    ) {
        $this->repository = $this->entityManager->getRepository(Subscription::class);
    }

    public function create(Subscription $subscription): void
    {
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
    }

    public function isExistsWithEmail(string $email): bool
    {
        return $this->repository->count(['email' => new Email($email)]) !== 0;
    }

    public function isExistsWithId(string $id): bool
    {
        return $this->repository->count(['id' => $id]) !== 0;
    }

    /**
     * @throws SubscriptionNotFoundException
     */
    public function deleteById(string $id): void
    {
        if ($this->isExistsWithId($id) === false) {
            throw new SubscriptionNotFoundException();
        }

        $this->entityManager->createQuery('DELETE App\Model\Subscription s WHERE s.id = :id')
            ->execute(['id' => $id]);
    }

    public function getAll(Pagination $pagination): PaginatedSubscriptions
    {
        $cacheKey = 'subscriptions.pagination.' . $pagination->getCount() . '.' . $pagination->getPage();
        $cache = $this->cache->get($cacheKey);
        $pageCount = ceil($this->getCount() / $pagination->getCount());

        if (is_string($cache) === false) {
            $subscriptions = $this->entityManager->createQuery('SELECT s FROM App\Model\Subscription s ORDER BY s.postedAt DESC')
                ->setFirstResult($pagination->getFirst())
                ->setMaxResults($pagination->getCount())
                ->execute();
            $this->cache->set($cacheKey, serialize($subscriptions), $this->paginationCacheExpire);

            return new PaginatedSubscriptions($subscriptions, $pageCount);
        }

        return new PaginatedSubscriptions(unserialize($cache), $pageCount);
    }

    public function getCount(): int
    {
        return $this->entityManager->createQuery('SELECT COUNT(s.id) FROM App\Model\Subscription s')
            ->getSingleScalarResult();
    }
}
