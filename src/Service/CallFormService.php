<?php

namespace App\Service;

use App\Dto\CallFormCreationResultDto;
use App\Dto\CallFormDto;
use App\Dto\CallFormUpdateDto;
use App\Exception\CallFormNotFoundException;
use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ReCaptchaIsInvalidException;
use App\Exception\ThisStatusAlreadySetException;
use App\Factory\CallFormFactory;
use App\Interface\CallFormFileDeleteInterface;
use App\Interface\CallFormFileUploadInterface;
use App\Interface\CallFormRepositoryInterface;
use App\Interface\FlusherInterface;
use App\Interface\ReCaptchaInterface;
use App\Utils\FormStatus;
use DateTimeImmutable;

class CallFormService
{
    public function __construct(
        protected CallFormRepositoryInterface $repository,
        protected CallFormFileUploadInterface&CallFormFileDeleteInterface $storage,
        protected CallFormFactory $factory,
        protected ReCaptchaInterface $reCaptcha,
        public FlusherInterface $flusher
    ) {}

    /**
     * @throws FileIsAlreadyExistsException
     * @throws ReCaptchaIsInvalidException
     * @throws ThisStatusAlreadySetException
     */
    public function create(CallFormDto $dto, string $token): CallFormCreationResultDto
    {
        if ($this->reCaptcha->isTokenValid($token) === false) {
            throw new ReCaptchaIsInvalidException();
        }

        $form = $this->factory->create($dto, $this->storage, new DateTimeImmutable());
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

    /**
     * @throws CallFormNotFoundException
     * @throws ThisStatusAlreadySetException
     */
    public function update(CallFormUpdateDto $dto, string $id): void
    {
        $callForm = $this->repository->getById($id);

        if ($dto->status !== null) $callForm->setStatus($dto->status);
        if ($dto->adminComment !== null) $callForm->setAdminComment($dto->adminComment);

        $this->flusher->flush();
    }
}
