<?php

namespace App\Interfaces;

use App\Exceptions\CallFormDirNotFound;

interface CallFormFileDeleteInterface
{
    public function deleteAll(string $id): void;
}
