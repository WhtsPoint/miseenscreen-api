<?php

use App\Controllers\SubscriptionController;
use App\Interfaces\AuthenticationInterface;
use App\Interfaces\ReCaptchaInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;
use App\Services\SubscriptionService;
use App\Utils\Validator;
use Leaf\Db;

app()->register(SubscriptionRepositoryInterface::class, function () {
    return new SubscriptionRepository(
        app()->{Db::class}
    );
});

app()->register(SubscriptionService::class, function () {
    return new SubscriptionService(
        app()->{SubscriptionRepositoryInterface::class},
        app()->{ReCaptchaInterface::class}
    );
});

app()->register(SubscriptionController::class, function () {
    return new SubscriptionController(
        app()->{SubscriptionService::class},
        app()->{SubscriptionRepositoryInterface::class},
        app()->{Validator::class},
        app()->{AuthenticationInterface::class},
    );
});
