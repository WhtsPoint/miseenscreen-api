<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\Positive;

class PaginationDto
{
    public function __construct(
        #[Positive]
        public int $count,
        #[Positive]
        public int $page
    ) {}
}