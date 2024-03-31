<?php

namespace App\Model;

use App\Exception\FileIsAlreadyExistsException;
use App\Exception\ThisStatusAlreadySetException;
use App\Interface\CallFormFileDeleteInterface;
use App\Interface\CallFormFileUploadInterface;
use App\Utils\FormStatus;
use App\Utils\Services;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Uid\Uuid;

class CallForm {
    private Services $services;
    private array $files = [];
    private ?DateTimeImmutable $postedAt = null;
    private ?FormStatus $status = null;
    private string $id;

    public function __construct(
        private string $comment,
        private string $fullName,
        private string $companyName,
        private string $employeeNumber,
        private string $phone,
        private string $email,
    ) {
        $this->services = new Services([]);
        $this->id = (string) Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmployeeNumber(): string
    {
        return $this->employeeNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setServices(Services $services): void
    {
        $this->services = $services;
    }

    public function getServices(): Services
    {
        return $this->services;
    }

    /**
     * @throws FileIsAlreadyExistsException
     */
    public function addFile(
        File $file,
        CallFormFileUploadInterface $storage
    ): void {
        $fileName = $storage->upload($file, $this->getId());

        $this->files [] = $fileName;
    }

    public function removeAllFiles(
        CallFormFileDeleteInterface $storage
    ): void {
        $storage->deleteAll($this->getId());

        $this->files = [];
    }

    public function getPostedAt(): ?DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(DateTimeImmutable $postedAt): void
    {
        $this->postedAt = $postedAt;
    }

    public function getStatus(): ?FormStatus
    {
        return $this->status;
    }

    /**
     * @throws ThisStatusAlreadySetException
     */
    public function setStatus(FormStatus $status): void
    {
        if ($this->status !== null && $this->status->get() === $status->get()) {
            throw new ThisStatusAlreadySetException();
        }

        $this->status = $status;
    }
}
