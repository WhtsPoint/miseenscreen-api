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
        'crm',
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
        $valuesList = array_values($values);

        if (count(array_diff($valuesList, self::VALUES)) !== 0) {
            throw new InvalidArgumentException('Invalid services');
        }

        if (count(array_unique($valuesList)) !== count($valuesList)) {
            throw new InvalidArgumentException('Duplicate services');
        }

        $this->values = $valuesList;
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->values;
    }
}
