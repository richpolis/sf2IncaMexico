<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class CotizadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('required'=>true))
            ->add('email','email',array('required'=>true))
            ->add('telefono','text',array('required'=>true))
            ->add('pais','text',array('required'=>false)) 
            ->add('ciudad','text',array('required'=>false))                
            ->add('salida','text',array('required'=>true))
            ->add('fechaSalida','text',array('required'=>true))
            ->add('horaSalida','text',array('required'=>true))
            ->add('destino','text',array('required'=>true))
            ->add('pasajeros','number',array('required'=>true))
            ->add('autobus', 'entity', array(
                    'class' => 'FrontendBundle:Autobus',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nombre', 'ASC');
                    },
                ))
            ->add('itinerario','textarea',array('required'=>true))        
            ->add('fechaRegreso','text',array('required'=>true))
            ->add('horaRegreso','text',array('required'=>true))
            ->add('comentarios','textarea',array('required'=>true))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\FrontendBundle\Entity\Cotizador'
        ));
    }

    public function getName()
    {
        return 'cotizador';
    }
}
