<?php

namespace App\Utils\Validation\Serializer;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorsSerializer implements ValidationErrorsSerializerInterface
{

    public function convertErrorsForResponse(ConstraintViolationListInterface $errors): array
    {
        $result = [];

        foreach ($errors as $error) {
            $prop = $error->getPropertyPath();
            $result[$prop] = [...(@$result[$prop] ?: []), $error->getMessage()];
        }

        return $result;
    }
}