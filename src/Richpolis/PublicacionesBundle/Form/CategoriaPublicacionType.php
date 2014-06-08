<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoriaPublicacionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreEs','text',array('label'=>'Categoria en español','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Categoria',
                'data-bind'=>'value: categoria'
             )))
            ->add('nombreEn','text',array('label'=>'Categoria en ingles','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Categoria',
                'data-bind'=>'value: categoria'
             )))
            ->add('isActive',null,array('label'=>'Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isActive'
             )))    
            ->add('position','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_publicacionesbundle_categoriapublicacion';
    }
}
