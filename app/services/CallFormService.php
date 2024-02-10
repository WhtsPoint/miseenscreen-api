<?php

namespace App\Services;
use App\Dto\CallFormCreationDto;
use App\Dto\CallFormCreationResultDto;
use App\Dto\CallFormDto;
use App\exceptions\CallFormNotFoundException;
use App\Exceptions\FileIsAlreadyExistsException;
use App\Exceptions\ReCaptchaIsInvalidException;
use App\factories\CallFormFactory;
use App\Interfaces\CallFormFileDeleteInterface;
use App\Interfaces\CallFormFileUploadInterface;
use App\Interfaces\CallFormRepositoryInterface;
use App\Interfaces\ReCaptchaInterface;
use App\Utils\CallFormSerializer;
use App\Utils\Pagination;

class CallFormService
{
    public function __construct(
        protected CallFormRepositoryInterface $repository,
        protected CallFormFileUploadInterface&CallFormFileDeleteInterface $storage,
        protected CallFormFactory $factory,
        protected CallFormSerializer $serializer,
        protected ReCaptchaInterface $reCaptcha
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     * @throws ReCaptchaIsInvalidException
     */
    public function create(CallFormCreationDto $dto, string $token): CallFormCreationResultDto
    {
        if ($this->reCaptcha->isTokenValid($token) === false) {
            var_dump($token);
            throw new ReCaptchaIsInvalidException();
        }

        $form = $this->factory->create($dto, $this->storage);
        $this->repository->create($form);

        return new CallFormCreationResultDto($form->getId());
    }

    /**
     * @return CallFormDto[]
     */
    public function getAll(Pagination $pagination): array
    {
        $forms = $this->repository->getAll($pagination);

        return array_map(
            fn ($form) => $this->serializer->toDto($form),
            $forms
        );
    }

    /**
     * @throws CallFormNotFoundException
     */
    public function deleteById(string $id): void
    {
        $form = $this->repository->getById($id);

        $form->removeAllFiles($this->storage);
        $this->repository->deleteById($id);
    }
}
