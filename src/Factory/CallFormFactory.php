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

        if ($dto->status !== null) $form->setStatus($dto->status);
        if ($postedAt !== null) $form->setPostedAt($postedAt);

        foreach ($dto->files ?: [] as $file) {
            $form->addFile($file, $storage);
        }

        return $form;
    }
}
