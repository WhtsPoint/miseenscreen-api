<?php

namespace App\Interfaces;

use App\Exceptions\CallFormDirNotFound;

interface CallFormFileDeleteInterface
{
    /**
     * @throws CallFormDirNotFound
     */
    public function deleteAll(string $id): void;
}
