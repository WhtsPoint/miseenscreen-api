<?php

namespace App\Doctrine\Type;

use App\Utils\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const type = 'email';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return $value ? new Email((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Email ? $value->get() : $value;
    }

    public function getName(): string
    {
        return self::type;
    }
}