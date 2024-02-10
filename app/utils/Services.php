<?php

namespace App\Utils;

use InvalidArgumentException;

class Services
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
