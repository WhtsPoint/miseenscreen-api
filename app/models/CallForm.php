<?php

namespace App\Models;

use Leaf\Model;

class CallForm {
    public function __construct(
        private readonly string $id,
        private string $comment,
        private string $fullName,
        private string $companyName,
        private array $files = []
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }
}
