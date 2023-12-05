<?php

namespace App\Services;
use App\Dto\CallFormCreationDto;
use App\Dto\CallFormCreationResultDto;
use App\factories\CallFormFactory;
use App\Interfaces\CallFormRepositoryInterface;

class CallFormService
{
    public function __construct(
        protected CallFormRepositoryInterface $repository,
        protected CallFormFactory $factory
    ) {}

    public function create(CallFormCreationDto $dto): CallFormCreationResultDto
    {
        $form = $this->factory->create($dto);
        $this->repository->create($form);

        return new CallFormCreationResultDto($form->getId());
    }
}
