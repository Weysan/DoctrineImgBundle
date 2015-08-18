<?php
namespace Weysan\DoctrineImgBundle\Tests\Upload;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Weysan\DoctrineImgBundle\Upload\Upload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Upload a file from annpotation informations
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class UploadTests extends WebTestCase
{
    
    private $dir_test;
    
    private $file_test = 'img_test.jpg';
    
    public function setUp()
    {
        $this->dir_test = __DIR__ . '/../pics/';
        
        if(!is_dir($this->dir_test . 'changesize/')){
            mkdir($this->dir_test . 'changesize/');
        }
    }
    
    public function tearDown()
    {
        $base_path = $this->dir_test . 'changesize/';
        
        $scan = scandir($base_path);
        
        foreach($scan as $file){
            if(!is_dir($base_path.$file)){
                unlink($base_path.$file);
            }
        }
        
        rmdir($base_path);
    }
    
    private function getMockAnnotation($width, $height)
    {
        $stub = $this->getMockBuilder('Weysan\DoctrineImgBundle\Annotations\ImgResize')
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $stub->width = $width;
        $stub->height = $height;
        $stub->uploadDir = $this->dir_test . 'changesize/';
        
        return $stub;
    }
    
    public function testUploadFile()
    {
        $base_path = $this->dir_test . 'changesize/';
        
        $annotations = $this->getMockAnnotation(200, 150);
        
        //$imageToUpload = $this->dir_test . $this->file_test;
        
        $imageToUpload = new UploadedFile($this->dir_test . $this->file_test, $this->file_test);
        
        $upload = new Upload($annotations, $imageToUpload);
        
        $this->assertTrue(file_exists($base_path.$upload->path));
        
        list($largeur, $hauteur) = getimagesize($base_path.$upload->path);
        
        list($largeur_init, $hauteur_init) = getimagesize($base_path.'../'.$this->file_test);
        
        $this->assertNotEquals('200150', $largeur_init.$hauteur_init);
        
        $this->assertEquals('200150', $largeur.$hauteur);
    }
}
