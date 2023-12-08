<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => _env('DATABASE_DRIVER'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by eloquent is shown below to make development simple.
    |
    |
    | All database work in eloquent is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => _env('DATABASE_HOST'),
            'port' => _env('DATABASE_PORT'),
            'database' => _env('DATABASE_NAME'),
            'username' => _env('DATABASE_USER'),
            'password' => _env('DATABASE_PASSWORD'),
            'charset' => '',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer'
        ],
    ],
];
