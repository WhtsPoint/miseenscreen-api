<?php

use Leaf\Db;

app()->register(Db::class, function () {
    return new Db([
        'host' => _env('DATABASE_HOST'),
        'dbname' => _env('DATABASE_NAME'),
        'root' => _env('DATABASE_USER'),
        'password' => _env('DATABASE_PASSWORD'),
        'dbtype' => _env('DATABASE_DRIVER'),
        'port' => _env('DATABASE_PORT')
    ]);
});
