<?php

use App\Controllers\SubscriptionController;
use App\Interfaces\AuthenticationInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;
use App\Utils\Validator;
use Leaf\Db;

app()->register(SubscriptionRepositoryInterface::class, function () {
    return new SubscriptionRepository(
        app()->{Db::class}
    );
});

app()->register(SubscriptionController::class, function () {
    return new SubscriptionController(
        app()->{SubscriptionRepositoryInterface::class},
        app()->{Validator::class},
        app()->{AuthenticationInterface::class}
    );
});
