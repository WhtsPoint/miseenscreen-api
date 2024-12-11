<?php

namespace App\Utils;

use App\Interface\CacheInterface;
use Redis;
use RedisException;

class RedisAdapter implements CacheInterface
{
    public function __construct(
        private readonly Redis $redis
    ) {
    }

    /**
     * @throws RedisException
     */
    public function set(string $key, $value, int $expire): void
    {
       $this->redis->set($key, $value, ['EX' => $expire]);
    }

    /**
     * @throws RedisException
     */
    public function get(string $key): mixed
    {
       return $this->redis->get($key);
    }
}