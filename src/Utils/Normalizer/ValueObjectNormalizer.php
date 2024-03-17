<?php

namespace App\Utils\Normalizer;

use App\Interface\ValueObjectInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ValueObjectNormalizer implements NormalizerInterface
{
    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): mixed {
        return $object->get();
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return $data instanceof ValueObjectInterface;
    }
}