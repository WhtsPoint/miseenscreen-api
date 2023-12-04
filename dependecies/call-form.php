<?php

use App\Interfaces\CallFormRepositoryInterface;
use App\Repositories\CallFormRepository;
use App\Utils\CallFormSerializer;
use Leaf\Db;

app()->register(CallFormSerializer::class, function () {
    return new CallFormSerializer();
});

app()->register(CallFormRepositoryInterface::class, function () {
    return new CallFormRepository(
        app()->{Db::class},
        app()->{CallFormSerializer::class}
    );
});

app()
