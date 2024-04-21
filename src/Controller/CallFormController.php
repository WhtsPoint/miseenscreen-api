<?php

namespace App\Controller;

use App\Dto\CallFormCreationDto;
use App\Dto\CallFormDto;
use App\Dto\CallFormGetFileDto;
use App\Dto\CallFormPrimitiveUpdateDto;
use App\Dto\CallFormUpdateDto;
use App\Dto\PaginationDto;
use App\Exception\CallFormNotFoundException;
use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ReCaptchaIsInvalidException;
use App\Exception\FileNotFoundException;
use App\Exception\ThisStatusAlreadySetException;
use App\Interface\CallFormRepositoryInterface;
use App\Service\CallFormFileService;
use App\Service\CallFormService;
use App\Utils\FormStatus;
use App\Utils\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CallFormController extends AbstractController
{
    public function __construct(
        protected CallFormService $service,
        protected CallFormFileService $fileService,
        protected CallFormRepositoryInterface $repository,
        protected NormalizerInterface&DenormalizerInterface $serializer
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     * @throws ExceptionInterface when bad attempt to denormalize dto
     * @throws ThisStatusAlreadySetException
     */
    #[Route(path: '/api/v0/call-form', methods: 'POST')]
    public function create(#[ValueResolver('map_request_payload')] CallFormCreationDto $dto): JsonResponse
    {
        $creationParams = $this->serializer->normalize($dto);
        $callFormDto = $this->serializer->denormalize(
            [...$creationParams, 'files' => $dto->files],
            CallFormDto::class
        );
        
        try {
            $response = $this->service->create($callFormDto, $dto->token);

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

            return $this->json(['success' => true], 204);
        } catch (CallFormNotFoundException) {
            return $this->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route(
        path: '/api/v0/admin/call-form/{id}',
        requirements: ['id' => Requirement::UUID_V4],
        methods: 'PATCH'
    )]
    public function update(
        #[ValueResolver('map_request_payload')] CallFormPrimitiveUpdateDto $dto,
        string $id
    ): JsonResponse
    {
        $updateParams = $this->serializer->normalize($dto);
        $updateDto = $this->serializer->denormalize($updateParams, CallFormUpdateDto::class);

        try {
            $this->service->update($updateDto, $id);

            return $this->json(['success' => true], 204);
        } catch (CallFormNotFoundException) {
            return $this->json(['error' => 'Call form with this id is not exists'], 404);
        } catch (ThisStatusAlreadySetException) {
            return $this->json(['error' => 'This status is already set'], 400);
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
