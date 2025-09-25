<?php

namespace Pantono\Images\Model;

use Pantono\Storage\Model\StoredFile;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\Locator;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Storage\FileStorage;
use Pantono\Images\Images;

class ImageSize
{
    use SavableModel;

    private ?int $id = null;
    private int $imageId;
    #[Locator(methodName: 'getSizeTypeById', className: Images::class), FieldName('size_type_id')]
    private ImageSizeType $type;
    #[Locator(methodName: 'getFileById', className: FileStorage::class), FieldName('file_id')]
    private StoredFile $file;
    private \DateTimeImmutable $dateCreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getImageId(): int
    {
        return $this->imageId;
    }

    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function getType(): ImageSizeType
    {
        return $this->type;
    }

    public function setType(ImageSizeType $type): void
    {
        $this->type = $type;
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
}
