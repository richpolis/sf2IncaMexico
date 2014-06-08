<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

use JMS\Serializer\Annotation as Serializer;

/**
 * CategoriaPublicacion
 *
 * @ORM\Table(name="categorias_publicaciones")
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\CategoriaPublicacionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Serializer\ExclusionPolicy("all")
 * 
 */
class CategoriaPublicacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_es", type="string", length=150)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $nombreEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_en", type="string", length=150)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $nombreEn;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * 
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     */
    private $isActive;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=150)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $slug;
        
    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Publicacion",mappedBy="categoria")
	 * @ORM\OrderBy({"position" = "ASC"})
     */
    private $publicaciones;


    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->publicaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }
    
    public function __toString(){
        return $this->getNombreEs();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre($locale)
    {
        if($locale == "es"){
            $this->nombreEs = $value;
        }else if($locale == "en"){
            $this->nombreEn = $value;
        }

        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Categoria
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add publicaciones
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones
     * @return Categoria
     */
    public function addPublicacione(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones[] = $publicaciones;

        return $this;
    }

    /**
     * Remove publicaciones
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones
     */
    public function removePublicacione(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones->removeElement($publicaciones);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Categoria
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Categoria
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
    
    /*
     * Slugable
     */
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setSlugAtValue()
    {
        $this->slug = RpsStms::slugify($this->getNombreEs());
    }

    /**
     * Set nombreEs
     *
     * @param string $nombreEs
     * @return CategoriaPublicacion
     */
    public function setNombreEs($nombreEs)
    {
        $this->nombreEs = $nombreEs;

        return $this;
    }

    /**
     * Get nombreEs
     *
     * @return string
     */
    public function getNombreEs()
    {
        return $this->nombreEs;
    }

    /**
     * Set nombreEn
     *
     * @param string $nombreEn
     * @return CategoriaPublicacion
     */
    public function setNombreEn($nombreEn)
    {
        $this->nombreEn = $nombreEn;

        return $this;
    }

    /**
     * Get nombreEn
     *
     * @return string
     */
    public function getNombreEn()
    {
        return $this->nombreEn;
    }
}
