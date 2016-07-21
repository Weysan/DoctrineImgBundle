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
	- { resource: "@WeysanDoctrineImgBundle/Resources/config/config.yml" }
    - { resource: "@WeysanDoctrineImgBundle/Resources/config/services.yml" }</pre>
    
## How to use it ?
Create your doctrine entity, and put the annotation :

<pre>@ImgResize("image", width="500", height="300", uploadDir="media/upload/article", saveField="path", strict=true, crop=false)</pre>

- image : the field where you put the annotation
- width : the thumbnail's width
- height : the thumbnail's height
- strict : (true or false, default is true) if strict is true, the thumbnail will have the strict height and width. If strict is false, then the height and width will be the maximum size of the saved thumbnail.
- crop : (true or false, default is false) Would you like that the thumbnail could be cropped (interesting if strict is set to true)
- uploadDir : the directory where to put the thumbnail (in the public directory)
- uploadDirDate : (true or false, default is false) if the directory manages folders by date (uploadDir/YYYY/MM/)
- saveField : the entity's field where to save the thumbnail's name
