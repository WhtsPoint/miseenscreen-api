<?php

namespace App\Dto;

class CallFormCreationDto
{
    public function __construct(
        public string $comment,
        public string $fullName,
        public string $companyName,
        public int $employeeNumber,
        public string $phone,
        public string $email,
        /** @var FileDto[] */
        public array $files,
        /** @var string[] */
        public ?array $services = null
    ) {}
}
