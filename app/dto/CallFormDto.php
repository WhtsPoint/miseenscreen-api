<?php

namespace App\Dto;

use App\Utils\Email;
use App\Utils\Phone;
use App\Utils\Services;

class CallFormDto
{
    public function __construct(
        public readonly string $id,
        public string $comment,
        public string $fullName,
        public string $companyName,
        public int $employeeNumber,
        public string $phone,
        public string $email,
        public array $files = [],
        public ?array $services = null
    ) {}
}
