<?php

use App\Controllers\CallFormController;

app()->register(CallFormController::class, function () {
    return new CallFormController();
});
