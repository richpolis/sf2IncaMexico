<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Richpolis\BackendBundle\Repository\UsuariosRepository;
use Richpolis\PublicacionesBundle\Repository\CategoriaPublicacionRepository;

class PublicacionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',array(
                'label'=>'Producto','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Producto',
                    'data-bind'=>'value: producto'
                    )
                ))    
            ->add('descripcion','hidden')
            ->add('precio','money',array(
                'label'=>'Precio',
                'required'=>true,
                'currency'=>'MXN',
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Precio',
                    'data-bind'=>'value: precio',
                    'style'=>'width:250px;'
                    )
                ))
            ->add('categoria',null,array(
                'label'=>'Categoria',
                'required'=>true,
                'read_only'=>true,
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Categoria',
                    'data-bind'=>'value: categoria',
                    )
                ))
            ->add('usuario',null,array(
                'label'=>'Usuario',
                'required'=>true,
                'read_only'=>true,                
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Usuario',
                    'data-bind'=>'value: usuario',
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
            //->add('galerias','hidden')    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Publicacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_publicacionesbundle_publicacion';
    }
}
