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
            ->add('tituloEs','text',array(
                'label'=>'Titulo','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Titulo',
                    'data-bind'=>'value: titulo'
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
            ->add('paqueteEs','text',array(
                'label'=>'Paquete español','required'=>false,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Paquete',
                    'data-bind'=>'value: paquete'
                    )
                ))
            ->add('precioEs','money',array(
                'label'=>'Precio pesos',
                'required'=>false,
                'currency'=>'MXN',
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Precio',
                    'data-bind'=>'value: precio',
                    'style'=>'width:250px;'
                    )
                ))
            ->add('tituloEn','text',array(
                'label'=>'Titulo ingles','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Titulo',
                    'data-bind'=>'value: titulo'
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
            ->add('paqueteEn','text',array(
                'label'=>'Paquete ingles','required'=>false,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Paquete',
                    'data-bind'=>'value: paquete'
                    )
                ))
            ->add('precioEn','money',array(
                'label'=>'Precio dolares',
                'required'=>false,
                'currency'=>'USN',
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Precio',
                    'data-bind'=>'value: precio',
                    'style'=>'width:250px;'
                    )
                ))
            ->add('tituloFr','text',array(
                'label'=>'Titulo frances','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Titulo',
                    'data-bind'=>'value: titulo'
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
            ->add('paqueteFr','text',array(
                'label'=>'Paquete frances','required'=>false,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Paquete',
                    'data-bind'=>'value: paquete'
                    )
                ))
            ->add('precioFr','money',array(
                'label'=>'Precio euros',
                'required'=>false,
                'currency'=>'EUR',
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
            ->add('inCarrusel',null,array('label'=>'Carrusel?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Esta en carrusel',
                'data-bind'=>'value: inCarrusel'
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
