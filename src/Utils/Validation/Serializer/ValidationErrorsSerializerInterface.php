<?php

namespace App\Utils\Validation\Serializer;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidationErrorsSerializerInterface
{
    public function convertErrorsForResponse(ConstraintViolationListInterface $errors): array;
}