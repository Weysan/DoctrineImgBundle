<?php
namespace Weysan\DoctrineImgBundle\Upload\Transformation\Jpg;

use Weysan\DoctrineImgBundle\Upload\Transformation\Transformation;
use Weysan\DoctrineImgBundle\Upload\Transformation\FormatInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Transform a JPG image
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Jpg implements FormatInterface
{
    
    protected $source;
    
    protected $transformation;
    
    protected $crop;
    
    public function __construct(UploadedFile $image, $width, $height, $strict = true, $crop = false)
    {
        
        $this->source = imagecreatefromjpeg($image); // La photo est la source
        
        $this->transformation = new Transformation($this->source);
        $this->transformation->destinationSize($width, $height, $strict);
        
        $this->crop = $crop;
    }
    
    /**
     * Save the thumb file
     * 
     * @param string $uploadDir the directory where the file will be upload
     * @param string $filename the final filename
     */
    public function saveFile($uploadDir, $filename)
    {
        
        /**
         * Save the JPG file
         */
        $img_saved = imagejpeg(
                $this->transformation->transform($this->crop), 
                $uploadDir . '/' . $filename
                );
        
        if(!$img_saved)
            throw new \Exception('The image can\'t be saved.');
        
        return $filename;
    }
}
