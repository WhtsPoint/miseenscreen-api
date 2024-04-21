<?php

namespace App\Repository;

use App\Exception\SubscriptionNotFoundException;
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
        private EntityManagerInterface $entityManager
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
        $pageCount = $this->entityManager->createQuery('SELECT COUNT(s.id) FROM App\Model\Subscription s')
            ->getSingleScalarResult();
        $subscriptions = $this->entityManager->createQuery('SELECT s FROM App\Model\Subscription s ORDER BY s.postedAt DESC')
            ->setFirstResult($pagination->getFirst())
            ->setMaxResults($pagination->getCount())
            ->execute();

        return new PaginatedSubscriptions($subscriptions, ceil($pageCount / $pagination->getCount()));
    }
}
