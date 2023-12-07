<?php

use App\Controllers\AuthController;
use App\Interfaces\AuthenticationInterface;
use App\Services\AuthService;
use App\Utils\Validator;
use Leaf\Auth;

app()->register(AuthService::class, function () {
    return new AuthService(
        app()->{Auth::class}
    );
});

app()->register(AuthenticationInterface::class, function () {
    return app()->{AuthService::class};
});

app()->register(AuthController::class, function () {
    return new AuthController(
        app()->{AuthenticationInterface::class},
        app()->{Validator::class}
    );
});
