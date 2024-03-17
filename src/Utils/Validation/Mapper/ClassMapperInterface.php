<?php

namespace App\Utils\Validation\Mapper;

interface ClassMapperInterface
{
    public function denormalizeClass(array $arguments, string $classname);
    public function getErrors();
}