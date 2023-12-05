<?php

namespace App\Factories;

use App\Dto\CallFormCreationDto;
use App\Models\CallForm;
use App\Utils\Email;
use App\Utils\Phone;
use Lib\Uuid;

class CallFormFactory
{
    public function create(CallFormCreationDto $dto): CallForm
    {
        return new CallForm(
            Uuid::v4(),
            $dto->comment,
            $dto->fullName,
            $dto->companyName,
            $dto->employeeNumber,
            new Phone($dto->phone),
            new Email($dto->email)
        );
    }
}
