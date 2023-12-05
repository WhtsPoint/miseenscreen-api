<?php

namespace App\Dto;

use App\Utils\Email;
use App\Utils\Phone;

class CallFormDto
{
    public function __construct(
        public readonly string $id,
        public string $comment,
        public string $fullName,
        public string $companyName,
        public int $employeeNumber,
        public Phone $phone,
        public Email $email,
        public array $files = []
    ) {}
}
