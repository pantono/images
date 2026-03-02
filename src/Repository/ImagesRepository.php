<?php

namespace Pantono\Images\Repository;

use Pantono\Database\Repository\DefaultRepository;
use Pantono\Images\Model\Image;
use Pantono\Images\Model\ImageHistory;
use Pantono\Images\Model\ImageSize;
use Doctrine\DBAL\ArrayParameterType;

class ImagesRepository extends DefaultRepository
{
    public function getImageById(int $id): ?array
    {
        return $this->selectSingleRow('image', 'id', $id);
    }

    public function getSizesForImage(Image $image): array
    {
        return $this->selectRowsByValues('image_size', ['image_id' => $image->getId()]);
    }

    /**
     * @param array<int,int> $ids
     * @return array<int, mixed>
     */
    public function getSizesForImages(array $ids): array
    {
        $select = $this->getDb()->select('is')->from('image_size', 'is')
            ->where('is.image_id in (:ids)')
            ->setParameter('ids', $ids, ArrayParameterType::INTEGER);

        return $this->getDb()->fetchAll($select);
    }

    public function getHistoryForImage(Image $image): array
    {
        return $this->selectRowsByValues('image_history', ['image_id' => $image->getId()], 'date DESC');
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

    public function getSizeById(int $id): ?array
    {
        return $this->selectSingleRow('image_size', 'id', $id);
    }

    public function deleteImageSize(ImageSize $size): void
    {
        $this->getDb()->delete('image_size', ['id=?' => $size->getId()]);
    }
}
