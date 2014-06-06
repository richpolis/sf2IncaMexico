<?php

namespace Richpolis\PaginasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Pagina
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Richpolis\PaginasBundle\Repository\PaginaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Pagina
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
     * @ORM\Column(name="pagina", type="string", length=150)
     * @Assert\NotBlank
     */
    private $pagina;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=150, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido_es", type="text", nullable=true)
     */
    private $contenidoEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contenido_en", type="text", nullable=true)
     */
    private $contenidoEn;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contenido_fr", type="text", nullable=true)
     */
    private $contenidoFr;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Richpolis\GaleriasBundle\Entity\Galeria")
     * @ORM\JoinTable(name="pagina_galeria")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $galerias;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galerias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set pagina
     *
     * @param string $pagina
     * @return Pagina
     */
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;

        return $this;
    }

    /**
     * Get pagina
     *
     * @return string 
     */
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Pagina
     */
    public function setContenido($contenido,$locale)
    {
        if($locale == "es"){
            $this->contenidoEs = $contenido;
        }else if($locale == "en"){
            $this->contenidoEn = $contenido;
        }else{
            $this->contenidoFr = $contenido;
        }
        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido($locale)
    {
        if($locale == "es"){
            $contenido = $this->contenidoEs;
        }else if($locale == "en"){
            $contenido = $this->contenidoEn;
        }else{
            $contenido = $this->contenidoFr;
        }
        return $contenido;
    }

    /**
     * Set contenidoEs
     *
     * @param string $contenidoEs
     * @return Pagina
     */
    public function setContenidoEs($contenidoEs)
    {
        $this->contenidoEs = $contenidoEs;

        return $this;
    }

    /**
     * Get contenidoEs
     *
     * @return string 
     */
    public function getContenidoEs()
    {
        return $this->contenidoEs;
    }

    /**
     * Set contenidoEn
     *
     * @param string $contenidoEn
     * @return Pagina
     */
    public function setContenidoEn($contenidoEn)
    {
        $this->contenidoEn = $contenidoEn;

        return $this;
    }

    /**
     * Get contenidoEn
     *
     * @return string 
     */
    public function getContenidoEn()
    {
        return $this->contenidoEn;
    }

    /**
     * Set contenidoFr
     *
     * @param string $contenidoFr
     * @return Pagina
     */
    public function setContenidoFr($contenidoFr)
    {
        $this->contenidoFr = $contenidoFr;

        return $this;
    }

    /**
     * Get contenidoFr
     *
     * @return string 
     */
    public function getContenidoFr()
    {
        return $this->contenidoFr;
    }

    
    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Pagina
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
     * Add galerias
     *
     * @param \Richpolis\GaleriasBundle\Entity\Galeria $galerias
     * @return Pagina
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

    /*** uploads ***/
    
    /**
     * @Assert\File(maxSize="6000000")
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
        return '/uploads/paginas';
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

    
}
