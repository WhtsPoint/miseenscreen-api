<?php

namespace App\Model;

use Symfony\Component\Uid\Uuid;

class User
{
    private string $id;
    private string $password;

    public function __construct(string $password) {
        $this->id = (string) Uuid::v4();
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}