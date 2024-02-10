<?php

namespace Dependencies;

use App\Controllers\CallFormController;
use App\Factories\CallFormFactory;
use App\Interfaces\AuthenticationInterface;
use App\Interfaces\CallFormFileDeleteInterface;
use App\Interfaces\CallFormFileUploadInterface;
use App\Interfaces\CallFormRepositoryInterface;
use App\Repositories\CallFormRepository;
use App\Services\CallFormFileService;
use App\Services\CallFormService;
use App\Utils\CallFormFileStorage;
use App\Utils\CallFormSerializer;
use App\Utils\FileResponse;
use App\Utils\FileSerializer;
use App\Utils\Validator;
use Leaf\Db;

app()->register(CallFormFileUploadInterface::class . '&' . CallFormFileDeleteInterface::class, function () {
    return new CallFormFileStorage(
        app()->{'file_storage_path'}
    );
});

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
        app()->{CallFormFileUploadInterface::class . '&' . CallFormFileDeleteInterface::class},
        app()->{CallFormFactory::class},
        app()->{CallFormSerializer::class}
    );
});

app()->register(CallFormFileService::class, function () {
    return new CallFormFileService(
        app()->{CallFormRepositoryInterface::class},
        app()->{'file_storage_path'}
    );
});

app()->register(CallFormController::class, function () {
    return new CallFormController(
        app()->{CallFormService::class},
        app()->{CallFormFileService::class},
        app()->{Validator::class},
        app()->{FileSerializer::class},
        app()->{FileResponse::class},
        app()->{AuthenticationInterface::class}
    );
});
