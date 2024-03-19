<?php

namespace App\Service;

use App\Dto\SubscriptionCreationDto;
use App\Dto\SubscriptionResultDto;
use App\Exception\ReCaptchaIsInvalidException;
use App\Exception\SubscriptionAlreadyExistsException;
use App\Interface\ReCaptchaInterface;
use App\Interface\SubscriptionRepositoryInterface;
use App\Model\Subscription;
use App\Utils\Email;

class SubscriptionService {
    public function __construct(
        protected SubscriptionRepositoryInterface $repository,
        protected ReCaptchaInterface $reCaptcha
    ) {}

    /**
     * @throws ReCaptchaIsInvalidException
     * @throws SubscriptionAlreadyExistsException
     */
    public function subscribe(SubscriptionCreationDto $dto): SubscriptionResultDto {
        if ($this->reCaptcha->isTokenValid($dto->token) === false) {
            throw new ReCaptchaIsInvalidException();
        }

        if ($this->repository->isExistsWithEmail($dto->email)) {
            throw new SubscriptionAlreadyExistsException();
        }

        $subscription = new Subscription(new Email($dto->email));
        $this->repository->create($subscription);

        return new SubscriptionResultDto($subscription->getId());
    }
}
