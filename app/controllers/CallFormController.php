<?php

namespace App\Controllers;

use App\Dto\CallFormCreationDto;
use App\Interfaces\CallFormRepositoryInterface;
use App\Services\CallFormService;
use App\Utils\Email;
use App\Utils\Pagination;
use App\Utils\Phone;
use App\Utils\Validator;
use Leaf\Controller;

class CallFormController extends Controller
{

    public function __construct(
        protected CallFormService $service,
        protected CallFormRepositoryInterface $repository,
        protected Validator $validator
    ) {
        parent::__construct();
    }

    public function create(): void
    {
        $body = $this->request->body();

        $this->validator->validate([
            'comment' => ['required', 'min:3'],
            'fullName' => ['required', 'min:3'],
            'companyName' => ['required', 'min:3'],
            'employeeNumber' => ['required', 'number'],
            'phone' => ['required', 'regex:"' . str_replace('/', '', Phone::REGEX) . '"'],
            'email' => ['required', 'regex:"' . str_replace('/', '', Email::REGEX) . '"']
        ], $body);

        $dto = new CallFormCreationDto(
            $body['comment'],
            $body['fullName'],
            $body['companyName'],
            (int) $body['employeeNumber'],
            $body['phone'],
            $body['email']
        );

        $response = $this->service->create($dto);
        $this->response->json($response);
    }

    public function getAll(): void
    {

        //$response = $this->repository->getAll(new Pagination(2, 1));
        $this->response->json($this->request->b);
    }
}
