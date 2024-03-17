<?php

namespace App\Dto;

class SubscriptionDto
{
    public function __construct(
        public string $id,
        public string $email
    ) {}
}
