<?php

namespace App\Doctrine\Type;

use App\Utils\Services;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ServicesType extends StringType
{
    public const type = 'services';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Services
    {
        return $value ? new Services(json_decode($value, true)) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Services ? json_encode($value->get()) : $value;
    }

    public function getName(): string
    {
        return self::type;
    }
}