<?php

namespace Pantono\Images;

use Pantono\Images\Repository\ImagesRepository;
use Pantono\Hydrator\Hydrator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Pantono\Storage\FileStorage;
use League\Flysystem\Visibility;
use Pantono\Images\Model\Image;
use Pantono\Images\Exception\ImageFilePathDoesNotExist;
use Pantono\Images\Exception\UnableToLoadImageData;
use Pantono\Images\Event\PreImageSaveEvent;
use Pantono\Images\Event\PostImageSaveEvent;
use Pantono\Images\Model\ImageSizeType;
use Pantono\Images\Model\ImageSize;
use Imagick;
use Pantono\Images\Exception\ImageMustByCreatedFirst;
use Pantono\Storage\Model\StoredFile;

class Images
{
    private ImagesRepository $repository;
    private Hydrator $hydrator;
    private EventDispatcher $dispatcher;
    private FileStorage $fileStorage;

    public function __construct(ImagesRepository $repository, Hydrator $hydrator, EventDispatcher $dispatcher, FileStorage $fileStorage)
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->dispatcher = $dispatcher;
        $this->fileStorage = $fileStorage;
    }

    public function getImageById(int $id): ?Image
    {
        return $this->hydrator->hydrate(Image::class, $this->repository->getImageById($id));
    }

    public function uploadNewImageFromString(string $imageData, string $filename): Image
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, $imageData);
        return $this->uploadImageFromPath($path);
    }

    public function uploadImageFromPath(string $imagePath, ?string $filename = null): Image
    {
        if (!file_exists($imagePath)) {
            throw new ImageFilePathDoesNotExist('Path does not exist');
        }
        if ($filename === null) {
            $filename = basename($imagePath);
        }
        $fileData = file_get_contents($imagePath);
        if ($fileData === false) {
            throw new UnableToLoadImageData('Unable to load image data');
        }
        $file = $this->fileStorage->uploadFile($filename, $fileData, true, Visibility::PUBLIC);
        $image = new Image();
        $image->setFile($file);
        $image->setDateCreated(new \DateTimeImmutable());
        $image->setDeleted(false);
        $mime = $this->detectMimeType($imagePath);
        $size = $this->getImageSizeFromFile($imagePath);
        $image->setWidth($size['width']);
        $image->setHeight($size['height']);
        if ($mime) {
            $image->setMimeType($mime);
        }
        $this->saveImage($image);
        return $image;
    }

    public function createImageFromStoredFile(StoredFile $file): Image
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . str_replace('\\', '__', $file->getFilename());
        $this->fileStorage->hydrateFileData($file);
        if (empty($file->getFileData())) {
            throw new \RuntimeException('File is not an image');
        }
        file_put_contents($path, $file->getFileData());
        $image = new Image();
        $image->setFile($file);
        $image->setDateCreated(new \DateTimeImmutable());
        $image->setDeleted(false);
        $mime = $this->detectMimeType($path);
        $size = $this->getImageSizeFromFile($path);
        $image->setWidth($size['width']);
        $image->setHeight($size['height']);
        if ($mime) {
            $image->setMimeType($mime);
        }
        $this->saveImage($image);
        return $image;
    }

    public function saveImage(Image $image): void
    {
        $previous = $image->getId() ? $this->getImageById($image->getId()) : null;

        $event = new PreImageSaveEvent();
        $event->setPrevious($previous);
        $event->setCurrent($image);
        $this->dispatcher->dispatch($event);

        $this->repository->saveImage($image);

        $event = new PostImageSaveEvent();
        $event->setCurrent($image);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);
    }

    public function createSizeForImage(Image $image, ImageSizeType $imageSizeType): ImageSize
    {
        if ($image->getId() === null) {
            throw new ImageMustByCreatedFirst('Image must be saved before creating a new size');
        }
        $imageSize = new ImageSize();
        $imageSize->setImageId($image->getId());
        $imageSize->setType($imageSizeType);
        $imageSize->setDateCreated(new \DateTimeImmutable());
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $image->getFile()->getFilename();
        file_put_contents($path, $image->getFile()->getFileData());
        $newPath = $this->performResize($path, $imageSizeType->getWidth(), $imageSizeType->getHeight());
        $contents = file_get_contents($newPath);
        if ($contents === false) {
            throw new UnableToLoadImageData('Unable to load image data for resize');
        }
        $this->fileStorage->uploadFile($newPath, $contents);
        return $imageSize;
    }

    public function performResize(string $sourcePath, int $newWidth, int $newHeight): string
    {
        if (!file_exists($sourcePath)) {
            throw new ImageFilePathDoesNotExist('Image path does not exist for resize');
        }
        $info = getimagesize($sourcePath);
        if ($info === false) {
            throw new UnableToLoadImageData('Unable to read image information.');
        }
        $im = new \Imagick($sourcePath);
        $im->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
        $dir = pathinfo($sourcePath, PATHINFO_DIRNAME);
        $file = pathinfo($sourcePath, PATHINFO_FILENAME);
        $path = $dir . DIRECTORY_SEPARATOR . $newHeight . 'x' . $newHeight . $file;
        $im->writeImage($path);
        if (!file_exists($path)) {
            throw new \RuntimeException('Unable to write image size');
        }
        return $path;
    }

    private function detectMimeType(string $filename): ?string
    {
        $fInfo = finfo_open(FILEINFO_MIME_TYPE);
        if (!$fInfo) {
            return null;
        }
        return finfo_file($fInfo, $filename) ?: null;
    }

    /**
     * @return array{width: int, height: int}
     * @throws \ImagickException
     */
    private function getImageSizeFromFile(string $path): array
    {
        $im = new \Imagick($path);
        return ['width' => $im->getImageWidth(), 'height' => $im->getImageHeight()];
    }
}
