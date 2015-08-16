<?php
namespace Weysan\DoctrineImgBundle\Upload\Resize;

use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 *
 * @author Raphaël GPNCALVES <contact@raphael-goncalves.fr>
 */
interface FormatInterface {
    
    public function __construct(UploadedFile $image, $width, $height);
    
    public function saveFile($uploadDir, $filename);
}
