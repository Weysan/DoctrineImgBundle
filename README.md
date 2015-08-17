# DoctrineImgBundle
Create a thumbnail after uploading an image through a form in a Symfony2 project

## Install the bundle
Using composer :

`composer require weysan/doctrine-img-bundle`

Enable the bundle in the app\AppKernel.php :

`$bundles = array(
            ...,
            new Weysan\DoctrineImgBundle\WeysanDoctrineImgBundle(),
            ...,
        );`
        
Import the configuration file in your app\config\config.yml :
`imports:
    - { resource: "@WeysanDoctrineImgBundle/Resources/config/services.yml" }`
    
## How to use it ?
Create your doctrine entity, and put the annotation :

`@ImgResize("image", width="500", height="300", uploadDir="media/upload/article", saveField="path")`

- image : the field where you put the annotation
- width : the thumbnail's width
- height : the thumbnail's height
- uploadDir : the directory where to put the thumbnail (in the public directory)
- saveField : the entity's field where to save the thumbnail's name
