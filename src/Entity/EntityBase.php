<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * EntityBase
 */
class EntityBase
{

    /**
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "image/jpg" })
     * @Assert\File(maxSize="2M")
     */
    private $document;

    /**
     * Sets document.
     *
     * @param UploadedFile $file
     */
    public function setDocument(UploadedFile $file = null)
    {
        $this->document = $file;
    }

    /**
     * Get document.
     *
     * @return UploadedFile
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return string
     */
    protected function generateUniqueFileName(): string
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    
    protected  function copyImageFileTo($newsFile,$destinationDir, $fileName): bool
    {
        if(is_dir($destinationDir))
        {
            $newsFile->move($destinationDir,$fileName);
            if (file_exists($destinationDir. DIRECTORY_SEPARATOR .$fileName)) 
            {
                return true;
            }
        }
        return false;
    }
}