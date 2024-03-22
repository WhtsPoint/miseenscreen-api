<?php

namespace App\Repository;

use App\Exception\CallFormNotFoundException;
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
        public EntityManagerInterface $entityManager
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
        $formsCount = $this->entityManager->createQuery('SELECT COUNT(f.id) FROM App\Model\CallForm f')
            ->getSingleScalarResult();
        $forms = $this->entityManager->createQuery('SELECT f FROM App\Model\CallForm f')
            ->setFirstResult($pagination->getFirst())
            ->setMaxResults($pagination->getCount())
            ->execute();


        return new PaginatedCallForms($forms, ceil($formsCount / $pagination->getCount()));
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
}
