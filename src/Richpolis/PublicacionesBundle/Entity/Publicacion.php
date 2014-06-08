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
 * @ORM\Table(name="publicaciones")
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
     * @Serializer\SerializedName("titulo")
     * @Serializer\Groups({"list", "details"})
     */
    private $tituloEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titulo_en", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("titulo")
     * @Serializer\Groups({"list", "details"})
     */
    private $tituloEn;
    

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_es", type="text",nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("descripcion")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_en", type="text",nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("descripcion")
     * @Serializer\Groups({"list", "details"})
     */
    private $descripcionEn;    

    /**
     * @var integer
     *
     * @ORM\Column(name="empezo", type="integer")
     *  
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"list", "details"})
     */
    private $empezo;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="termino", type="integer")
     *  
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"list", "details"})
     */
    private $termino;    
    
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
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("titulo")
     * @Serializer\Groups({"list", "details"})
     */
    private $cliente;
    

    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=255)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("titulo")
     * @Serializer\Groups({"list", "details"})
     */
    private $ubicacion;
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("titulo")
     * @Serializer\Groups({"list", "details"})
     */
    private $monto;
    
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
     * @ORM\JoinTable(name="publicaciones_galeria")
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
        $this->precio = 0;
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
        
        $this->crearThumbnail();
        
        $this->file = null;
    }
    
    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    public function crearThumbnail($width=174,$height=295,$path=""){
        $imagine    = new \Imagine\Gd\Imagine();
        $collage    = $imagine->create(new \Imagine\Image\Box(190, 323));
        $mode       = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $image      = $imagine->open($this->getAbsolutePath());
        $sizeImage  = $image->getSize();
        if(strlen($path)==0){
            $path = $this->getAbosluteThumbnailPath();
        }
        if($height == null){
            $height = $sizeImage->getHeight();
            if($height>323){
                $height = 323;
            }
        }
        if($width == null){
            $width = $sizeImage->getWidth();
            if($width>190){
                $width = 190;
            }
        }
        $size   =new \Imagine\Image\Box($width,$height);
        $image->thumbnail($size,$mode)->save($path);
        $image      = $imagine->open($path);
        $size = $image->getSize();
        if((190 - $size->getWidth())>1){
            $width = ceil((190 - $size->getWidth())/2);
        }else{
            $width = 0;
        }
        if((323 - $size->getHeight())>1){
            $height = ceil((323 - $size->getHeight())/2);
        }else{
            $height =0;
        }    
        $centrado = new \Imagine\Image\Point($width, $height);
        $collage->paste($image,$centrado);
        $collage->save($path);        
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
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
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
    
    public function getThumbnailWebPath()
    {
        if(!file_exists($this->getAbosluteThumbnailPath())){
            if(file_exists($this->getAbsolutePath())){
                $this->crearThumbnail();
            }
        }
        return null === $this->imagen ? null : $this->getUploadDir().'/thumbnails/'.$this->imagen;
        
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }
    
    public function getAbosluteThumbnailPath(){
        return null === $this->imagen ? null : $this->getUploadRootDir().'/thumbnails/'.$this->imagen;
    }

    public function getDescripcionCorta(){
        return RpsStms::cut_string2(RpsStms::strip_html_tags($this->getDescripcion()),250);
    }
    
    
	

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Publicacion
     */
    public function setTitulo($value, $locale)
    {
        if($locale == "es"){
            $this->tituloEs = $value;
        }else{
            $this->tituloEn = $value;
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
            $value = $this->tituloEs;
        }else{
            $value = $this->tituloEn;
        }
        return $value;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Publicacion
     */
    public function setDescripcion($value, $locale)
    {
        if($locale == "es"){
            $this->descripcionEs = $value;
        }else{
            $this->descripcionEn = $value;
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
            $value = $this->descripcionEs;
        }else{
            $value = $this->descripcionEn;
        }
        return $value;
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
     * Set empezo
     *
     * @param integer $empezo
     * @return Publicacion
     */
    public function setEmpezo($empezo)
    {
        $this->empezo = $empezo;

        return $this;
    }

    /**
     * Get empezo
     *
     * @return integer 
     */
    public function getEmpezo()
    {
        return $this->empezo;
    }

    /**
     * Set termino
     *
     * @param integer $termino
     * @return Publicacion
     */
    public function setTermino($termino)
    {
        $this->termino = $termino;

        return $this;
    }

    /**
     * Get termino
     *
     * @return integer 
     */
    public function getTermino()
    {
        return $this->termino;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     * @return Publicacion
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return string 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Publicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return Publicacion
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string 
     */
    public function getMonto()
    {
        return $this->monto;
    }
}
