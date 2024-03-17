<?php

namespace App\Dto;

class UploadCallFormFileDto
{
    public function __construct(
        public string $path,
        public string $fileName
    ) {}
}
