<?php

namespace App\Interface;

interface CacheInterface
{
    public function set(string $key, $value, int $expire): void;

    public function get(string $key): mixed;
}