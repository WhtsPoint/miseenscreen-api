<?php

namespace App\Interface;

use App\Dto\SubscriptionDto;
use App\Exception\SubscriptionNotFoundException;
use App\Model\Subscription;
use App\Utils\Pagination;

interface SubscriptionRepositoryInterface
{
    public function create(Subscription $subscription): void;

    /**
     * @throws SubscriptionNotFoundException
     */
    public function deleteById(string $id): void;

    /**
     * @return SubscriptionDto[]
     */
    public function getAll(Pagination $pagination): array;

    public function isExistsWithEmail(string $email): bool;
}
