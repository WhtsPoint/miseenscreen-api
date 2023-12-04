<?php

app()->setBasePath('/api/v0/');

app()->set404(function () {
	response()->json('Resource not found', 404, true);
});

app()->setErrorHandler(function () {
    response()->json('Internal error', 500, true);
});

app()->setNamespace('\App\Controllers');
