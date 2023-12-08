<?php

namespace App\Repositories;

use App\Exceptions\SubscriptionAlreadyExistsException;
use App\Exceptions\SubscriptionNotFoundException;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use Leaf\Db;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(
        protected Db $database
    ) {}

    /**
     * @throws SubscriptionAlreadyExistsException
     */
    public function create(Subscription $subscription): void
    {
        if ($this->isExistsWithEmail($subscription->getEmail()->get())) {
            throw new SubscriptionAlreadyExistsException();
        }

        $this->database->insert('subscriptions')
            ->params([
                'id' => $subscription->getId(),
                'email' => $subscription->getEmail()->get()
            ])->execute();
    }

    public function isExistsWithEmail(string $email): bool
    {
        return $this->database->query(
            'SELECT COUNT(*) as count FROM subscription WHERE email = ?'
        )->bind($email)->fetchAll()[0]['count'] !== 0;
    }

    public function isExistsWithId(string $id): bool
    {
        return $this->database->query(
                'SELECT COUNT(*) as count FROM subscription WHERE id = ?'
            )->bind($id)->fetchAll()[0]['count'] !== 0;
    }

    /**
     * @throws SubscriptionNotFoundException
     */
    public function deleteById(string $id): void
    {
        if ($this->isExistsWithId($id)) {
            throw new SubscriptionNotFoundException();
        }

        $this->database->delete('subscriptions')
            ->where('id', $id)
            ->execute();
    }
}
