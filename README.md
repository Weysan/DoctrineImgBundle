# DoctrineImgBundle
Create a thumbnail after uploading an image through a form in a Symfony2 project

## Install the bundle
Using composer :

<pre>composer require weysan/doctrine-img-bundle</pre>

Enable the bundle in the app\AppKernel.php :

<pre>$bundles = array(
            ...,
            new Weysan\DoctrineImgBundle\WeysanDoctrineImgBundle(),
            ...,
        );</pre>
        
Import the configuration file in your app\config\config.yml :
<pre>imports:
    - { resource: "@WeysanDoctrineImgBundle/Resources/config/services.yml" }</pre>
    
## How to use it ?
Create your doctrine entity, and put the annotation :

<pre>@ImgResize("image", width="500", height="300", uploadDir="media/upload/article", saveField="path")</pre>

- image : the field where you put the annotation
- width : the thumbnail's width
- height : the thumbnail's height
- uploadDir : the directory where to put the thumbnail (in the public directory)
- saveField : the entity's field where to save the thumbnail's name
