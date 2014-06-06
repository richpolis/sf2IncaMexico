<?php
namespace Richpolis\BackendBundle\Twig;

class IsActiveExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'isActive' => new \Twig_Filter_Method($this, 'isActiveFilter'),
        );
    }

    public function isActiveFilter($is_active)
    {
        if($is_active){
            $img="<i class='icon-ok'></i>";
        }else{
            $img="<i class='icon-remove'></i>";
        }
        
        return $img;
    }

    public function getName()
    {
        return 'is_active_extension';
    }
}