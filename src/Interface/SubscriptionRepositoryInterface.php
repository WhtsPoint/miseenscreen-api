<?php

namespace App\Interface;

use App\Dto\SubscriptionDto;
use App\Exception\SubscriptionNotFoundException;
use App\Model\Subscription;
use App\Utils\PaginatedSubscriptions;
use App\Utils\Pagination;

interface SubscriptionRepositoryInterface
{
    public function create(Subscription $subscription): void;

    /**
     * @throws SubscriptionNotFoundException
     */
    public function deleteById(string $id): void;

    public function getAll(Pagination $pagination): PaginatedSubscriptions;

    public function isExistsWithEmail(string $email): bool;
}
