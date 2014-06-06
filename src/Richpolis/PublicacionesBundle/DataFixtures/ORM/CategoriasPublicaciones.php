<?php

/*
 * 
 * Creado por Ricardo Alcantara <richpolis@gmail.com>
 *
 */

namespace Richpolis\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion;

/**
 * Fixtures de la entidad CategoriaPublicacion.
 * Crea los tres tipos de categorias de las publicaciones.
 */
class CategoriasPublicaciones extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 20;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Crear las categorias de las publicaciones

        $destinos = new CategoriaPublicacion();
        $destinos->setNombre("Destinos");
        $destinos->setPosition(1);
        
        $eventos = new CategoriaPublicacion();
        $eventos->setNombre("Eventos");
        $eventos->setPosition(2);
        
        $tours = new CategoriaPublicacion();
        $tours->setNombre("Tours");
        $tours->setPosition(3);
        
        $manager->persist($destinos);
        $manager->persist($eventos);
        $manager->persist($tours);
        
        $manager->flush();
        
    }

    
}