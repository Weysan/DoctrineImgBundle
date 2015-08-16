<?php
namespace Weysan\DoctrineImgBundle\Upload\Resize;

/**
 * Common image functions
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
abstract class ImageCommon 
{
    protected $source;
    
    protected $destination;
    
    /**
     * get source and destination file size
     * 
     * @return array
     */
    protected function getSizes()
    {
        $sizes = array();
        
        $sizes['source']['x'] = imagesx($this->source);
        $sizes['source']['y'] = imagesy($this->source);
        $sizes['destination']['x'] = imagesx($this->destination);
        $sizes['destination']['y'] = imagesy($this->destination);
        
        return $sizes;
    }
}
