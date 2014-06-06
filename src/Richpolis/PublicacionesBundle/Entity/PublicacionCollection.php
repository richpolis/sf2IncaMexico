<?php

namespace Richpolis\PublicacionesBundle\Entity;

use JMS\Serializer\Annotation as Serializer;


/**
 * PublicacionCollection
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class PublicacionCollection
{
   
    /**
     * @var array con los datos del paginador
     * datos del paginador
     *  
     * @Serializer\Expose
     * @Serializer\Type("array<integer>")
     */
    private $paginador;
    
    /**
     * @var array publicaciones
     * listado de todas las publicaciones
     *  
     * @Serializer\Expose
     * @Serializer\Type("array<Richpolis\PublicacionesBundle\Entity\Publicacion>")
     */
    private $publicaciones;
    
    public function __construct($publicaciones,$paginador) {
        $this->paginador = $paginador;
        $this->publicaciones = $publicaciones;
    }
    
    public function getPaginador(){
        return $this->paginador;
    }
    
    public function getPublicaciones(){
        return $this->publicaciones;
    }
}