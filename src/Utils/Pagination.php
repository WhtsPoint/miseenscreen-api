<?php

namespace App\Utils;

use InvalidArgumentException;

class Pagination
{
    private int $page;
    private int $count;

    public function __construct(int $page, int $count)
    {
        if ($page <= 0) {
            throw new InvalidArgumentException('Page must be natural number');
        }

        if ($count <= 0) {
            throw new InvalidArgumentException('Count must be natural number');
        }

        $this->page = $page;
        $this->count = $count;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getFirst(): int
    {
        return ($this->page - 1) * $this->count;
    }

    public function getLast(): int
    {
        return $this->page * $this->count;
    }
}
