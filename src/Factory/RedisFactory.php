<?php

namespace App\Factory;

use App\Utils\RedisAdapter;
use Redis;
use RedisException;

class RedisFactory
{
    public function __construct(
        private readonly string $host,
        private readonly string $port
    ) {
    }

    /**
     * @throws RedisException
     */
    public function get(): RedisAdapter
    {
        $redis = new Redis();

        $redis->connect($this->host, $this->port);

        return new RedisAdapter($redis);
    }
}