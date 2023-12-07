<?php

namespace App\Dto;

class LoginResultDto
{
    public function __construct(
        public string $token
    ) {}
}
