<?php

namespace App\Dto;

class DeleteFileDto
{
    public function __construct(
        public string $path,
        public string $fileName
    ) {}
}
