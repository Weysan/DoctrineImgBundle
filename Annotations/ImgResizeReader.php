<?php
namespace Weysan\DoctrineImgBundle\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Util\Inflector;
/**
 * Read all annotations about the resize picture
 *
 * @author Raphaël GONCALVES <raphael@couleur-citron.com>
 */
class ImgResizeReader 
{
    public static function hydrateObject($entityClass, $data)
    {
            $reader = new AnnotationReader();
            $reflectionObj = new \ReflectionObject(new $entityClass);
            $aAnnotations = array();
            foreach($data as $key => $value) {

                    $property = Inflector::camelize($key);
                    if($reflectionObj->hasProperty($property)) {
                            $reflectionProp = new \ReflectionProperty($entityClass, $property);
                            $relation = $reader->getPropertyAnnotation($reflectionProp, 'Weysan\\DoctrineImgBundle\\Annotations\\ImgResize');

                            if($relation) {
                                $aAnnotations[] = array( 0 => $relation->getVars(), 1 => $property );
                            }
                    }
            }
            //var_dump( $data );
            return $aAnnotations;
            return false;
    }
}
