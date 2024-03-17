<?php

namespace App\Controller;

use App\Dto\SubscriptionCreationDto;
use App\Dto\PaginationDto;
use App\Exception\ReCaptchaIsInvalidException;
use App\Exception\SubscriptionAlreadyExistsException;
use App\Exception\SubscriptionNotFoundException;
use App\Interface\SubscriptionRepositoryInterface;
use App\Service\SubscriptionService;
use App\Utils\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;


class SubscriptionController extends AbstractController
{
    public function __construct(
        protected SubscriptionService $service,
        protected SubscriptionRepositoryInterface $repository,
    ) {}

    #[Route(path: '/api/v0/subscription', methods: 'POST')]
    public function create(#[ValueResolver('map_request_query')] SubscriptionCreationDto $dto): JsonResponse
    {
        try {
            $response = $this->service->subscribe($dto);

            return $this->json($response);
        } catch (SubscriptionAlreadyExistsException) {
            return $this->json(['error' => 'This email is already subscribed'], 400);
        } catch (ReCaptchaIsInvalidException) {
            return $this->json(['error' => 'Invalid reCaptcha token'], 400);
        }
    }

    #[Route(path: '/api/v0/admin/subscriptions', methods: 'GET')]
    public function getAll(#[ValueResolver('map_request_query')] PaginationDto $dto): JsonResponse
    {
        $response = $this->repository->getAll(new Pagination(
            $dto->page,
            $dto->count
        ));

        return $this->json($response);
    }

    #[Route(path: '/api/v0/admin/subscription/{id}', methods: 'DELETE')]
    public function deleteById(string $id): JsonResponse
    {
        try {
            $this->repository->deleteById($id);

            return $this->json(['success' => true]);
        } catch (SubscriptionNotFoundException) {
            return  $this->json(['error' => 'Subscription not found'], 404);
        }
    }
}
