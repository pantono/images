<?php

namespace Pantono\Images\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Images\Model\ImageSize;

abstract class AbstractImageSizeSaveEvent extends Event
{
    private ImageSize $current;
    private ?ImageSize $previous = null;

    public function getCurrent(): ImageSize
    {
        return $this->current;
    }

    public function setCurrent(ImageSize $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?ImageSize
    {
        return $this->previous;
    }

    public function setPrevious(?ImageSize $previous): void
    {
        $this->previous = $previous;
    }
}
