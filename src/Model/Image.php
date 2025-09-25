<?php

namespace Pantono\Images\Model;

use Pantono\Storage\Model\StoredFile;
use Pantono\Contracts\Attributes\Locator;
use Pantono\Storage\FileStorage;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Images\Images;

class Image
{
    use SavableModel;

    private ?int $id = null;
    #[Locator(methodName: 'getFileById', className: FileStorage::class), FieldName('file_id')]
    private StoredFile $file;
    private \DateTimeImmutable $dateCreated;
    private bool $deleted;
    private int $width;
    private int $height;
    private ?string $mimeType = null;
    /**
     * @var ImageSize[]
     */
    #[Locator(methodName: 'getSizesForImage', className: Images::class), FieldName('$this')]
    private array $sizes = [];

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

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
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

    public function getSizes(): array
    {
        return $this->sizes;
    }

    /**
     * @param ImageSize[] $sizes
     */
    public function setSizes(array $sizes): void
    {
        $this->sizes = $sizes;
    }

    public function getSizeByType(ImageSizeType $type):?ImageSize
    {
        foreach ($this->sizes as $size) {
            if ($size->getType()->getId() === $type->getId()) {
                return $size;
            }
        }
        return null;
    }
}
