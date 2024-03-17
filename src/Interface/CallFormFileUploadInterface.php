<?php

namespace App\Interface;

use App\Exception\FileIsAlreadyExistsException;
use Symfony\Component\HttpFoundation\File\File;

interface CallFormFileUploadInterface
{
    /**
     * @throws FileIsAlreadyExistsException
     */
    public function upload(File $file, string $id): string;
}
