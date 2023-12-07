<?php

use Leaf\Db;

class User
{
    public function __construct(protected Db $database) {}

    public function migrate()
    {
        $this->database->query(
            'CREATE TABLE users (
                id varchar(36) NOT NULL PRIMARY KEY,
                username varchar(50) NOT NULL,
                password varchar(50) NOT NULL
            )'
        );
    }
}
