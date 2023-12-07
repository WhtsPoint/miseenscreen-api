<?php

use App\Interfaces\CallFormFileDeleteInterface;
use App\Interfaces\CallFormFileUploadInterface;
use App\Utils\CallFormFileStorage;
use App\Utils\FileResponse;
use App\Utils\FileSerializer;
use App\Utils\Validator;
use Leaf\Auth;
use Leaf\Db;

$storageSettings = require __DIR__ . '/../config/storage.php';
$fileRules = require __DIR__ . '/../config/file_rules.php';

app()->register('file_storage_path', function () use ($storageSettings) {
    return $storageSettings['file_storage_path'];
});

app()->register('file_rules', function () use ($fileRules) {
    return $fileRules;
});

app()->register(Validator::class, function () {
    return new Validator(
        app()->{'file_rules'}
    );
});

app()->register(CallFormFileUploadInterface::class . '&' . CallFormFileDeleteInterface::class, function () {
    return new CallFormFileStorage(
        app()->{'file_storage_path'}
    );
});

app()->register(FileSerializer::class, function () {
    return new FileSerializer();
});

app()->register(FileResponse::class, function () {
    return new FileResponse();
});

app()->register(Auth::class, function () {
    $auth = new Auth();

    $auth->dbConnection(
        app()->{Db::class}->connection()
    );

    return $auth;
});
