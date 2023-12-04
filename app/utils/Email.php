<?php

namespace App\Utils;

use InvalidArgumentException;
use JsonSerializable;

class Email implements JsonSerializable
{
    private string $value;

    public const REGEX = '/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/';

    public function __construct($value)
    {
        if (preg_match(self::REGEX, $value) === false) {
            throw new InvalidArgumentException('Invalid email format');
        }

        $this->value = $value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
