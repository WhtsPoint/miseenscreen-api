<?php

use App\Interfaces\CallFormFileDeleteInterface;
use App\Interfaces\CallFormFileUploadInterface;
use App\Utils\CallFormFileStorage;
use App\Utils\FileSerializer;
use App\Utils\Validator;

$storageSettings = require __DIR__ . '/../config/storage.php';

app()->register('file_storage_path', function () use ($storageSettings) {
    return $storageSettings['file_storage_path'];
});

app()->register(Validator::class, function () {
    return new Validator();
});

app()->register(CallFormFileUploadInterface::class . '&' . CallFormFileDeleteInterface::class, function () {
    return new CallFormFileStorage(
        app()->{'file_storage_path'}
    );
});

app()->register(FileSerializer::class, function () {
    return new FileSerializer();
});
