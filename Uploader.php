<?php

require_once(__DIR__.'/ImageResizer.php');
require_once(__DIR__.'/FileValidator.php');

class Uploader
{
    private $name;
    private $type;
    private $temporaryName;
    private $directory = '';
    private $validator;
    private $resizer;
    private $error = '';


    public function __construct(array $file, FileValidatorInterface $validator, ImageResizerInterface $resizer)
    {
        $this->temporaryName = $file['tmp_name'];
        $this->name = $file['name'];
        $this->type = $file['type'];
        $this->validator = $validator;
        $this->resizer = $resizer;
    }

    public function uploadFile(): bool
    {
        if ($this->validator->isValid($this->type)) {
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

    public function getExtension()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function resize(string $destination, int $width, int $maxheight): void {
        
        $this->resizer->ImageResizer($this->temporaryName, $destination, $width, $maxheight);
    }

    public function getError(): string {
        return $this->error;
    }
}


// Utilisation de l'uploader avec des validations et redimensionnements spécifiques
$file = $_FILES['file'];
$validator = new FileValidator();
$resizer = new ImageResizer();
$uploader = new Uploader($file, $validator, $resizer);

if ($uploader->uploadFile()) {
    $destination = 'uploads/' . $uploader->getName();
    $uploader->resize($destination, 800, 600);
    echo 'File uploaded and resized successfully';
} else {
    echo $uploader->getError();
}
