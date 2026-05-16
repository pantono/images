<?php

namespace Pantono\Images\Model;

use Pantono\Storage\Model\StoredFile;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Attributes\EagerLoad;
use Pantono\Contracts\Attributes\Database\OneToOne;

#[DatabaseTable(table: 'image_size', idColumn: 'id'), EagerLoad]
class ImageSize implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private int $imageId;
    #[FieldName('size_type_id'), OneToOne(targetModel: ImageSizeType::class)]
    private ?ImageSizeType $type = null;
    #[FieldName('file_id'), OneToOne(targetModel: StoredFile::class)]
    private ?StoredFile $file = null;
    private \DateTimeImmutable $dateCreated;
    private int $width;
    private int $height;

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

    public function getType(): ?ImageSizeType
    {
        return $this->type;
    }

    public function setType(?ImageSizeType $type): void
    {
        $this->type = $type;
    }

    public function getFile(): ?StoredFile
    {
        return $this->file;
    }

    public function setFile(?StoredFile $file): void
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
}
