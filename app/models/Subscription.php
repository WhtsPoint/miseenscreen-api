<?php

namespace App\Models;

use App\Utils\Email;

class Subscription
{
    public function __construct(
        private readonly string $id,
        private Email $email
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
