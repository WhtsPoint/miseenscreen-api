<?php

use App\Controllers\CallFormController;

app()->post('/call-form', function () {
    return app()->{CallFormController::class}->create();
});

app()->get('/call-forms', function () {
    return app()->{CallFormController::class}->getAll();
});
