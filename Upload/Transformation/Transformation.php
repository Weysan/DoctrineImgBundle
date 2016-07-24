<?php
namespace Weysan\DoctrineImgBundle\Upload\Transformation;

/**
 * Common image transformation
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Transformation 
{
    
    private $source;
    
    private $destination;
    
    public function __construct($image_source) 
    {
        $this->source = $image_source;
    }
    
    /**
     * If force = true => the miniature will have that size
     * If force = false => The miniature will have that maximum size (keeping proportions)
     * 
     * 
     * @param integer $width
     * @param integer $height
     * @param boolean $strict strict size or maximum size
     * 
     */
    public function destinationSize($width, $height, $strict = true)
    {
        if($strict){
            $this->destination = imagecreatetruecolor((int)$width, (int)$height);
        } else {
            $this->getDestinationSizeProportionized($width, $height);
        }
    }
    
    /**
     * Create a proportional destination size
     * 
     * @param integer $width
     * @param integer $height
     * @throws \Exception
     */
    private function getDestinationSizeProportionized($width, $height)
    {
        $width_source = \imagesx($this->source);
        $height_source = \imagesy($this->source);
        
        if(!$width_source || !$height_source)
            Throw new \Exception('Can\'t get source size.');
        
        $width_coeff = (int)$width / (int)$width_source;
        $height_coeff = (int)$height / (int)$height_source;
        
        $coeff = min(array($width_coeff, $height_coeff));
        
        $dest_height = $height_source * $coeff;
        $dest_width = $width_source * $coeff;
        
        $this->destination = imagecreatetruecolor((int)$dest_width, (int)$dest_height);
    }
    
    /**
     * Return pixels to crop in the source image
     * 
     * @return boolean|array
     * @throws \Exception
     */
    private function getPixelsToCrop()
    {
        $width_source = \imagesx($this->source);
        $height_source = \imagesy($this->source);
        
        $width = \imagesx($this->destination);
        $height = \imagesy($this->destination);
        
        if(!$width_source || !$height_source)
            Throw new \Exception('Can\'t get source size.');
        
        $width_coeff = (int)$width / (int)$width_source;
        $height_coeff = (int)$height / (int)$height_source;
        
        $coeff = max(array($width_coeff, $height_coeff));
        
        $dest_height = $height_source * $coeff;
        $dest_width = $width_source * $coeff;
        
        if($dest_height > $height){
            $topCrop = ( $dest_height - $height ) /  ( 2 * $coeff);
            return array('top' => $topCrop);
        } elseif($dest_width > $width){
            $leftCrop = ( $dest_width - $width ) / ( 2 * $coeff);
            return array('left' => $leftCrop);
        } else {
            return false;
        }
    }
    
    /**
     * Crop and transform the destination image
     * 
     * @return mixed false or destination image resource
     */
    private function cropTransformation()
    {
        
        $aPixelsToCrop = $this->getPixelsToCrop();
        
        $crop_left = isset($aPixelsToCrop['left'])?$aPixelsToCrop['left']:0;
        $crop_top = isset($aPixelsToCrop['top'])?$aPixelsToCrop['top']:0;
        
        $width_source = \imagesx($this->source) - ($crop_left*2);
        $height_source = \imagesy($this->source) - ($crop_top*2);
        
        
        $transformation = imagecopyresampled(
                    $this->destination,
                    $this->source,
                    0,
                    0,
                    $crop_left,
                    $crop_top,
                    \imagesx($this->destination),
                    \imagesy($this->destination),
                    $width_source,
                    $height_source
                );
        
        if(!$transformation)
            return false;
        else
            return $this->destination;
    }
    
    /**
     * Copy the source image into the destination image
     * 
     * @return mixed false or destination image resource
     */
    public function transform($crop = false)
    {
        
        if($crop)
            return $this->cropTransformation();
        
        $transformation = imagecopyresampled(
                    $this->destination,
                    $this->source,
                    0,
                    0, 
                    0,
                    0,
                    \imagesx($this->destination),
                    \imagesy($this->destination),
                    \imagesx($this->source),
                    \imagesy($this->source)
                );
        
        if(!$transformation)
            return false;
        else
            return $this->destination;
    }
    
}
