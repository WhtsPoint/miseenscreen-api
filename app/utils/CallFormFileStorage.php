<?php

namespace App\Utils;

use App\Dto\DeleteFileDto;
use App\Dto\UploadFileDto;
use App\Exceptions\FileIsAlreadyExistsException;
use App\Exceptions\FileNotFoundException;
use App\Interfaces\CallFormFileDeleteInterface;
use App\Interfaces\CallFormFileUploadInterface;

class CallFormFileStorage implements CallFormFileDeleteInterface, CallFormFileUploadInterface
{
    public function __construct(
        protected string $path
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     */
    public function upload(UploadFileDto $dto): void
    {
        $dirPath = $this->path . $dto->dirName;

        if (is_dir($dirPath) === false) {
            mkdir($dirPath, recursive: true);
        }

        $filePath = $dirPath . '/' . $dto->fileName;

        if (is_file($filePath) === true) {
            throw new FileIsAlreadyExistsException();
        }

        move_uploaded_file($dto->path, $filePath);
    }

    public function delete(DeleteFileDto $dto): void
    {
        $filePath = $this->path . $dto->path . '/' . $dto->fileName;

        if (is_file($filePath) === false) {
            throw new FileNotFoundException();
        }

        unlink($filePath);
    }
}
