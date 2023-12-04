<?php

namespace App\interfaces;

use Leaf\Db;
use PDO;

interface DatabaseInterface
{
    public static function get(): Db;
}
