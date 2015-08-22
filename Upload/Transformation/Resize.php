<?php
namespace Weysan\DoctrineImgBundle\Upload\Transformation;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Weysan\DoctrineImgBundle\Upload\Transformation\Jpg\Jpg;
use Weysan\DoctrineImgBundle\Upload\Transformation\Png\Png;
/**
 * This class will resize an image
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Resize {
    /**
     * Get an resize instance
     * 
     * @param UploadedFile $image
     * @param integer $width
     * @param integer $height
     * @return FormatInterface
     * @throws \Exception
     */
    public static function getFormatInstance(UploadedFile $image, $width, $height, $strict = true, $crop = false)
    {   
        switch($image->guessExtension()){
            case 'jpeg':
            case 'jpg':
                return new Jpg($image, $width, $height, $strict, $crop);
                break;
            case 'png':
                return new Png($image, $width, $height, $strict, $crop);
                break;
            default:
                throw new \Exception('Image extension not supported.');
                break;
        }
    }
}
