<?php

namespace App\Utils;

use App\Dto\CallFormDto;
use App\Models\CallForm;

class CallFormSerializer
{
    public function fromArrayToDto(array $formParams): CallFormDto
    {
        return new CallFormDto(
            $formParams['id'],
            $formParams['comment'],
            $formParams['full_name'],
            $formParams['company_name'],
            $formParams['employee_number'],
            new Phone($formParams['phone']),
            new Email($formParams['email']),
            json_decode($formParams['files'])
        );
    }

    public function toArray(CallForm $form): array
    {
        return [
            'id' => $form->getId(),
            'comment' => $form->getComment(),
            'full_name' => $form->getFullName(),
            'company_name' => $form->getCompanyName(),
            'files' => $form->getFiles(),
            'phone' => $form->getPhone()->get(),
            'employee_number' => $form->getEmployeeNumber(),
            'email' => $form->getEmail()->get()
        ];
    }
}
