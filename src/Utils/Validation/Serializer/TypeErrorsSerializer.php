<?php

namespace App\Utils\Validation\Serializer;

use App\Utils\Validation\Data\TypeError;

class TypeErrorsSerializer implements TypeErrorsSerializerInterface
{
    /**
     * @param TypeError[] $errors
     */
    public function convertErrorsForResponse(array $arguments, array $errors): array
    {
        return array_reduce(
            $errors,
            fn ($prev, $error) => [$error->getFieldName() =>
                    sprintf(
                        $this->isUnknown($this->filterTypes($error->getExpectedTypes())) ?
                            'Invalid value type' :
                            'Invalid value type, %s instead of %s',
                        gettype(@$arguments[$error->getFieldName()]),
                        implode(', ', $error->getExpectedTypes())
                    )
                ] + $prev,
            []
        );
    }

    private function isUnknown(array $types): bool
    {
        if (count($types) === 0) return true;

        if (count($types) === 1 && $types[0] === 'unknown') return true;

        return false;
    }

    private function filterTypes(array $types): array
    {
        return array_filter($types, fn ($type) => !class_exists($type));
    }
}