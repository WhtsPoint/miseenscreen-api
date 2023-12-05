<?php

use App\Utils\Validator;

app()->register(Validator::class, function () {
    return new Validator();
});
