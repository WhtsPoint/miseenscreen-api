<?php

namespace App\Interface;

use App\Exception\CallFormNotFoundException;
use App\Model\CallForm;
use App\Utils\PaginatedCallForms;
use App\Utils\Pagination;

interface CallFormRepositoryInterface
{
    public function create(CallForm $form): void;

    public function getAll(Pagination $pagination): PaginatedCallForms;

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void;

    /**
     * @throws CallFormNotFoundException
     */
    public function getById(string $id): CallForm;
}
