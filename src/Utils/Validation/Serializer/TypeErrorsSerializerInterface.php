<?php

namespace App\Utils\Validation\Serializer;

use App\Utils\Validation\Data\TypeError;

interface TypeErrorsSerializerInterface
{
    /**
     * @param TypeError[] $errors
     */
    public function convertErrorsForResponse(array $arguments, array $errors);
}