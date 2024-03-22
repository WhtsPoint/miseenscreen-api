<?php

namespace App\Utils;

use App\Model\CallForm;

class PaginatedCallForms
{
    public function __construct(
        /** @var CallForm[] */
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