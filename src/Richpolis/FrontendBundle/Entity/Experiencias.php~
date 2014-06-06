<?php

namespace Richpolis\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Experiencias
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Richpolis\FrontendBundle\Repository\ExperienciasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Experiencias
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
     * @ORM\Column(name="contenido_es", type="text")
     */
    private $contenidoEs;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido_en", type="text")
     */
    private $contenidoEn;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido_fr", type="text")
     */
    private $contenidoFr;
    
    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=255)
     */
    private $autor;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    public function __construct() {
        $this->isActive = true;
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
     * Set contenido
     *
     * @param string $contenido
     * @return Experiencias
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
     * Set autor
     *
     * @param string $autor
     * @return Experiencias
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Experiencias
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
     * @return Experiencias
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
     * @return Experiencias
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
     * Set contenidoEs
     *
     * @param string $contenidoEs
     * @return Experiencias
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
     * @return Experiencias
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
     * @return Experiencias
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
    
    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
    }

}
