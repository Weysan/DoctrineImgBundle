<?php
namespace Weysan\DoctrineImgBundle\Upload\Resize;

use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * This class will resize an image
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Resize {
    
    private $source;
    
    private $destination;
    
    public function __construct(UploadedFile $image, $width, $height)
    {
        $this->source = imagecreatefromjpeg($image); // La photo est la source
        
        if(!$this->source)
            throw new \Exception('The image source doesn\'t exist.');
        
        $this->destination = imagecreatetruecolor((int)$width, (int)$height); // On crée la miniature vide
    }
    
    /**
     * get source and destination file size
     * 
     * @return array
     */
    private function getSizes()
    {
        $sizes = array();
        
        $sizes['source']['x'] = imagesx($this->source);
        $sizes['source']['y'] = imagesy($this->source);
        $sizes['destination']['x'] = imagesx($this->destination);
        $sizes['destination']['y'] = imagesy($this->destination);
        
        return $sizes;
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
        
        /**
         * Save the JPG file
         */
        $img_saved = imagejpeg(
                $this->destination, 
                $uploadDir . '/' . $filename
                );
        
        if(!$img_saved)
            throw new \Exception('The image can\'t be saved.');
        
        return $filename;
    }
}
