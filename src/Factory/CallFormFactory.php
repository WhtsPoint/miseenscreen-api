<?php

namespace App\Factory;

use App\Dto\CallFormCreationDto;
use App\Dto\CallFormDto;
use App\Exception\FileIsAlreadyExistsException;
use App\Interface\CallFormFileUploadInterface;
use App\Model\CallForm;
use App\Utils\Services;
use Symfony\Component\Uid\Uuid;

class CallFormFactory
{
    /**
     * @throws FileIsAlreadyExistsException
     */
    public function create(
        CallFormDto $dto,
        CallFormFileUploadInterface $storage
    ): CallForm {
        $form = new CallForm(
            $dto->comment,
            $dto->fullName,
            $dto->companyName,
            $dto->employeeNumber,
            $dto->phone,
            $dto->email
        );

        if ($dto->services !== null) {
            $form->setServices(new Services($dto->services));
        }

        foreach ($dto->files ?: [] as $file) {
            $form->addFile($file, $storage);
        }

        return $form;
    }
}
