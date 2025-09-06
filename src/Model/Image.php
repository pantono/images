<?php

namespace Pantono\Images\Model;

use Pantono\Storage\Model\StoredFile;
use Pantono\Contracts\Attributes\Locator;
use Pantono\Storage\FileStorage;
use Pantono\Database\Traits\SavableModel;

class Image
{
    use SavableModel;

    private ?int $id = null;
    private StoredFile $file;
    private \DateTimeImmutable $dateCreated;
    private bool $deleted;
    private ?string $mimeType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFile(): StoredFile
    {
        return $this->file;
    }

    public function setFile(StoredFile $file): void
    {
        $this->file = $file;
    }

    public function getDateCreated(): \DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeImmutable $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getUrl(): ?string
    {
        return $this->getFile()->getUri();
    }
}
