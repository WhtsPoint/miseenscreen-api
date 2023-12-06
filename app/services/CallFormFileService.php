<?php

namespace App\Services;

use App\Dto\CallFormGetFileDto;
use App\exceptions\CallFormNotFoundException;
use App\Exceptions\FileNotFoundException;
use App\Interfaces\CallFormRepositoryInterface;

class CallFormFileService
{
    public function __construct(
        protected CallFormRepositoryInterface $repository,
        protected string $storagePath
    ) {}

    /**
     * @throws CallFormNotFoundException
     * @throws FileNotFoundException
     */
    public function getFilePath(CallFormGetFileDto $dto): string
    {
        $form = $this->repository->getById($dto->id);

        if ($form->getFiles()[$dto->file] === null) {
            throw new FileNotFoundException();
        }

        return $this->storagePath . $form->getId() . '/' . $dto->file;
    }
}
