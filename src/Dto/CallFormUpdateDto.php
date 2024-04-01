<?php

namespace App\Dto;

use App\Utils\FormStatus;

class CallFormUpdateDto
{
    public function __construct(
        public ?FormStatus $status = null,
        public ?string $adminComment = null
    ) {}
}