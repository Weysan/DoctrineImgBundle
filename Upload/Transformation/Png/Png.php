<?php
namespace Weysan\DoctrineImgBundle\Upload\Transformation\Png;

use Weysan\DoctrineImgBundle\Upload\Transformation\Transformation;
use Weysan\DoctrineImgBundle\Upload\Transformation\FormatInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Transform a png file
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Png implements FormatInterface
{
    protected $source;
    
    protected $transformation;
    
    protected $crop;
    
    public function __construct(UploadedFile $image, $width, $height, $strict = true, $crop = false)
    {
        $this->source = imagecreatefrompng($image); // La photo est la source
        
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
        $destination = $this->transformation->transform($this->crop);
        
        imagesavealpha($destination, true);
        $color = imagecolorallocatealpha($destination, 0, 0, 0, 127);
        imagefill($destination, 0, 0, $color);
        
        /**
         * Save the PNG file
         */
        $img_saved = imagepng(
                $destination, 
                $uploadDir . '/' . $filename
                );
        
        if(!$img_saved)
            throw new \Exception('The image can\'t be saved.');
        
        return $filename;
    }
}
