<?php

namespace App\Controllers;

use App\Dto\CallFormCreationDto;
use App\Exceptions\CallFormNotFoundException;
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
            'phone' => ['required', 'regex:"' . Phone::REGEX],
            'email' => ['required', 'regex:"' . Email::REGEX]
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
        $body = $this->request->urlData();

        $this->validator->validate([
            'page' => ['required', 'regex:"^[1-9][0-9]*$"'],
            'count' => ['required', 'regex:"^[1-9][0-9]*$"']
        ], $body);

        $pagination = new Pagination((int) $body['page'], (int) $body['count']);
        $response = $this->repository->getAll($pagination);
        $this->response->json($response);
    }

    public function deleteById(string $id): void
    {
        try {
            $this->repository->deleteById($id);
            $this->response->json(['success' => true]);
        } catch (CallFormNotFoundException) {
            $this->response->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }
}
