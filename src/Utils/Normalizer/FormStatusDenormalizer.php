<?php

namespace App\Utils\Normalizer;

use App\Utils\FormStatus;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FormStatusDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): FormStatus
    {
        return new FormStatus($data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        return is_string($data);
    }
}