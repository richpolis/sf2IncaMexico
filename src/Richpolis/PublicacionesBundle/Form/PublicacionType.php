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
                'label'=>'Proyecto en español','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Proyecto',
                    'data-bind'=>'value: proyecto'
                    )
                ))    
            ->add('descripcionEs',null,array(
                'label'=>'Descripcion en español',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('tituloEn','text',array(
                'label'=>'Proyecto en ingles','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Proyecto',
                    'data-bind'=>'value: proyecto'
                    )
                ))    
            ->add('descripcionEn',null,array(
                'label'=>'Descripcion en ingles',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('cliente','text',array(
                'label'=>'Nombre del cliente','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Cliente',
                    'data-bind'=>'value: cliente'
                    )
                ))
            ->add('ubicacion','text',array(
                'label'=>'Ubicacion','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Ubicacion',
                    'data-bind'=>'value: ubicacion'
                    )
                ))
            ->add('monto','text',array(
                'label'=>'Monto','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Monto',
                    'data-bind'=>'value: monto'
                    )
                ))
            ->add('empezo','text',array(
                'label'=>'Año de inicio','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Empezo',
                    'data-bind'=>'value: empezo'
                    )
                ))
            ->add('termino','text',array(
                'label'=>'Año de termino','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Termino',
                    'data-bind'=>'value: termino'
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
