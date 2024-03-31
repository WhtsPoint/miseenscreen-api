<?php

namespace App\Dto;

use App\Utils\FormStatus;

class CallFormDto
{
    public function __construct(
        public string $comment,
        public string $fullName,
        public string $companyName,
        public string $employeeNumber,
        public string $phone,
        public string $email,
        public ?array $services = null,
        public ?array $files = null,
        public ?FormStatus $status = null
    ) {}
}
