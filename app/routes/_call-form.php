<?php

use App\Controllers\CallFormController;

app()->get('/call-form', function () {
    return app()->{CallFormController::class}->get();
});
