<?php

namespace App\Utils;

use App\Model\Subscription;

class PaginatedSubscriptions
{
    public function __construct(
        /** @var Subscription[' */
        private array $data,
        private int $pageCount
    ) {}

    public function getData(): array
    {
        return $this->data;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }
}