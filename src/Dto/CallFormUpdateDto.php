<?php

namespace App\Dto;

use App\Utils\FormStatus;
use Symfony\Component\Validator\Constraints\Choice;

class CallFormUpdateDto
{
    public function __construct(
        #[Choice(FormStatus::VALUES)]
        public string $status
    ) {}
}