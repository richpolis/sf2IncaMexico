<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;


use JMS\Serializer\Annotation as Serializer;


/**
 * Publicacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\PublicacionRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Publicacion
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
     * @ORM\Column(name="titulo_es", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("tituloEs")
     * @Serializer\Groups({"list", "details"})
     */
    private $tituloEs;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_es", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("descripcionEs")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEs;

    /**
     * @var string
     *
     * @ORM\Column(name="paquete_es", type="string", length=255, nullable=true)
     *  
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("paqueteEs")
     * @Serializer\Groups({"list", "details"})
     */
    private $paqueteEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titulo_en", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("tituloEn")
     * @Serializer\Groups({"list", "details"})
     */
    private $tituloEn;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_en", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("descripcionEn")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEn;

    /**
     * @var string
     *
     * @ORM\Column(name="paquete_en", type="string", length=255, nullable=true)
     *  
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("paqueteEn")
     * @Serializer\Groups({"list", "details"})
     */
    private $paqueteEn;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titulo_fr", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("tituloFr")
     * @Serializer\Groups({"list", "details"})
     */
    private $tituloFr;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_fr", type="text")
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("descripcionFr")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionFr;

    /**
     * @var string
     *
     * @ORM\Column(name="paquete_fr", type="string", length=255,nullable=true)
     *  
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("paqueteFr")
     * @Serializer\Groups({"list", "details"})
     */
    private $paqueteFr;
    
    /**
     * @ORM\Column(name="precio_es", type="decimal", scale=2)
     * 
     * @Serializer\Expose
     * @Serializer\Type("double")
     * @Serializer\SerializedName("precioEs")
     * @Serializer\Groups({"list", "details"})
     */
    protected $precioEs;

    /**
     * @ORM\Column(name="precio_en", type="decimal", scale=2)
     * 
     * @Serializer\Expose
     * @Serializer\Type("double")
     * @Serializer\SerializedName("precioEn")
     * @Serializer\Groups({"list", "details"})
     */
    protected $precioEn;
    
    /**
     * @ORM\Column(name="precio_fr", type="decimal", scale=2)
     * 
     * @Serializer\Expose
     * @Serializer\Type("double")
     * @Serializer\SerializedName("precioFr")
     * @Serializer\Groups({"list", "details"})
     */
    protected $precioFr;    
    
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
     * @ORM\Column(name="is_active", type="boolean")
     * 
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\SerializedName("isActive")
     * @Serializer\Groups({"list", "details"})
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="in_carrusel", type="boolean")
     * 
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\SerializedName("inCarrusel")
     * @Serializer\Groups({"list", "details"})
     */
    private $inCarrusel;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255,nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"list", "details"})
     */
    private $slug;
    
    /**
     * @var Richpolis\BackendBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Richpolis\BackendBundle\Entity\Usuario", inversedBy="publicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     * 
     * @Serializer\Expose
     * @Serializer\Type("Richpolis\BackendBundle\Entity\Usuario")
     * @Serializer\Groups({"list", "details"})
     */
    private $usuario;
    
    /**
     * @var \CategoriaPublicacion
     *
     * @ORM\ManyToOne(targetEntity="CategoriaPublicacion", inversedBy="publicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_publicacion_id", referencedColumnName="id")
     * })
     * 
     * @Serializer\Expose
     * @Serializer\Type("Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion")
     * @Serializer\Groups({"list", "details"})
     */
    private $categoria;
	
	/**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=150, nullable=true)
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
     * @ORM\JoinTable(name="publicacion_galeria")
     * @ORM\OrderBy({"position" = "ASC"})
     * 
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Richpolis\GaleriasBundle\Entity\Galeria>")
     * @Serializer\MaxDepth(1)
     * @Serializer\Groups({"details"})
     */
    private $galerias;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * 
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     * @Serializer\Groups({"list", "details"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * 
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
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
        $this->inCarrusel = true;
        $this->precioEn = 0;
        $this->precioEs = 0;
        $this->precioFr = 0;
    }
    
    public function __toString(){
        return $this->getTitulo();
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
     * Set titulo
     *
     * @param string $titulo
     * @return Publicacion
     */
    public function setTitulo($titulo,$locale)
    {
        if($locale == "es"){
            $this->tituloEs = $titulo;
        }else if($locale == "en"){
            $this->tituloEn = $titulo;
        }else{
            $this->tituloFr = $titulo;
        }
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo($locale)
    {
        if($locale == "es"){
            $titulo = $this->tituloEs;
        }else if($locale == "en"){
            $titulo = $this->tituloEn;
        }else{
            $titulo = $this->tituloFr;
        }
        return $titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Publicacion
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
     * Set paquete
     *
     * @param string $paquete
     * @return Publicacion
     */
    public function setPaquete($paquete,$locale)
    {
        if($locale == "es"){
            $this->paqueteEs = $paquete;
        }else if($locale == "en"){
            $this->paqueteEn = $paquete;
        }else{
            $this->paqueteFr = $paquete;
        }

        return $this;
    }

    /**
     * Get paquete
     *
     * @return string 
     */
    public function getPaquete($locale)
    {
        if($locale == "es"){
            $paquete = $this->paqueteEs;
        }else if($locale == "en"){
            $paquete = $this->paqueteEn;
        }else{
            $paquete = $this->paqueteFr;
        }
        return $paquete;
    }
    
    /**
     * Set precioEs
     *
     * @param string $precioEs
     * @return Publicacion
     */
    public function setPrecio($precioEs,$locale)
    {
        if($locale == "es"){
            $this->precioEs = $precio;
        }else if($locale == "en"){
            $this->precioEn = $precio;
        }else{
            $this->precioFr = $precio;
        }

        return $this;
    }

    /**
     * Get precioEs
     *
     * @return string 
     */
    public function getPrecio($locale)
    {
        if($locale == "es"){
            $precio = $this->precioEs;
        }else if($locale == "en"){
            $precio = $this->precioEn;
        }else{
            $precio = $this->precioFr;
        }
        return $precio;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Publicacion
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
     * Set position
     *
     * @param integer $position
     * @return Publicacion
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
     * @return Publicacion
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
     * @return Publicacion
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
     * @return Publicacion
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
     * Set inCarrusel
     *
     * @param boolean $inCarrusel
     * @return Publicacion
     */
    public function setInCarrusel($inCarrusel)
    {
        $this->inCarrusel = $inCarrusel;
    
        return $this;
    }

    /**
     * Get inCarrusel
     *
     * @return boolean 
     */
    public function getInCarrusel()
    {
        return $this->inCarrusel;
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
        $this->slug = RpsStms::slugify($this->getTituloEs());
    }

    
    /**
     * Set tituloEs
     *
     * @param string $tituloEs
     * @return Publicacion
     */
    public function setTituloEs($tituloEs)
    {
        $this->tituloEs = $tituloEs;

        return $this;
    }

    /**
     * Get tituloEs
     *
     * @return string 
     */
    public function getTituloEs()
    {
        return $this->tituloEs;
    }

    /**
     * Set descripcionEs
     *
     * @param string $descripcionEs
     * @return Publicacion
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
     * Set paqueteEs
     *
     * @param string $paqueteEs
     * @return Publicacion
     */
    public function setPaqueteEs($paqueteEs)
    {
        $this->paqueteEs = $paqueteEs;

        return $this;
    }

    /**
     * Get paqueteEs
     *
     * @return string 
     */
    public function getPaqueteEs()
    {
        return $this->paqueteEs;
    }

    /**
     * Set tituloEn
     *
     * @param string $tituloEn
     * @return Publicacion
     */
    public function setTituloEn($tituloEn)
    {
        $this->tituloEn = $tituloEn;

        return $this;
    }

    /**
     * Get tituloEn
     *
     * @return string 
     */
    public function getTituloEn()
    {
        return $this->tituloEn;
    }

    /**
     * Set descripcionEn
     *
     * @param string $descripcionEn
     * @return Publicacion
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
     * Set paqueteEn
     *
     * @param string $paqueteEn
     * @return Publicacion
     */
    public function setPaqueteEn($paqueteEn)
    {
        $this->paqueteEn = $paqueteEn;

        return $this;
    }

    /**
     * Get paqueteEn
     *
     * @return string 
     */
    public function getPaqueteEn()
    {
        return $this->paqueteEn;
    }

    /**
     * Set tituloFr
     *
     * @param string $tituloFr
     * @return Publicacion
     */
    public function setTituloFr($tituloFr)
    {
        $this->tituloFr = $tituloFr;

        return $this;
    }

    /**
     * Get tituloFr
     *
     * @return string 
     */
    public function getTituloFr()
    {
        return $this->tituloFr;
    }

    /**
     * Set descripcionFr
     *
     * @param string $descripcionFr
     * @return Publicacion
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
     * Set paqueteFr
     *
     * @param string $paqueteFr
     * @return Publicacion
     */
    public function setPaqueteFr($paqueteFr)
    {
        $this->paqueteFr = $paqueteFr;

        return $this;
    }

    /**
     * Get paqueteFr
     *
     * @return string 
     */
    public function getPaqueteFr()
    {
        return $this->paqueteFr;
    }

    /**
     * Set precioEs
     *
     * @param string $precioEs
     * @return Publicacion
     */
    public function setPrecioEs($precioEs)
    {
        $this->precioEs = $precioEs;

        return $this;
    }

    /**
     * Get precioEs
     *
     * @return string 
     */
    public function getPrecioEs()
    {
        return $this->precioEs;
    }

    /**
     * Set precioEn
     *
     * @param string $precioEn
     * @return Publicacion
     */
    public function setPrecioEn($precioEn)
    {
        $this->precioEn = $precioEn;

        return $this;
    }

    /**
     * Get precioEn
     *
     * @return string 
     */
    public function getPrecioEn()
    {
        return $this->precioEn;
    }

    /**
     * Set precioFr
     *
     * @param string $precioFr
     * @return Publicacion
     */
    public function setPrecioFr($precioFr)
    {
        $this->precioFr = $precioFr;

        return $this;
    }

    /**
     * Get precioFr
     *
     * @return string 
     */
    public function getPrecioFr()
    {
        return $this->precioFr;
    }
	
	/*** uploads ***/
    
    /**
     * @Assert\File(maxSize="2M",maxSizeMessage="El archivo es demasiado grande. El tamaño máximo permitido es {{ limit }}")
     */
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
        return '/uploads/publicaciones';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }

    public function getDescripcionCorta(){
        return RpsStms::cut_string2(RpsStms::strip_html_tags($this->getContenidoEs()),250);
    }
	

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Publicacion
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
     * Set usuario
     *
     * @param \Richpolis\BackendBundle\Entity\Usuario $usuario
     * @return Publicacion
     */
    public function setUsuario(\Richpolis\BackendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Richpolis\BackendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set categoria
     *
     * @param \Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion $categoria
     * @return Publicacion
     */
    public function setCategoria(\Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add galerias
     *
     * @param \Richpolis\GaleriasBundle\Entity\Galeria $galerias
     * @return Publicacion
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
