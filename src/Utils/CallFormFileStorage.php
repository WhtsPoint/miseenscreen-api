<?php

namespace App\Utils;

use App\Exception\FileIsAlreadyExistsException;
use App\Interface\CallFormFileDeleteInterface;
use App\Interface\CallFormFileUploadInterface;
use Symfony\Component\HttpFoundation\File\File;

class CallFormFileStorage implements CallFormFileDeleteInterface, CallFormFileUploadInterface
{
    public function __construct(
        protected string $path
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     */
    public function upload(File $file, string $id): string
    {
        $dirPath = $this->path . '/' . $id;

        if (is_dir($dirPath) === false) {
            mkdir($dirPath, recursive: true);
        }

        $extension = $file->guessExtension();
        $fileName = bin2hex(random_bytes(2)) . ($extension ? '.' . $extension : '');

        $file->move($dirPath, $fileName);

        return $fileName;
    }

    public function deleteAll(string $id): void
    {
        $dirPath = $this->path . '/' . $id;

        if (is_dir($dirPath) === false) return;

        foreach (array_diff(scandir($dirPath), ['.', '..']) as $file) {
            unlink($dirPath . '/' . $file);
        }

        rmdir($dirPath);
    }
}
