<?php

namespace App\Model;

use App\Utils\Email;
use Symfony\Component\Uid\Uuid;

class Subscription
{
    private readonly string $id;

    public function __construct(
        private Email $email
    ) {
        $this->id = (string) Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
