<?php
namespace Weysan\DoctrineImgBundle\Tests\Annotations;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Weysan\DoctrineImgBundle\Annotations\ImgResizeReader;
use Weysan\DoctrineImgBundle\Tests\Entity\Article;
/**
 * Test the annotation reader
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class ImgResizeReaderTests extends WebTestCase 
{
    function testAnnotationRead()
    {
        $entity = new Article();
        
        $reader = ImgResizeReader::hydrateObject(get_class($entity), $entity);
        
        $this->assertEquals(count($reader), 1); //nb annotations
        
        $this->assertInstanceOf('Weysan\DoctrineImgBundle\Annotations\ImgResize', $reader[0][0]); //annotation class
        
        $this->assertEquals($reader[0][1], 'image'); //annotation field
        
        //resize property check
        $resize = $reader[0][0];
        
        $this->assertEquals($resize->width, 500);
        
        $this->assertEquals($resize->height, 300);
        
        $this->assertEquals($resize->uploadDir, 'media/upload/article');
        
        $this->assertEquals($resize->saveField, 'path');
        
        $this->assertEquals($resize->value, 'image');
        
    }
}
