<?php

namespace App\Repository;

use App\Exception\CallFormNotFoundException;
use App\Interface\CacheInterface;
use App\Interface\CallFormRepositoryInterface;
use App\Model\CallForm;
use App\Utils\PaginatedCallForms;
use App\Utils\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CallFormRepository implements CallFormRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        public EntityManagerInterface $entityManager,
        private CacheInterface $cache,
        private int $paginationCacheExpire = 3600
    ) {
        $this->repository = $this->entityManager->getRepository(CallForm::class);
    }

    public function create(CallForm $form): void
    {
        $this->entityManager->persist($form);
        $this->entityManager->flush();
    }

    /**
     * @throws CallFormNotFoundException
     */
    public function getById(string $id): CallForm
    {
        $form = $this->repository->findOneBy(['id' => $id]);

        if ($form === null) {
            throw new CallFormNotFoundException();
        }

        return $form;
    }

    public function getAll(Pagination $pagination): PaginatedCallForms
    {
        $cacheKey = 'call_form.pagination.' . $pagination->getCount() . '.' . $pagination->getPage();
        $formsCount = ceil($this->getCount() / $pagination->getCount());
        $cache = $this->cache->get($cacheKey);

        if (is_string($cache) === false) {
            $forms = $this->entityManager->createQuery('SELECT f FROM App\Model\CallForm f ORDER BY f.postedAt DESC')
                ->setFirstResult($pagination->getFirst())
                ->setMaxResults($pagination->getCount())
                ->execute();

            $this->cache->set($cacheKey, serialize($forms), $this->paginationCacheExpire);

            return new PaginatedCallForms($forms, $formsCount);
        }

        return new PaginatedCallForms(unserialize($cache), $formsCount);
    }

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void
    {
        if ($this->isExists($id) === false) {
            throw new CallFormNotFoundException();
        }

        $this->entityManager->createQuery('DELETE App\Model\CallForm f WHERE f.id = :id')
            ->execute(['id' => $id]);
    }

    public function isExists(string $id): bool
    {
        return $this->repository->count(['id' => $id]) !== 0;
    }

    public function getCount(): int
    {
        return $this->entityManager->createQuery('SELECT COUNT(f.id) FROM App\Model\CallForm f')
            ->getSingleScalarResult();
    }
}
