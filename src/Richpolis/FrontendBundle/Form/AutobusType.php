<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutobusType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array(
                'label'=>'Autobus','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Autobus',
                    'data-bind'=>'value: autobus'
                    )
                ))
            ->add('descripcionEs',null,array(
                'label'=>'Descripcion español',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))    
            ->add('detallesEs',null,array(
                'label'=>'Detalles español',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('descripcionEn',null,array(
                'label'=>'Descripcion ingles',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))    
            ->add('detallesEn',null,array(
                'label'=>'Detalles ingles',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('descripcionFr',null,array(
                'label'=>'Descripcion frances',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))    
            ->add('detallesFr',null,array(
                'label'=>'Detalles frances',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
             ->add('file','file',array('label'=>'Imagen','attr'=>array(
                'class'=>'form-control placeholder',
                'placeholder'=>'Imagen pagina',
                'data-bind'=>'value: imagen pagina'
             )))  
            ->add('isActive',null,array('label'=>'Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
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
            'data_class' => 'Richpolis\FrontendBundle\Entity\Autobus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_frontendbundle_autobus';
    }
}
