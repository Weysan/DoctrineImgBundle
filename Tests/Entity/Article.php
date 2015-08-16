<?php
namespace Weysan\DoctrineImgBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Weysan\DoctrineImgBundle\Annotations\ImgResize;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    
    /**
     * @var string $image
     * @Assert\File( maxSize = "1024k", mimeTypesMessage = "Please upload a valid Image")
     * @ImgResize("image", width="500", height="300", uploadDir="media/upload/article", saveField="path")
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    public $image;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @var string
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(name="slug", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="text")
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="text")
     */
    private $metaKeywords;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edit", type="datetime")
     */
    private $dateEdit;

    /**
     * src\Raph\UserBundle\Entity\User\User
     * @ORM\ManyToOne(targetEntity="Raph\UserBundle\Entity\User\User", cascade={"persist"})
     */
    private $auteur;

    /**
     * src\Raph\BlogBundle\Entity\Categorie
     * @ORM\ManyToOne(targetEntity="Raph\BlogBundle\Entity\Categorie", inversedBy="articles", cascade={"persist"})
     */
    private $categorie;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Raph\BlogBundle\Entity\Commentaire", mappedBy="article")
     */
    private $commentaires;
    
    /**
     *
     * @var array
     * @ORM\ManyToMany(targetEntity="Raph\BlogBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="publication", type="boolean") 
     */
    private $publication;
    
    public function __construct(){
        //on génère les valeurs par défaut de l'entité
        if( $this->getDateAjout() == "" )
            $this->dateAjout = new \DateTime();
        
            $this->dateEdit = new \DateTime();
            
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set image
     *
     * @param string $image
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set path
     *
     * @param string $path
     * @return Article
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
    
    /**
     * Set slug
     *
     * @param string $titre
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return Article
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     * @return Article
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set dateEdit
     *
     * @param \DateTime $dateEdit
     * @return Article
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;

        return $this;
    }

    /**
     * Get dateEdit
     *
     * @return \DateTime 
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set categorie
     *
     * @param integer $categorie
     * @return Article
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return integer 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Article
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Article
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Add commentaires
     *
     * @param \Raph\BlogBundle\Entity\Commentaire $commentaires
     * @return Article
     */
    public function addCommentaire(\Raph\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Raph\BlogBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Raph\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add tags
     *
     * @param \Raph\BlogBundle\Entity\Tag $tags
     * @return Article
     */
    public function addTag(\Raph\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Raph\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\Raph\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    
    
    

    /**
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
