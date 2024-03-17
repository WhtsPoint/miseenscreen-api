<?php

namespace App\Interface;

use App\Exception\CallFormNotFoundException;
use App\Model\CallForm;
use App\Utils\Pagination;

interface CallFormRepositoryInterface
{
    public function create(CallForm $form): void;

    /**
     * @return CallForm[]
     */
    public function getAll(Pagination $pagination): array;

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void;

    /**
     * @throws CallFormNotFoundException
     */
    public function getById(string $id): CallForm;
}
