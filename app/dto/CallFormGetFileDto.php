<?php

namespace App\Dto;

class CallFormGetFileDto
{
    public function __construct(
        public string $id,
        public string $file
    ) {}
}
