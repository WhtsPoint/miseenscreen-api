<?php

namespace App\Doctrine\Type;

use App\Utils\FormStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class FormStatusType extends StringType
{
    public const type = 'formStatus';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?FormStatus
    {
        return $value ? new FormStatus((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FormStatus ? $value->get() : $value;
    }

    public function getName(): string
    {
        return self::type;
    }
}