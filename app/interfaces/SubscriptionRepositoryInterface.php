<?php

namespace App\Interfaces;

use App\Dto\SubscriptionDto;
use App\Exceptions\SubscriptionAlreadyExistsException;
use App\Exceptions\SubscriptionNotFoundException;
use App\Models\Subscription;
use App\Utils\Pagination;

interface SubscriptionRepositoryInterface
{
    /**
     * @throws SubscriptionAlreadyExistsException
     */
    public function create(Subscription $subscription): void;

    /**
     * @throws SubscriptionNotFoundException
     */
    public function deleteById(string $id): void;

    /**
     * @return SubscriptionDto[]
     */
    public function getAll(Pagination $pagination): array;
}
