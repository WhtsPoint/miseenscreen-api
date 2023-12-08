<?php

namespace App\Interfaces;

use App\Exceptions\SubscriptionAlreadyExistsException;
use App\Exceptions\SubscriptionNotFoundException;
use App\Models\Subscription;

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
}
