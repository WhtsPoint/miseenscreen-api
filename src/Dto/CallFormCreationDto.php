<?php

namespace App\Dto;

class CallFormCreationDto
{
    public function __construct(
        public CallFormDto $fields,
        /** @var FileDto[] */
        public array $files
    ) {}
}

