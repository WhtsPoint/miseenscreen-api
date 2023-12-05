<?php

namespace App\Interfaces;

use App\Dto\CallFormDto;
use App\exceptions\CallFormNotFoundException;
use App\Models\CallForm;
use App\Utils\Pagination;

interface CallFormRepositoryInterface
{
    public function create(CallForm $form): void;

    /**
     * @return CallFormDto[]
     */
    public function getAll(Pagination $pagination): array;

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void;
}
