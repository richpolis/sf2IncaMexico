<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Richpolis\BackendBundle\Utils\Youtube;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

use Richpolis\FrontendBundle\Entity\Contacto;
use Richpolis\FrontendBundle\Form\ContactoType;

use Richpolis\FrontendBundle\Entity\Cotizador;
use Richpolis\FrontendBundle\Form\CotizadorType;

use Richpolis\FrontendBundle\Entity\UsuarioNewsletter;
use Richpolis\FrontendBundle\Form\UsuarioNewsletterType;

use Richpolis\GaleriasBundle\Entity\Galeria;

class DefaultController extends Controller
{
    /**
     * Entrada por default.
     *
     * @Route("/")
     */
    public function entradaAction()
    {
        $locale = $this->getRequest()->getLocale();
        return $this->redirect($this->generateUrl('homepage',array('_locale'=>$locale)));
    }
    
    /**
     * @Route("/{_locale}/", name="homepage", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inicio = $em->getRepository('PaginasBundle:Pagina')
                ->findOneBy(array('pagina'=>'inicio'));
        
        return array(

        );
    }
    
    /**
     * @Route("/{_locale}/nosotros", name="frontend_nosotros", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function nosotrosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nosotros = $em->getRepository('PaginasBundle:Pagina')
                ->findOneBy(array('pagina'=>'quienes-somos'));
        return array(
            'pagina'=>$nosotros
        );
    }
    
    /**
     * @Route("/{_locale}/proyectos", name="frontend_proyectos", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function proyectosAction()
    {
        $em = $this->getDoctrine()->getManager();
        return array(

        );
    }
    
    /**
     * @Route("/{_locale}/clientes", name="frontend_clientes", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function clientesAction()
    {
        $em = $this->getDoctrine()->getManager();

        return array(
        );
    }
    
    /**
     * @Route("/{_locale}/servicios", name="frontend_servicios", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function serviciosAction()
    {
        $em = $this->getDoctrine()->getManager();

        return array(
        );
    }
    
    
    private function getPublicacionesPorFilas($categorias){
        $arreglo = array();
        $largo = 0;
        $paginas = 0;
        $contPagina = 0;
        $cont=0;
        foreach($categorias as $categoria){
            $arreglo[$categoria->getSlug()]=array();
            $largo = count($categoria->getPublicaciones());
            $paginas = ceil($largo/3);
            $contPagina = 0;
            $arreglo[$categoria->getSlug()][$contPagina]=array();
            $cont=0;
            foreach($categoria->getPublicaciones() as $publicacion){
                $arreglo[$categoria->getSlug()][$contPagina][$cont++]=$publicacion;
                if($cont==3){
                    $cont=0;
                    $contPagina++;
                }
            }
        }
        return $arreglo;
    }
    
    /**
     * @Route("/{_locale}/contacto", name="frontend_contacto", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET", "POST"})
     */
    public function contactoAction(Request $request) {
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                $datos=$form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $configuracion = $em->getRepository('BackendBundle:Configuraciones')
                                ->findOneBy(array('slug'=>'email-contacto'));
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contacto desde pagina')
                        ->setFrom($datos->getEmail())
                        ->setTo($configuracion->getTexto())
                        ->setBody($this->renderView('FrontendBundle:Default:contactoEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $ok=true;
                $error=false;
                $mensaje="Se ha enviado el mensaje";
                $contacto = new Contacto();
                $form = $this->createForm(new ContactoType(), $contacto);
                
                
            }else{
                $ok=false;
                $error=true;
                $mensaje="El mensaje no se ha podido enviar";
            }
        }else{
            $ok=false;
            $error=false;
            $mensaje="";
        }
        
        if($request->isXmlHttpRequest()){
            return $this->render('FrontendBundle:Default:formContacto.html.twig',array(
                'form' => $form->createView(),
                'ok'=>$ok,
                'error'=>$error,
                'mensaje'=>$mensaje,
            ));
        }
        
        return $this->render('FrontendBundle:Default:contacto.html.twig',array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }

    
    
    private function decodeAutobuses($locale,$autobuses){
        $arreglo = array();
        $cont = 0;
        $largo = count($autobuses);
        $avalancheService = $this->get('imagine.cache.path.resolver');
        foreach($autobuses as $autobus){
            $item = array(
              'id'=>$autobus->getId(),
              'slug'=>$autobus->getSlug(),  
              'nombre'=>$autobus->getNombre(),
              'descripcion'=>$autobus->getDescripcion($locale),
              'detalles'=>$autobus->getDetalles($locale),
              'imagen'=>$autobus->getWebPath(),
              'galerias'=>array(),
            );
            $contGaleria =0;
            $galerias = array();
            foreach($autobus->getGalerias() as $galeria){
                $galerias[$contGaleria++]=array(
                  'titulo'=>$galeria->getTitulo(),
                  'descripcion'=>$galeria->getDescripcion(),
                  'archivo'=>$galeria->getWebPath(),
                  'isImagen'=>$galeria->getIsImagen(),  
                  'thumbnail'=>($galeria->getIsImagen()?$avalancheService->getBrowserPath($galeria->getWebPath(), 'publicaciones'):$galeria->getThumbnailWebPath()),
                  'logo'=>($galeria->getTitulo()=="logo"?true:false),  
                );
            }
            if(isset($autobuses[$cont+1])){
                $item['siguiente']=$autobuses[$cont+1]->getSlug();
                $item['siguienteNombre']=$autobuses[$cont+1]->getNombre();
            }
            if($cont>0){
                $item['anterior']=$autobuses[$cont-1]->getSlug();
                $item['anteriorNombre']=$autobuses[$cont-1]->getNombre();
            }
            $item['galerias']=$galerias;
            $arreglo[$cont++]= $item;
        }
        return $arreglo;
    }

}