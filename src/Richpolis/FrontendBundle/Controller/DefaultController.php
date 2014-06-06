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
        $categoriasPublicacion = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->
                        getCategoriaPublicacionEnCarrusel();
        $experiencias = $em->getRepository('FrontendBundle:Experiencias')
                ->getExperienciasActivas();
        shuffle($experiencias);
        $newsletter = new UsuarioNewsletter();
        $form = $this->createForm(new UsuarioNewsletterType(), $newsletter);
        
        $inicio = $em->getRepository('PaginasBundle:Pagina')
                ->findOneBy(array('pagina'=>'inicio'));
        
        return array(
            'categoriasPublicacion'=>$categoriasPublicacion,
            'experiencias'=>$experiencias,
            'form'=>$form->createView(),
            'pagina'=>$inicio,
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
                ->findOneBy(array('pagina'=>'nosotros'));
        return array(
            'nosotros'=>$nosotros
        );
    }
    
    /**
     * @Route("/{_locale}/autobuses", name="frontend_autobuses", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function autobusesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $autobuses = $em->getRepository('FrontendBundle:Autobus')
                ->findActivos();
        return array(
            'autobuses'=>$autobuses,
        );
    }
    
    /**
     * @Route("/{_locale}/servicios", name="frontend_servicios", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function serviciosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $servicios = $em->getRepository('PaginasBundle:Pagina')
                ->findOneBy(array('pagina'=>'servicios'));
        return array(
            'servicios'=>$servicios
        );
    }
    
    
    /**
     * @Route("/{_locale}/tours", name="frontend_tours", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Template()
     */
    public function toursAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categoriasPublicacion = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->
                        getCategoriaPublicacionActivas();
        $categorias = $this->getPublicacionesPorFilas($categoriasPublicacion);
        return array(
          'categorias'=>$categorias,  
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

    /**
     * @Route("/{_locale}/cotizador", name="frontend_cotizador", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET", "POST"})
     * @Template("FrontendBundle:Default:cotizador.html.twig")
     */
    public function cotizadorAction() {
        $cotizador = new Cotizador();
        $form = $this->createForm(new CotizadorType(), $cotizador);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                $datos=$form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $configuracion = $em->getRepository('BackendBundle:Configuraciones')
                                ->findOneBy(array('slug'=>'email-cotizador'));
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('Solicitud de cotización')
                        ->setFrom($datos->getEmail())
                        ->setTo($configuracion->getTexto())
                        ->setBody($this->renderView('FrontendBundle:Default:cotizadorEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $ok=true;
                $error=false;
                $mensaje="La solicitud de cotización se ha enviado";
                $cotizador = new Cotizador();
                $form = $this->createForm(new CotizadorType(), $cotizador);
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
        
        return array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        );
    }
    
    /**
     * @Route("/{_locale}/form/newsletter", name="frontend_form_newsletter", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET", "POST"})
     */
    public function newsletterAction() {
        $newsletter = new UsuarioNewsletter();
        $form = $this->createForm(new UsuarioNewsletterType(), $newsletter);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                $nuevo=$form->getData();
                
                $em = $this->getDoctrine()->getManager();
                $usuario = $em->getRepository('FrontendBundle:UsuarioNewsletter')->findOneBy(array(
                    'email'=>$nuevo->getEmail() 
                ));
                
                if(!$usuario){
                    $em->persist($nuevo);
                    $em->flush();
                }
               
                $ok=true;
                $error=false;
                $mensaje="Gracias se ha guardado el registro";
                $newsletter = new UsuarioNewsletter();
                $form = $this->createForm(new UsuarioNewsletterType(), $newsletter);
                
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
            $vista = $this->renderView('FrontendBundle:Default:formNewsletter.html.twig',array(
                'form' => $form->createView(),'ok'=>$ok,'error'=>$error,'mensaje'=>$mensaje,
            ));
            $arreglo = array('vista'=>$vista,'ok'=>$ok,'error'=>$error,'mensaje'=>$mensaje);
            $response = new JsonResponse();
            $response->setData($arreglo);
            return $response;
        }
        
        return $this->render("FrontendBundle:Default:formNewsletter.html.twig",array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }
    
    /**
     * Lista los ultimos tweets.
     *
     * @Route("/last-tweets/{username}/", name="last_tweets")
     */
    public function lastTweetsAction($username, $limit = 10, $age = null)
    {
        /* @var $twitter FetcherInterface */
        $twitter = $this->get('knp_last_tweets.last_tweets_fetcher');

        try {
            $tweets = $twitter->fetch($username, $limit);
        } catch (TwitterException $e) {
            $tweets = array();
        }

        $response = $this->render('FrontendBundle:Default:lastTweets.html.twig', array(
            'username' => $username,
            'tweets'   => $tweets,
        ));

        if ($age) {
            $response->setSharedMaxAge($age);
        }

        return $response;
    }
    
    /**
     * @Route("/api/{_locale}/autobuses", name="get_autobuses", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET"})
     */
    public function getAutobusesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $autobuses = $em->getRepository('FrontendBundle:Autobus')
                ->findActivos();
        $locale = $request->getLocale();
        
        $resultados = $this->decodeAutobuses($locale,$autobuses);
        
        $response = new JsonResponse();
        $response->setData($resultados);
        return $response;
    }
    
    /**
     * @Route("/api/{_locale}/autobuses/{id}", name="get_autobus", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET"})
     */
    public function getAutobusAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $autobus = $em->getRepository('FrontendBundle:Autobus')
                ->find($id);
        
        $locale = $request->getLocale();
        
        $resultados = $this->decodeAutobuses($locale,array($autobus));
        
        $response = new JsonResponse();
        $response->setData($resultados[0]);
        return $response;
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
    
    /**
     * @Route("/{_locale}/mensaje/sitio", name="get_mensaje_sitio", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     * @Method({"GET"})
     * @Template("FrontendBundle:Default:mensaje.html.twig")
     */
    public function getMensajeSitioAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
        $configuracion = $em->getRepository('BackendBundle:Configuraciones')
                ->findOneBy(array('slug'=>'aviso-'.$locale));
        
        return array('mensaje'=>$configuracion->getTexto());
    }
	
    /**
     * @Route("/{_locale}/prueba", name="homepage_prueba", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es|fr"})
     */
    public function pruebaAction() 
    {
        $youtube = RpsStms::getTitleAndImageVideoYoutube('http://youtu.be/vwndyuafDkY');
        $response = new JsonResponse();
        $response->setData($youtube);
        return $response;
    }
	
	/**
     * Crea una galeria link video de una autobus.
     *
     * @Route("/autobuses/{id}/galerias/link/video", name="autobuses_galerias_link_video", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function autobusesGaleriasLVAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $autobus=$em->getRepository('FrontendBundle:Autobus')->find($id);
        $parameters['archivo'] = $request->query->get('archivo');
		$parameters['position'] = $request->query->get('position');
        $parameters['tipoArchivo'] = $request->query->get('tipoArchivo');
		$parameters['isActive'] = $request->query->get('isActive');

        if(isset($parameters['archivo'])){

            $registro = new Galeria();
            $registro->setArchivo($parameters['archivo']);
            $registro->setIsActive($parameters['isActive']);
            $registro->setPosition($parameters['position']);
            $registro->setTipoArchivo($parameters['tipoArchivo']);
            $em->persist($registro);
            $autobus->getGalerias()->add($registro);
            $em->flush();  
        }
		
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData($parameters);
        return $response;
    }
	
	/**
     * Crea una galeria link video de una pagina.
     *
     * @Route("/paginas/{id}/galerias/link/video", name="paginas_galerias_link_video", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function paginasGaleriasLVAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $autobus=$em->getRepository('PaginasBundle:Pagina')->find($id);
        $parameters['archivo'] = $request->query->get('archivo');
		$parameters['position'] = $request->query->get('position');
        $parameters['tipoArchivo'] = $request->query->get('tipoArchivo');
		$parameters['isActive'] = $request->query->get('isActive');

        if(isset($parameters['archivo'])){

            $registro = new Galeria();
            $registro->setArchivo($parameters['archivo']);
            $registro->setIsActive($parameters['isActive']);
            $registro->setPosition($parameters['position']);
            $registro->setTipoArchivo($parameters['tipoArchivo']);
            $em->persist($registro);
            $autobus->getGalerias()->add($registro);
            $em->flush();  
        }
		
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData($parameters);
        return $response;
    }

}