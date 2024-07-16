<?php

// class for file type validation 

interface ExtensionDetectorInterface
{

    public function getExtension(string $extension): string;

    public function isValid(string $extension): bool;
}

// file type validation 

class ExtensionDetector implements ExtensionDetectorInterface
{

    const PNG_FAMILY = ['PNG', 'png'];
    const JPEG_FAMILY = ['jpeg', 'jpg', 'JPG'];

    public function getExtension(string $extension): string
    {
        if (in_array($extension, self::PNG_FAMILY)) {
            $extension = 'jpeg';
        } elseif (in_array($extension, self::JPEG_FAMILY)) {
            $extension = 'png';
        }
        return $extension;
    }

    public function isValid(string $extension): bool
    {
        $validExtensions = array_merge(self::JPEG_FAMILY, self::PNG_FAMILY);

        return in_array($extension, $validExtensions);
    }
}
