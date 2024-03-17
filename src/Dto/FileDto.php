<?php

namespace App\Dto;

class FileDto
{
    public function __construct(
        public string $name,
        public string $fullPath,
        public string $type,
        public string $tmpName,
        public int $size
    ) {}
}
