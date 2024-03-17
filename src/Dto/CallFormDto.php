<?php

namespace App\Dto;

use App\Utils\Services;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;

class CallFormDto
{
    public function __construct(
        #[Length(min: 1, max: 3000)]
        public string $comment,
        #[Length(min: 1, max: 100)]
        public string $fullName,
        #[Length(min: 1, max: 100)]
        public string $companyName,
        #[Length(min: 1, max: 100)]
        public string $employeeNumber,
        #[Length(min: 1, max: 100)]
        public string $phone,
        #[Length(min: 1, max: 100)]
        public string $email,
        public string $token,
        #[Unique]
        #[All([new Choice(Services::VALUES)])]
        public ?array $services = null,
        #[All([new File(
            maxSize: '3M',
            extensions: [
                'txt' => ['text/plain'],
                'png' => ['image/png'],
                'jpeg' => ['image/jpeg'],
                'pdf' => ['application/pdf'],
                'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                'doc' => ['application/msword']
            ]
        )])]
        public ?array $files = null
    ) {}
}
