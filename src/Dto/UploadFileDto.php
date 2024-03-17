<?php

namespace App\Dto;

class UploadFileDto
{
    public function __construct(
        public string $path,
        public string $fileName,
        public string $dirName
    ) {}
}
