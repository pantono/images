<?php

namespace Pantono\Images\Model;

use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\DatabaseTable;

#[DatabaseTable(table: 'image_size_type', idColumn: 'id')]
class ImageSizeType implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private string $name;
    private int $height;
    private int $width;
    private bool $bestFit;
    private ?string $outputType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function isBestFit(): bool
    {
        return $this->bestFit;
    }

    public function setBestFit(bool $bestFit): void
    {
        $this->bestFit = $bestFit;
    }

    public function getOutputType(): ?string
    {
        return $this->outputType;
    }

    public function setOutputType(?string $outputType): void
    {
        $this->outputType = $outputType;
    }
}
