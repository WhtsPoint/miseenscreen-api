<?php

namespace App\Dto;

class SubscriptionCreationDto {
    public function __construct(
        public string $token,
        public string $email
    ) {}
}
