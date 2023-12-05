<?php

use App\Controllers\CallFormController;

app()->post('/call-form', function () {
    return app()->{CallFormController::class}->create();
});
