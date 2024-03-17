<?php

namespace App\Utils;

use App\Trait\StringValueObjectTrait;
use InvalidArgumentException;

class Phone
{
    use StringValueObjectTrait;

    public const REGEX = '^\+\d{10,12}$';
    public function __construct($value)
    {
        if (preg_match('/' . self::REGEX . '/', $value) === false) {
            throw new InvalidArgumentException('Invalid phone format');
        }

        $this->value = $value;
    }
}
