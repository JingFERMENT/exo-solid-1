<?php

require_once('ExtensionDetector.php');

// class for image resizer 

interface ImageResizerInterface
{

    public function resize(string $extension, string $origin, string $destination, int $width, int $maxHeight);
}

class ImageResizer implements ImageResizerInterface
{
    public function resize(string $extension, string $origin, string $destination, int $width, int $maxHeight)
    {
        
        $extensionDetector = new ExtensionDetector();
        $extension = $extensionDetector->getExtension($extension);
        $function = 'imagecreatefrom' . $extension;

        if (!is_callable($function)) {
            return false;
        }

        $image = $function($origin);

        $imageWidth = \imagesx($image);
        if ($imageWidth < $width) {
            if (!copy($origin, $destination)) {
                throw new Exception("Impossible de copier le fichier {$origin} vers {$destination}");
            }
        } else {
            $imageHeight = \imagesy($image);
            $height = (int) (($width * $imageHeight) / $imageWidth);
            if ($height > $maxHeight) {
                $height = $maxHeight;
                $width = (int) (($height * $imageWidth) / $imageHeight);
            }
            $newImage = \imagecreatetruecolor($width, $height);

            if ($newImage !== false) {
                \imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);

                $function = 'image' . $extension;

                if (!is_callable($function)) {
                    return false;
                }

                $function($newImage, $destination);

                \imagedestroy($newImage);
                \imagedestroy($image);
            }
        }
    }
}
