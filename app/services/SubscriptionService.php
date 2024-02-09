<?php

namespace App\Services;

use App\Dto\SubscriptionCreationDto;
use App\Dto\SubscriptionResultDto;
use App\Exceptions\ReCaptchaIsInvalidException;
use App\Exceptions\SubscriptionAlreadyExistsException;
use App\Interfaces\ReCaptchaInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use App\Utils\Email;
use Lib\Uuid;

class SubscriptionService {
    public function __construct(
        protected SubscriptionRepositoryInterface $repository,
        protected ReCaptchaInterface $reCaptcha
    ) {}

    /**
     * @throws SubscriptionAlreadyExistsException
     * @throws ReCaptchaIsInvalidException
     */
    public function subscribe(SubscriptionCreationDto $dto): SubscriptionResultDto {
        if ($this->reCaptcha->isTokenValid($dto->token) === false) {
            throw new ReCaptchaIsInvalidException();
        }

        $this->repository->create(new Subscription(
            $id = Uuid::v4(),
            new Email($dto->email)
        ));

        return new SubscriptionResultDto($id);
    }
}
