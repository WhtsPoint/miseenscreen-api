<?php

namespace App\Factories;

use App\Dto\CallFormCreationDto;
use App\Dto\UploadCallFormFileDto;
use App\Exceptions\FileIsAlreadyExistsException;
use App\Interfaces\CallFormFileUploadInterface;
use App\Models\CallForm;
use App\Utils\Email;
use App\Utils\Phone;
use Lib\Uuid;

class CallFormFactory
{
    /**
     * @throws FileIsAlreadyExistsException
     */
    public function create(
        CallFormCreationDto $dto,
        CallFormFileUploadInterface $storage
    ): CallForm {
        $form = new CallForm(
            Uuid::v4(),
            $dto->comment,
            $dto->fullName,
            $dto->companyName,
            $dto->employeeNumber,
            new Phone($dto->phone),
            new Email($dto->email)
        );

        foreach ($dto->files as $file) {
            $form->addFile($file, $storage);
        }

        return $form;
    }
}
