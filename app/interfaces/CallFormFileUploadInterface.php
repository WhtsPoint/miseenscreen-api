<?php

namespace App\Interfaces;

use App\Dto\UploadFileDto;
use App\Exceptions\FileIsAlreadyExistsException;

interface CallFormFileUploadInterface
{
    /**
     * @throws FileIsAlreadyExistsException
     */
    public function upload(UploadFileDto $dto): void;
}
