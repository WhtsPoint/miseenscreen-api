<?php

namespace App\Utils;

use App\Dto\UploadFileDto;
use App\Exceptions\FileIsAlreadyExistsException;
use App\Exceptions\CallFormDirNotFound;
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

    /**
     * @throws CallFormDirNotFound
     */
    public function deleteAll(string $id): void
    {
        $dirPath = $this->path . $id;

        if (is_dir($dirPath) === false) {
            throw new CallFormDirNotFound();
        }

        foreach (array_diff(scandir($dirPath), ['.', '..']) as $file) {
            unlink($dirPath . '/' . $file);
        }

        rmdir($dirPath);
    }
}
