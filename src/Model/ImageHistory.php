<?php

namespace Pantono\Images\Model;

use Pantono\Contracts\Locator\UserInterface;
use Pantono\Database\Traits\SavableModel;

class ImageHistory
{
    use SavableModel;

    private ?int $id = null;
    private int $imageId;
    private \DateTimeImmutable $date;
    private UserInterface $user;
    private string $entry;

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

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getEntry(): string
    {
        return $this->entry;
    }

    public function setEntry(string $entry): void
    {
        $this->entry = $entry;
    }
}
