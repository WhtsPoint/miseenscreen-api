<?php

namespace App\Utils;

use App\Interface\ValueObjectInterface;
use InvalidArgumentException;

class Services implements ValueObjectInterface
{
    public const VALUES = [
        'ecommerce',
        'webPortals',
        'elearning',
        'hrSoftware',
        'analytics',
        'other'
    ];
    /**
     * @param string[] $values
     */
    private array $values;

    /**
     * @param string[] $values
     */
    public function __construct(array $values)
    {
        if (count(array_diff($values, self::VALUES)) !== 0) {
            throw new InvalidArgumentException('Invalid services');
        }

        if (count(array_unique($values)) !== count($values)) {
            throw new InvalidArgumentException('Duplicate services');
        }

        $this->values = $values;
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->values;
    }
}
