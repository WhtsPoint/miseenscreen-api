<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\Email;

class SubscriptionCreationDto {
    public function __construct(
        public string $token,
        #[Email]
        public string $email
    ) {}
}
