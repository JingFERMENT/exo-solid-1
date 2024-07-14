<?php 

// class for file type validation 

interface FileValidatorInterface {

    public function isValid (string $type) : bool;

}

// file type validation 

class FileValidator implements FileValidatorInterface {

    private $validTypes = ['image/png', 'image/jpeg'];

    public function isValid (string $type): bool {
        
        return in_array($type, $this->validTypes);
    }
}