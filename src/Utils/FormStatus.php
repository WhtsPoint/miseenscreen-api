<?php

namespace App\Utils;

use App\Interface\ValueObjectInterface;
use App\Trait\StringValueObjectTrait;
use InvalidArgumentException;

class FormStatus implements ValueObjectInterface
{
    use StringValueObjectTrait;

    public const VALUES = ['inWork', 'done'];

    public function __construct(string $value) {
        if (in_array($value, self::VALUES) === false) {
            throw new InvalidArgumentException('Invalid status');
        }

        $this->value = $value;
    }
}