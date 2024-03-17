<?php

namespace App\Service;

use App\Dto\CallFormGetFileDto;
use App\Exception\CallFormNotFoundException;
use App\Exception\FileNotFoundException;
use App\Interface\CallFormRepositoryInterface;

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

        if (in_array($dto->file, $form->getFiles()) === false) {
            throw new FileNotFoundException();
        }

        return $this->storagePath . '/' . $form->getId() . '/' . $dto->file;
    }
}
