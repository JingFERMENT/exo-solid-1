<?php

// class for image resizer 

interface ImageResizerInterface
{

    public function ImageResizer(string $origin, string $destination, int $width, int $maxHeight);
}

class ImageResizer implements ImageResizerInterface
{
    public function ImageResizer(string $origin, string $destination, int $width, int $maxHeight)
    {
        
    }
}
