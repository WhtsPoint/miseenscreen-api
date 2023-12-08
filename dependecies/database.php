<?php

namespace Dependencies;

use Leaf\Db;

app()->register(Db::class, function () {
    return db();
});
