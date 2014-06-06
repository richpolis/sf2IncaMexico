<?php

namespace Richpolis\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use JMS\Serializer\Annotation as Serializer;


/**
 * Autobus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Richpolis\FrontendBundle\Repository\AutobusRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Autobus
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
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_es", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_en", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEn;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_fr", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionFr;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="detalles_es", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $detallesEs;

    /**
     * @var string
     *
     * @ORM\Column(name="detalles_en", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $detallesEn;

    /**
     * @var string
     *
     * @ORM\Column(name="detalles_fr", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $detallesFr;
    
    
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
     * @ORM\JoinTable(name="autobus_galeria")
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

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Autobus
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Autobus
     */
    public function setDescripcion($descripcion,$locale)
    {
        if($locale == "es"){
            $this->descripcionEs = $descripcion;
        }else if($locale == "en"){
            $this->descripcionEn = $descripcion;
        }else{
            $this->descripcionFr = $descripcion;
        }

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion($locale)
    {
        if($locale == "es"){
            $descripcion = $this->descripcionEs;
        }else if($locale == "en"){
            $descripcion = $this->descripcionEn;
        }else{
            $descripcion = $this->descripcionFr;
        }
        return $descripcion;
    }

    /**
     * Set detalles
     *
     * @param string $detalles
     * @return Autobus
     */
    public function setDetalles($detalles,$locale)
    {
        if($locale == "es"){
            $this->detallesEs = $detalles;
        }else if($locale == "en"){
            $this->detallesEn = $detalles;
        }else{
            $this->detallesFr = $detalles;
        }
        return $this;
    }

    /**
     * Get detalles
     *
     * @return string 
     */
    public function getDetalles($locale)
    {
        if($locale == "es"){
            $detalles = $this->detallesEs;
        }else if($locale == "en"){
            $detalles = $this->detallesEn;
        }else{
            $detalles = $this->detallesFr;
        }
        return $detalles;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Autobus
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
     * @return Autobus
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
     * @return Autobus
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Autobus
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Autobus
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Autobus
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
     * Add galerias
     *
     * @param \Richpolis\GaleriasBundle\Entity\Galeria $galerias
     * @return Autobus
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
        $this->slug = RpsStms::slugify($this->getNombre());
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
        return '/uploads/autobuses';
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
     * Set descripcionEs
     *
     * @param string $descripcionEs
     * @return Autobus
     */
    public function setDescripcionEs($descripcionEs)
    {
        $this->descripcionEs = $descripcionEs;

        return $this;
    }

    /**
     * Get descripcionEs
     *
     * @return string 
     */
    public function getDescripcionEs()
    {
        return $this->descripcionEs;
    }

    /**
     * Set descripcionEn
     *
     * @param string $descripcionEn
     * @return Autobus
     */
    public function setDescripcionEn($descripcionEn)
    {
        $this->descripcionEn = $descripcionEn;

        return $this;
    }

    /**
     * Get descripcionEn
     *
     * @return string 
     */
    public function getDescripcionEn()
    {
        return $this->descripcionEn;
    }

    /**
     * Set descripcionFr
     *
     * @param string $descripcionFr
     * @return Autobus
     */
    public function setDescripcionFr($descripcionFr)
    {
        $this->descripcionFr = $descripcionFr;

        return $this;
    }

    /**
     * Get descripcionFr
     *
     * @return string 
     */
    public function getDescripcionFr()
    {
        return $this->descripcionFr;
    }

    /**
     * Set detallesEs
     *
     * @param string $detallesEs
     * @return Autobus
     */
    public function setDetallesEs($detallesEs)
    {
        $this->detallesEs = $detallesEs;

        return $this;
    }

    /**
     * Get detallesEs
     *
     * @return string 
     */
    public function getDetallesEs()
    {
        return $this->detallesEs;
    }

    /**
     * Set detallesEn
     *
     * @param string $detallesEn
     * @return Autobus
     */
    public function setDetallesEn($detallesEn)
    {
        $this->detallesEn = $detallesEn;

        return $this;
    }

    /**
     * Get detallesEn
     *
     * @return string 
     */
    public function getDetallesEn()
    {
        return $this->detallesEn;
    }

    /**
     * Set detallesFr
     *
     * @param string $detallesFr
     * @return Autobus
     */
    public function setDetallesFr($detallesFr)
    {
        $this->detallesFr = $detallesFr;

        return $this;
    }

    /**
     * Get detallesFr
     *
     * @return string 
     */
    public function getDetallesFr()
    {
        return $this->detallesFr;
    }
}
