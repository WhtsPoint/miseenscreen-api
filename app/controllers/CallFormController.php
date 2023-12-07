<?php

namespace App\Controllers;

use App\Dto\CallFormCreationDto;
use App\Dto\CallFormGetFileDto;
use App\Exceptions\CallFormDirNotFound;
use App\Exceptions\CallFormNotFoundException;
use App\Exceptions\FileIsAlreadyExistsException;
use App\Exceptions\FileNotFoundException;
use App\Services\CallFormFileService;
use App\Services\CallFormService;
use App\Utils\Email;
use App\Utils\FileResponse;
use App\Utils\FileSerializer;
use App\Utils\Pagination;
use App\Utils\Phone;
use App\Utils\Validator;
use Leaf\Controller;

class CallFormController extends Controller
{
    public function __construct(
        protected CallFormService $service,
        protected CallFormFileService $fileService,
        protected Validator $validator,
        protected FileSerializer $fileSerializer,
        protected FileResponse $fileResponse
    ) {
        parent::__construct();
    }

    /**
     * @throws FileIsAlreadyExistsException
     */
    public function create(): void
    {
        $body = $this->request->body();

        $files = $this->fileSerializer->toCorrectFormat(
            $this->request->files()['files'] ?? []
        );

        $this->validator->validate([
            'comment' => ['required', 'min:3'],
            'fullName' => ['required', 'min:3'],
            'companyName' => ['required', 'min:3'],
            'employeeNumber' => ['required', 'number'],
            'phone' => ['required', 'regex:"' . Phone::REGEX . '"'],
            'email' => ['required', 'regex:"' . Email::REGEX . '"']
        ], $body);

        $this->validator->validateFiles($files);

        $dto = new CallFormCreationDto(
            $body['comment'],
            $body['fullName'],
            $body['companyName'],
            (int) $body['employeeNumber'],
            $body['phone'],
            $body['email'],
            $files
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
        $response = $this->service->getAll($pagination);
        $this->response->json($response);
    }

    /**
     * @throws CallFormDirNotFound
     */
    public function deleteById(string $id): void
    {
        try {
            $this->service->deleteById($id);
            $this->response->json(['success' => true]);
        } catch (CallFormNotFoundException) {
            $this->response->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }

    public function getFile(): void
    {
        $body = $this->request->body();

        $this->validator->validate([
            'id' => ['required'],
            'file' => ['required']
        ], $body);

        $dto = new CallFormGetFileDto(
            $body['id'],
            $body['file']
        );

        try {
            $file = $this->fileService->getFilePath($dto);
            $this->fileResponse->response($file);
        } catch (FileNotFoundException) {
            $this->response->json(['error' => 'File not found'], 404);
        } catch (CallFormNotFoundException) {
            $this->response->json(['error' => 'Call form with this id is not exists'], 404);
        }
    }
}
