<?php

namespace App\Controllers;

use App\Dto\SubscriptionCreationDto;
use App\Exceptions\ReCaptchaIsInvalidException;
use App\Exceptions\SubscriptionAlreadyExistsException;
use App\Exceptions\SubscriptionNotFoundException;
use App\Interfaces\AuthenticationInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Services\SubscriptionService;
use App\Utils\Email;
use App\Utils\Pagination;
use App\Utils\Validator;
use Leaf\Controller;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $service,
        protected SubscriptionRepositoryInterface $repository,
        protected Validator $validator,
        protected AuthenticationInterface $authentication
    ) {
        parent::__construct();
    }

    public function create(): void
    {
        $body = $this->request->body();

        $this->validator->validate([
            'email' => ['required', 'regex:"' . Email::REGEX . '"'],
            'token' => ['required']
        ], $body);

        try {
            $response = $this->service->subscribe(new SubscriptionCreationDto(
                $body['token'],
                $body['email']
            ));

            $this->response->json($response);
        } catch (SubscriptionAlreadyExistsException) {
            $this->response->json(['error' => 'This email is already subscribed'], 400);
        } catch (ReCaptchaIsInvalidException) {
            $this->response->json(['error' => 'Invalid reCaptcha token'], 400);
        }
    }

    public function getAll(): void
    {
        $body = $this->request->body();

        $this->validator->validate([
            'page' => ['required', 'regex:"^[1-9][0-9]*$"'],
            'count' => ['required', 'regex:"^[1-9][0-9]*$"']
        ], $body);

        $response = $this->repository->getAll(new Pagination(
            (int) $body['page'],
            (int) $body['count']
        ));
        $this->response->json($response);
    }

    public function deleteById(string $id): void
    {
        try {
            $this->repository->deleteById($id);
            $this->response->json(['success' => true]);
        } catch (SubscriptionNotFoundException) {
            $this->response->json(['error' => 'Subscription not found'], 404);
        }
    }
}
