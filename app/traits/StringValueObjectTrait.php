<?php

namespace App\Traits;

trait StringValueObjectTrait
{
    private string $value;

    public function get(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
