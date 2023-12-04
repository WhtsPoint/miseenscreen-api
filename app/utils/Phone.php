<?php

namespace App\Utils;

use App\Traits\StringValueObjectTrait;
use InvalidArgumentException;

class Phone
{
    use StringValueObjectTrait;

    public const REGEX = '^\+\d{1,3}\s?\(\d{1,4}\)\s?\d{1,4}[-\s]?\d{1,10}$';
    public function __construct($value)
    {
        if (preg_match(self::REGEX, $value) === false) {
            throw new InvalidArgumentException('Invalid phone format');
        }

        $this->value = $value;
    }
}
