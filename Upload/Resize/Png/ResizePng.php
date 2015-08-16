<?php
namespace Weysan\DoctrineImgBundle\Upload\Resize\Png;

use Weysan\DoctrineImgBundle\Upload\Resize\ImageCommon;
use Weysan\DoctrineImgBundle\Upload\Resize\FormatInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Resize a PNG File
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class ResizePng extends ImageCommon implements FormatInterface
{
    public function __construct(UploadedFile $image, $width, $height)
    {
        $this->source = imagecreatefrompng($image); // La photo est la source
        
        if(!$this->source)
            throw new \Exception('The image source doesn\'t exist.');
        
        $this->destination = imagecreatetruecolor((int)$width, (int)$height); // On crée la miniature vide
    }
    
    /**
     * Save the thumb file
     * 
     * @param string $uploadDir the directory where the file will be upload
     * @param string $filename the final filename
     */
    public function saveFile($uploadDir, $filename)
    {
        
        $sizes = $this->getSizes();
        
        $resize_pic = imagecopyresampled(
                    $this->destination, 
                    $this->source, 
                    0, 
                    0, 
                    0, 
                    0, 
                    $sizes['destination']['x'], 
                    $sizes['destination']['y'], 
                    $sizes['source']['x'], 
                    $sizes['source']['y']
                );
        
        if(!$resize_pic)
            throw new \Exception('The redimensionned image can\t be created.');
        
        imagesavealpha($this->destination, true);
        $color = imagecolorallocatealpha($this->destination, 0, 0, 0, 127);
        imagefill($this->destination, 0, 0, $color);
        
        /**
         * Save the PNG file
         */
        $img_saved = imagepng(
                $this->destination, 
                $uploadDir . '/' . $filename
                );
        
        if(!$img_saved)
            throw new \Exception('The image can\'t be saved.');
        
        return $filename;
    }
}
