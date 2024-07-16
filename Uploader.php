<?php

require_once(__DIR__ . '/ImageResizer.php');
require_once(__DIR__ . '/FileInformation.php');


interface UploaderInterface
{

    public function getExtension(string $extension): string;

    public function isValid(string $extension): bool;
}


class Uploader
{
    private $name;
    private $type;
    private $temporaryName;
    public $directory = '';
    private $error = '';
    public $validTypes = [];


    public function __construct(array $file)
    {
        $fileData = $_FILES[$file];
        $this->temporaryName = $fileData['tmp_name'];
        $this->name = $fileData['name'];
        $this->type = $fileData['type'];
    }

    public function uploadFile(): bool
    {
        $extensionDetector = new ExtensionDetector();

        if ($extensionDetector->isValid($this->type)) {

            $this->error = 'Le fichier ' . $this->name . ' n\'est pas d\'un type valide';

            return false;
        } else {

            return true;
        }
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getExtension() {

        $fileInformation = new FileInformation();

        return $fileInformation->getExtension($this->name);

    }

    public function resize($origin, $destination, $width, $maxHeight)
    {
        $imageResizer = new ImageResizer();
        
        return $imageResizer->resize($this->getExtension(), $origin, $destination, $width, $maxHeight);
    }
}
