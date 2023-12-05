<?php

namespace App\Utils;

use App\Traits\StringValueObjectTrait;
use InvalidArgumentException;
use JsonSerializable;

class Email implements JsonSerializable
{
    use StringValueObjectTrait;

    public const REGEX = '^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$';

    public function __construct($value)
    {
        if (preg_match('/' . self::REGEX . '/', $value) === false) {
            throw new InvalidArgumentException('Invalid email format');
        }

        $this->value = $value;
    }
}
