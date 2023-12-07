<?php

use App\Controllers\AuthController;

app()->get('/auth/login', function () {
    return app()->{AuthController::class}->login();
});
