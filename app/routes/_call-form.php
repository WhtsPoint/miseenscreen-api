<?php

use App\Controllers\CallFormController;

app()->get('/call-form', 'CallFormController@get');
