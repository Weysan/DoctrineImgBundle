<?php
namespace Weysan\DoctrineImgBundle\Tests\Upload\Resize;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Weysan\DoctrineImgBundle\Upload\Resize\Resize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Test resize image
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class ResizeTests extends WebTestCase
{
    
    private $dir_test;
    
    private $file_test = 'img_test.jpg';
    
    private $file_test_png = 'logo-test.png';
    
    public function setUp()
    {
        $this->dir_test = __DIR__ . '/../../pics/';
        
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
    
    
    public function testResizePics()
    {
        
        $uploadedFile = new UploadedFile($this->dir_test . $this->file_test, $this->file_test);
        
        
        $resize = Resize::getFormatInstance($uploadedFile, 200, 150);
        
        $base_path = $this->dir_test . 'changesize/';
        
        $resize->saveFile($base_path, 'autre.jpg');
        
        $this->assertTrue(file_exists($base_path.'autre.jpg'));
        
        list($largeur, $hauteur) = getimagesize($base_path.'autre.jpg');
        
        list($largeur_init, $hauteur_init) = getimagesize($base_path.'../'.$this->file_test);
        
        $this->assertNotEquals('200150', $largeur_init.$hauteur_init);
        
        $this->assertEquals('200150', $largeur.$hauteur);
        
    }
    
    
    public function testResizePicsPng()
    {
        
        $uploadedFile = new UploadedFile($this->dir_test . $this->file_test_png, $this->file_test_png);
        
        
        $resize = Resize::getFormatInstance($uploadedFile, 200, 150);
        
        $base_path = $this->dir_test . 'changesize/';
        
        $resize->saveFile($base_path, 'autre.png');
        
        $this->assertTrue(file_exists($base_path.'autre.png'));
        
        list($largeur, $hauteur) = getimagesize($base_path.'autre.png');
        
        list($largeur_init, $hauteur_init) = getimagesize($base_path.'../'.$this->file_test_png);
        
        $this->assertNotEquals('200150', $largeur_init.$hauteur_init);
        
        $this->assertEquals('200150', $largeur.$hauteur);
        
    }
    
}
