<?php

namespace App\Service;

use App\Dto\CallFormCreationResultDto;
use App\Dto\CallFormDto;
use App\Exception\CallFormNotFoundException;
use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ReCaptchaIsInvalidException;
use App\Factory\CallFormFactory;
use App\Interface\CallFormFileDeleteInterface;
use App\Interface\CallFormFileUploadInterface;
use App\Interface\CallFormRepositoryInterface;
use App\Interface\ReCaptchaInterface;

class CallFormService
{
    public function __construct(
        protected CallFormRepositoryInterface $repository,
        protected CallFormFileUploadInterface&CallFormFileDeleteInterface $storage,
        protected CallFormFactory $factory,
        protected ReCaptchaInterface $reCaptcha
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     * @throws ReCaptchaIsInvalidException
     */
    public function create(CallFormDto $dto): CallFormCreationResultDto
    {
        if ($this->reCaptcha->isTokenValid($dto->token) === false) {
            throw new ReCaptchaIsInvalidException();
        }

        $form = $this->factory->create($dto, $this->storage);
        $this->repository->create($form);

        return new CallFormCreationResultDto($form->getId());
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
