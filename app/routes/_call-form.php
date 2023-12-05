<?php

use App\Controllers\CallFormController;

app()->post('/call-form', function () {
    return app()->{CallFormController::class}->create();
});

app()->get('/call-forms', function () {
    return app()->{CallFormController::class}->getAll();
});

app()->delete('/call-form/{id}', function (string $id) {
    return app()->{CallFormController::class}->deleteById($id);
});
