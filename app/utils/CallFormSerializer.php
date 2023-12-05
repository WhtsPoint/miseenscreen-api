<?php

namespace App\Utils;

use App\Models\CallForm;

class CallFormSerializer
{
    public function fromArray(array $formParams): CallForm
    {
        return new CallForm(
            $formParams['id'],
            $formParams['comment'],
            $formParams['fullName'],
            $formParams['companyName'],
            $formParams['employeeNumber'],
            new Phone($formParams['phone']),
            $formParams['files']
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
            'phone' => $form->getPhone(),
            'employee_number' => $form->getEmployeeNumber()
        ];
    }
}
