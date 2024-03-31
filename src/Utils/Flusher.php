<?php

namespace App\Utils;

use App\Interface\FlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

class Flusher implements FlusherInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}