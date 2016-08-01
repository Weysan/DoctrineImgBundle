<?php
namespace Weysan\DoctrineImgBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Weysan\DoctrineImgBundle\Annotations\ImgResizeReader;
use Weysan\DoctrineImgBundle\Upload\Upload;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This file will listen doctrine events and resize pictures data.
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class UploadDoctrineListener 
{
    protected $public_path;

    public function __construct(ContainerInterface $container) {
        $config = $container->getParameter( 'weysan_doctrine_img.config' );
        $this->public_path = $config['public_root'];
    }
    
    public function prePersist( LifecycleEventArgs $args ){
        $this->uploadProcess($args);
    }
    
    public function preUpdate( LifecycleEventArgs $args ){
        
        $this->uploadProcess($args);
        
    }
    
    /**
     * This file get anotations data and will resize pictures before save new data.
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    private function uploadProcess( LifecycleEventArgs $args ){
        $entity = $args->getEntity();

        /* get Entities annotation's data */
        $aAnnotations = ImgResizeReader::hydrateObject(get_class( $entity ), $entity);
        foreach( $aAnnotations as $annotation ){
            if( !empty($annotation[0]) ){
                $sGetterImg = "get" .  ucfirst( $annotation[1] ) ;
                $oResize = new Upload( $annotation[0], $entity->$sGetterImg(), $this->public_path );
                $newImgName = $oResize->getImgNewName();
                $setterProperty = 'set' . ucfirst( $annotation[0]->saveField );
                if( $newImgName!= '' && !is_null( $newImgName ) ) $entity->$setterProperty( $newImgName );
            }
        }
    }
}
