<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExperienciasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenidoEs',null,array(
                'label'=>'Contenido español',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('contenidoEn',null,array(
                'label'=>'Contenido ingles',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('contenidoFr',null,array(
                'label'=>'Contenido frances',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))    
            ->add('autor','text',array('label'=>'Autor','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Autor',
                'data-bind'=>'value: autor'
             )))
            ->add('position','hidden')
            ->add('isActive','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\FrontendBundle\Entity\Experiencias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_frontendbundle_experiencias';
    }
}
