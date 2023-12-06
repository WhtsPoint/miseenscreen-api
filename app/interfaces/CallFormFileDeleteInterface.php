<?php

namespace App\Interfaces;

use App\Dto\DeleteFileDto;
use App\Exceptions\FileNotFoundException;

interface CallFormFileDeleteInterface
{
    /**
     * @throws FileNotFoundException
     */
    public function delete(DeleteFileDto $dto): void;
}
