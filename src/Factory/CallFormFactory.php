<?php

namespace App\Factory;

use App\Dto\CallFormDto;
use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ThisStatusAlreadySetException;
use App\Interface\CallFormFileUploadInterface;
use App\Model\CallForm;
use App\Utils\Services;
use DateTimeImmutable;

class CallFormFactory
{
    /**
     * @throws FileIsAlreadyExistsException
     * @throws ThisStatusAlreadySetException
     */
    public function create(
        CallFormDto $dto,
        CallFormFileUploadInterface $storage,
        ?DateTimeImmutable $postedAt = null
    ): CallForm {
        $form = new CallForm(
            $dto->comment,
            $dto->fullName,
            $dto->companyName,
            $dto->employeeNumber,
            $dto->phone,
            $dto->email,
        );

        $form->setStatus($dto->status);

        if ($dto->services !== null) {
            $form->setServices(new Services($dto->services));
        }

        foreach ($dto->files ?: [] as $file) {
            $form->addFile($file, $storage);
        }

        return $form;
    }
}
