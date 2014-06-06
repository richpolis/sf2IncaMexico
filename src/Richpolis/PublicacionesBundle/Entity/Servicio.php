<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as Serializer;


/**
 * Servicio
 *
 * @ORM\Table(name="servicios")
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\ServicioRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Servicio
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
     * @Serializer\Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="servicio", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $servicio;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $imagen;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Richpolis\GaleriasBundle\Entity\Galeria")
     * @ORM\JoinTable(name="servicios_galeria")
     * @ORM\OrderBy({"position" = "ASC"})
     * 
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Richpolis\GaleriasBundle\Entity\Galeria>")
     * @Serializer\MaxDepth(1)
     * @Serializer\Groups({"details"})
     */
    private $galerias;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"list", "details"})
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     * 
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"list", "details"})
     */
    private $isActive;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * 
     * @Serializer\Expose
     * @Serializer\Type("datetime")
     * @Serializer\Groups({"list", "details"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * 
     * @Serializer\Expose
     * @Serializer\Type("datetime")
     * @Serializer\Groups({"list", "details"})
     */
    private $updatedAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }
    
    public function __toString(){
        return $this->getNombre();
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

    
    
    /*
     * Timestable
     */
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
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
        $this->slug = RpsStms::slugify($this->getServicio());
    }
    
    /*** uploads ***/
    
    public $file;
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->imagen)) {
            // store the old name to delete after the update
            $this->temp = $this->imagen;
            $this->imagen = null;
        } else {
            $this->imagen = 'initial';
        }
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->imagen = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->imagen);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        
        $this->file = null;
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        if(file_exists($file)){
            unlink($file);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/servicios';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webPath")
     * 
     */
    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }

    

    /**
     * Set servicio
     *
     * @param string $servicio
     * @return Servicio
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return string 
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Servicio
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Servicio
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Servicio
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Servicio
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
     * @return Servicio
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Servicio
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Servicio
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add galerias
     *
     * @param \Richpolis\GaleriasBundle\Entity\Galeria $galerias
     * @return Servicio
     */
    public function addGaleria(\Richpolis\GaleriasBundle\Entity\Galeria $galerias)
    {
        $this->galerias[] = $galerias;

        return $this;
    }

    /**
     * Remove galerias
     *
     * @param \Richpolis\GaleriasBundle\Entity\Galeria $galerias
     */
    public function removeGaleria(\Richpolis\GaleriasBundle\Entity\Galeria $galerias)
    {
        $this->galerias->removeElement($galerias);
    }

    /**
     * Get galerias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalerias()
    {
        return $this->galerias;
    }
}
