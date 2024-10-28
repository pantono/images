<?php

namespace Pantono\Images\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Images\Model\Image;

abstract class AbstractImageSaveEvent extends Event
{
    private Image $current;
    private ?Image $previous = null;

    public function getCurrent(): Image
    {
        return $this->current;
    }

    public function setCurrent(Image $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?Image
    {
        return $this->previous;
    }

    public function setPrevious(?Image $previous): void
    {
        $this->previous = $previous;
    }
}
