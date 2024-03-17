<?php

namespace App\Controller;

use App\Dto\CallFormDto;
use App\Dto\CallFormGetFileDto;
use App\Dto\PaginationDto;
use App\Exception\CallFormNotFoundException;
use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ReCaptchaIsInvalidException;
use App\Exception\FileNotFoundException;
use App\Interface\CallFormRepositoryInterface;
use App\Service\CallFormFileService;
use App\Service\CallFormService;
use App\Utils\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;

class CallFormController extends AbstractController
{
    public function __construct(
        protected CallFormService $service,
        protected CallFormFileService $fileService,
        protected CallFormRepositoryInterface $repository
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     */
    #[Route(path: '/api/v0/call-form', methods: 'POST')]
    public function create(#[ValueResolver('map_request_payload')] CallFormDto $dto, Request $request): JsonResponse
    {
        try {
            $response = $this->service->create($dto);

            return $this->json($response);
        } catch (ReCaptchaIsInvalidException) {
            return $this->json(['error' => 'Invalid reCaptcha token'], 400);
        }
    }

    #[Route(path: '/api/v0/admin/call-forms', methods: 'GET')]
    public function getAll(#[ValueResolver('map_request_query')] PaginationDto $dto): JsonResponse
    {
        $response = $this->repository->getAll(new Pagination($dto->page, $dto->count));

        return $this->json($response);
    }

    #[Route(path: '/api/v0/admin/call-form/{id}', methods: 'DELETE')]
    public function deleteById(string $id): JsonResponse
    {
        try {
            $this->service->deleteById($id);

            return $this->json(['success' => true]);
        } catch (CallFormNotFoundException) {
            return $this->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }

    #[Route(path: '/api/v0/admin/call-form/{id}/{file}')]
    public function getFile(string $id, string $file): BinaryFileResponse|JsonResponse
    {
        try {
            $file = $this->fileService->getFilePath(new CallFormGetFileDto($id, $file));

            return $this->file($file);
        } catch (FileNotFoundException) {
            return $this->json(['error' => 'File not found'], 404);
        } catch (CallFormNotFoundException) {
            return $this->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }
}
