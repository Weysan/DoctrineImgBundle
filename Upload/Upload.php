<?php
namespace Weysan\DoctrineImgBundle\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Weysan\DoctrineImgBundle\Annotations\ImgResize;
use Weysan\DoctrineImgBundle\Upload\Transformation\Resize;
/**
 * This class will upload and resize all files.
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Upload 
{
    private $image;
    
    public $path;
    
    private $destinationDir;
    
    private $width;
    
    private $height;
    
    private $strict = true;
    
    private $crop = false;
    
    private $publicDir;
    
    
    function __construct(ImgResize $annotations, UploadedFile $imageToUpload = null, $public_path = null ){
        
        $this->destinationDir = $annotations->uploadDir;
		if($annotations->uploadDirDate) {
            $this->destinationDir = $annotations->uploadDir . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR;
        }
        
        $this->width = $annotations->width;
        $this->height = $annotations->height;
        if(!is_null($annotations->strict)) $this->strict = $annotations->strict;
        if(!is_null($annotations->crop)) $this->crop = $annotations->crop;
        
        $this->image = $imageToUpload;
        
        if(null !== $this->image){
            $this->setPublicDir($public_path);
        
            $this->preUpload();
            $this->upload();
        }
    }
    
    /**
     * Return the new name file
     * @return string
     */
    public function getImgNewName(){
        return $this->path;
    }
    
    /**
     * Return the new absolute path
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    
    /**
     * Return the new public path
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }
    
    /**
     * Get the root upload directory
     * Carefull : We have to change the public directory...
     * @return string
     */
    protected function getUploadRootDir()
    {
        $path = realpath($this->publicDir.'/'.$this->getUploadDir());
        
        if(!$path)
            throw new \Exception('The upload directory doesn\'t exist: ' . $this->publicDir.'/'.$this->getUploadDir());
        
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return $path;
    }
    
    public function setPublicDir($public_dir)
    {
        if(!$public_dir)
            throw new \Exception('The directory public doesn\'t exist');
        
        $this->publicDir = $public_dir;
    }
    
    /**
     * Return the upload directory (without __DIR__ )
     * @return string
     */
    protected function getUploadDir()
    {
        return $this->destinationDir;
    }
    
    
    /**
     * Set a new name for upload file
     */
    public function preUpload()
    {
        if (null !== $this->image && $this->image != '' ) {
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->image->guessExtension();
        }
    }
    
    /**
     * resize the file before upload it
     */
    public function upload()
    {
        if (null === $this->image) {
            return;
        }
        
        //resize and upload
        $resize = Resize::getFormatInstance($this->image, $this->width, $this->height, $this->strict, $this->crop);
        $file = $resize->saveFile($this->getUploadDir(), $this->path);
        
        //$this->resizeFileUploaded($this->width, $this->height);
        
        unset($this->image);
        
        return $file;
    }
}
