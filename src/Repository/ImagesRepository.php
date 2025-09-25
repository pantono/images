<?php

namespace Pantono\Images\Repository;

use Pantono\Database\Repository\MysqlRepository;
use Pantono\Images\Model\Image;
use Pantono\Contracts\Locator\UserInterface;
use Pantono\Images\Model\ImageHistory;
use Pantono\Images\Model\ImageSize;

class ImagesRepository extends MysqlRepository
{
    public function getImageById(int $id): ?array
    {
        return $this->selectSingleRow('image', 'id', $id);
    }

    public function getSizesForImage(Image $image): array
    {
        return $this->selectRowsByValues('image_size', ['image_id' => $image->getId()]);
    }

    public function getHistoryForImage(Image $image): array
    {
        return $this->selectRowsByValues('image_history', ['image_id' => $image->getId()], 'date DESC');
    }

    public function saveImage(Image $image): void
    {
        $id = $this->insertOrUpdate('image', 'id', $image->getId(), $image->getAllData());
        if ($id) {
            $image->setId($id);
        }
    }

    public function saveImageSize(ImageSize $imageSize): void
    {
        $id = $this->insertOrUpdate('image_size', 'id', $imageSize->getId(), $imageSize->getAllData());
        if ($id) {
            $imageSize->setId($id);
        }
    }

    public function saveHistory(ImageHistory $imageHistory): void
    {
        $id = $this->insertOrUpdate('image_history', 'id', $imageHistory->getId(), $imageHistory->getAllData());
        if ($id) {
            $imageHistory->setId($id);
        }
    }

    public function getSizeTypeById(int $id): ?array
    {
        return $this->selectSingleRow('image_size_type', 'id', $id);
    }
}
