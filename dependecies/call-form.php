<?php

namespace Dependencies;

use App\Controllers\CallFormController;
use App\Factories\CallFormFactory;
use App\Interfaces\CallFormRepositoryInterface;
use App\Repositories\CallFormRepository;
use App\Services\CallFormService;
use App\Utils\CallFormSerializer;
use App\Utils\Validator;
use Leaf\Db;

app()->register(CallFormSerializer::class, function () {
    return new CallFormSerializer();
});

app()->register(CallFormRepositoryInterface::class, function () {
    return new CallFormRepository(
        app()->{Db::class},
        app()->{CallFormSerializer::class}
    );
});

app()->register(CallFormFactory::class, function () {
    return new CallFormFactory();
});

app()->register(CallFormService::class, function () {
    return new CallFormService(
        app()->{CallFormRepositoryInterface::class},
        app()->{CallFormFactory::class}
    );
});

app()->register(CallFormController::class, function () {
    return new CallFormController(
        app()->{CallFormService::class},
        app()->{CallFormRepositoryInterface::class},
        app()->{Validator::class}
    );
});
