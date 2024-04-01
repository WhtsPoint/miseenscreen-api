<?php

namespace App\Dto;

use App\Utils\FormStatus;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;

class CallFormPrimitiveUpdateDto
{
    public function __construct(
        #[Choice(FormStatus::VALUES)]
        public ?string $status = null,
        #[Length(max: 3000)]
        public ?string $adminComment = null
    ) {}
}