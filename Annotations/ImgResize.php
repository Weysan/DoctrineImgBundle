<?php
namespace Weysan\DoctrineImgBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;
/**
 * @Annotation
 * @Target({"PROPERTY"})
 * 
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class ImgResize extends Annotation 
{
    
    public $width;
    
    public $height;

    public $uploadDir;

    public $maxHeight;

    public $maxWidth;

    public $minHeight;

    public $minWidth;

    public $saveField;

    /**
     * Returns all annotations data
     * 
     * @return \Weysan\DoctrineImgBundle\Annotations\ImgResize
     */
    public function getVars(){
        return $this;
    }
}
