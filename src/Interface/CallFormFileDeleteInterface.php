<?php

namespace App\Interface;

use App\Exception\CallFormDirNotFound;

interface CallFormFileDeleteInterface
{
    public function deleteAll(string $id): void;
}
