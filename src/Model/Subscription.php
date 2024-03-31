<?php

namespace App\Model;

use App\Utils\Email;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class Subscription
{
    private string $id;
    private ?DateTimeImmutable $postedAt;

    public function __construct(
        private Email $email
    ) {
        $this->id = (string) Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPostedAt(): ?DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(DateTimeImmutable $postedAt): void
    {
        $this->postedAt = $postedAt;
    }
}
