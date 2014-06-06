<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServicioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('servicio','text',array(
                'label'=>'Servicio','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Servicio',
                    'data-bind'=>'value: servicio'
                    )
                ))
            ->add('descripcion',null,array(
                'label'=>'Descripcion',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
             ->add('file','file',array('label'=>'Imagen','attr'=>array(
                'class'=>'form-control placeholder',
                'placeholder'=>'Imagen',
                'data-bind'=>'value: imagen'
             )))  
            ->add('isActive',null,array('label'=>'Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo?',
                'data-bind'=>'value: isActive'
                )))    
            ->add('imagen','hidden')
            ->add('position','hidden')
            ->add('slug','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Servicio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_publicacionesbundle_servicio';
    }
}
