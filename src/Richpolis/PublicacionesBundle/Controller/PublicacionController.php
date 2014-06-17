<?php

namespace Richpolis\PublicacionesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Richpolis\PublicacionesBundle\Entity\Publicacion;
use Richpolis\PublicacionesBundle\Form\PublicacionType;

use Richpolis\BackendBundle\Utils\Richsys as RpsStms;
use Richpolis\BackendBundle\Utils\qqFileUploader;
use Richpolis\GaleriasBundle\Entity\Galeria;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Publicacion controller.
 *
 * @Route("/publicaciones")
 */
class PublicacionController extends Controller {

    private $categorias = null;

    protected function getFilters() {
        return $this->get('session')->get('filters', array());
    }

    protected function setFilters($filtros) {
        $this->get('session')->set('filters', $filtros);
    }

    protected function getCategoriaDefault() {
        $filters = $this->getFilters();
        $cat = null;
        if (isset($filters['categorias'])) {
            $categorias = $this->getCategoriasPublicacion();
            foreach ($categorias as $categoria) {
                if ($categoria->getId() == $filters['categorias']) {
                    $cat = $categoria;
                    break;
                }
            }
        } else {
            $categorias = $this->getCategoriasPublicacion();
            $this->setFilters(array('categorias' => $categorias[0]->getId()));
            $cat = $categorias[0];
        }
        return $cat;
    }

    protected function getCategoriasPublicacion() {
        $em = $this->getDoctrine()->getManager();
        if ($this->categorias == null) {
            $this->categorias = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')
                    ->findAll();
        }
        return $this->categorias;
    }

    protected function getCategoriaActual($categoriaId) {
        $categorias = $this->getCategoriasPublicacion();
        $categoriaActual = null;
        foreach ($categorias as $categoria) {
            if ($categoria->getId() == $categoriaId) {
                $categoriaActual = $categoria;
                break;
            }
        }
        return $categoriaActual;
    }

    /**
     * Lists all Publicacion entities.
     *
     * @Route("/", name="publicaciones")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $categoria = $this->getCategoriaDefault();


        return array(
            'categoria' => $categoria,
            'entities' => $categoria->getPublicaciones(),
        );
    }

    /**
     * Lists all Publicacion entities for eventos.
     *
     * @Route("/categoria/{slug}", name="publicaciones_categoria")
     * @Method("GET")
     * @Template("PublicacionesBundle:Publicacion:index.html.twig")
     */
    public function categoriaAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')
                ->findOneBy(array('slug' => $slug));

        if (!$categoria) {
            throw $this->createNotFoundException('Unable to find CategoriaPublicacion entity.');
        }

        $filters = $this->getFilters();
        $filters['categorias'] = $categoria->getId();
        $this->setFilters($filters);

        return array(
            'categoria' => $categoria,
            'entities' => $categoria->getPublicaciones(),
        );
    }

    /**
     * Creates a new Publicacion entity.
     *
     * @Route("/", name="publicaciones_create")
     * @Method("POST")
     * @Template("PublicacionesBundle:Publicacion:new.html.twig")
     */
    public function createAction(Request $request) {
        $parameters = $request->request->all();
        $entity = new Publicacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$entity->setPosition(1);
			$categoria = $entity->getCategoria();
            $em->persist($entity);
			
			$cont=2;
			foreach($categoria->getPublicaciones() as $publicacion){
				$publicacion->setPosition($cont++);
			}
			
            $em->flush();

            return $this->redirect($this->generateUrl('publicaciones_show', array('id' => $entity->getId())));
        }

        return array(
            'categoria' => $this->getCategoriaDefault(),
            'entity' => $entity,
            'form' => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
     * Creates a form to create a Publicacion entity.
     *
     * @param Publicacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Publicacion $entity) {
        $form = $this->createForm(new PublicacionType(), $entity, array(
            'action' => $this->generateUrl('publicaciones_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Publicacion entity.
     *
     * @Route("/new", name="publicaciones_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $publicacion = new Publicacion();
        
        $max = $this->getDoctrine()->getRepository('PublicacionesBundle:Publicacion')
                ->getMaxPosicion();

        if (!is_null($max)) {
            $publicacion->setPosition($max + 1);
        } else {
            $publicacion->setPosition(1);
        }

        $publicacion->setCategoria($this->getCategoriaDefault());
        
        $publicacion->setUsuario($this->getUser());

        $form = $this->createCreateForm($publicacion);

        return array(
            'categoria' => $this->getCategoriaDefault(),
            'entity' => $publicacion,
            'form' => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
     * Finds and displays a Publicacion entity.
     *
     * @Route("/{id}", name="publicaciones_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'get_galerias' => $this->generateUrl('publicaciones_galerias', array('id' => $entity->getId())),
            'post_galerias' => $this->generateUrl('publicaciones_galerias_upload', array('id' => $entity->getId())),
            'post_galerias_link_video' => $this->generateUrl('publicaciones_galerias_link_video', array('id' => $entity->getId())),
            'url_delete' => $this->generateUrl('publicaciones_galerias_delete', array('id' => $entity->getId(), 'idGaleria' => '0')),
        );
    }

    /**
     * Displays a form to edit an existing Publicacion entity.
     *
     * @Route("/{id}/edit", name="publicaciones_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicacion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'categoria' => $entity->getCategoria(),
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm)
        );
    }

    /**
     * Creates a form to edit a Publicacion entity.
     *
     * @param Publicacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Publicacion $entity) {
        $form = $this->createForm(new PublicacionType(), $entity, array(
            'action' => $this->generateUrl('publicaciones_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Publicacion entity.
     *
     * @Route("/{id}", name="publicaciones_update")
     * @Method("PUT")
     * @Template("PublicacionesBundle:Publicacion:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('publicaciones_show', array('id' => $id)));
        }

        return array(
            'categoria' => $entity->getCategoria(),
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm)
        );
    }

    /**
     * Deletes a Publicacion entity.
     *
     * @Route("/{id}", name="publicaciones_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publicacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('publicaciones'));
    }

    /**
     * Creates a form to delete a Publicacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('publicaciones_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        /* ->add('submit', 'submit', array(
                          'label' => 'Eliminar',
                          'attr'=>array(
                          'class'=>'btn btn-danger'
                          ))) */
                        ->getForm()
        ;
    }
	
	/**
     * Up registro.
     *
     * @Route("/{id}/up", name="publicaciones_up")
     * @Method("PATCH")
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroUp = $this->findOr404($id);
        
        if ($registroUp) {
            $registroDown=$em->getRepository('PublicacionesBundle:Publicacion')
                    ->getRegistroUpOrDown($registroUp,true);
            if ($registroDown) {
                $posicion=$registroUp->getPosition();
                $registroUp->setPosition($registroDown->getPosition());
                $registroDown->setPosition($posicion);
                $em->flush();
            }
        }
        
        $response = new JsonResponse();
        $response->setData(array("ok"=>true));
        return $response;
    }
    
    /**
     * Down registro.
     *
     * @Route("/{id}/down", name="publicaciones_down")
     * @Method("PATCH")
     */
    public function downAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroDown = $this->findOr404($id);
        
        if ($registroDown) {
            $registroUp=$em->getRepository('PublicacionesBundle:Publicacion')
                    ->getRegistroUpOrDown($registroDown,false);
            if ($registroUp) {
                $posicion=$registroUp->getPosition();
                $registroUp->setPosition($registroDown->getPosition());
                $registroDown->setPosition($posicion);
                $em->flush();
            }
        }
        
        $response = new JsonResponse();
        $response->setData(array("ok"=>true));
        return $response;
    }
	
    /**
     * Ordenar las posiciones de las publicaciones.
     *
     * @Route("/ordenar/registros", name="publicaciones_ordenar")
     * @Method("PATCH")
     */
    public function ordenarRegistrosAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $registro_order = $request->query->get('registro');
            $em = $this->getDoctrine()->getManager();
            $result['ok'] = true;
            foreach ($registro_order as $order => $id) {
                $registro = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);
                if ($registro->getPosition() != ($order + 1)) {
                    try {
                        $registro->setPosition($order + 1);
                        $em->flush();
                    } catch (Exception $e) {
                        $result['mensaje'] = $e->getMessage();
                        $result['ok'] = false;
                    }
                }
            }

            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $response->setData($result);
            return $response;
        } else {
            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $response->setData(array('ok' => false));
            return $response;
        }
    }
    
    /**
     * Lists all Proyecto galerias entities.
     *
     * @Route("/{id}/galerias", name="publicaciones_galerias", requirements={"id" = "\d+"})
     * @Method("GET")
     */
    public function galeriasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $autobus = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);
        
        $galerias = $autobus->getGalerias();
        $get_galerias = $this->generateUrl('publicaciones_galerias',array('id'=>$autobus->getId()));
        $post_galerias = $this->generateUrl('publicaciones_galerias_upload', array('id'=>$autobus->getId()));
	$post_galerias_link_video = $this->generateUrl('publicaciones_galerias_link_video',array('id'=>$autobus->getId()));
        $url_delete = $this->generateUrl('publicaciones_galerias_delete',array('id'=>$autobus->getId(),'idGaleria'=>'0'));
        
        return $this->render('GaleriasBundle:Galeria:galerias.html.twig', array(
            'galerias'=>$galerias,
            'get_galerias' =>$get_galerias,
            'post_galerias' =>$post_galerias,
            'post_galerias_link_video' =>$post_galerias_link_video,
            'url_delete' => $url_delete,
        ));
    }
    
    /**
     * Crea una galeria de una autobus.
     *
     * @Route("/{id}/galerias", name="publicaciones_galerias_upload", requirements={"id" = "\d+"})
     * @Method("POST")
     */
    public function galeriasUploadAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $autobus=$em->getRepository('PublicacionesBundle:Publicacion')->find($id);
       
        if(!$request->request->has('tipoArchivo')){ 
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array("jpeg","png","gif","jpg");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit,$request->server);
            $uploads= $this->container->getParameter('richpolis.uploads');
            $result = $uploader->handleUpload($uploads."/galerias/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            $max = $em->getRepository('GaleriasBundle:Galeria')->getMaxPosicion();
            if($max == null){
                $max=0;
            }
            if(isset($result["success"])){
                $registro = new Galeria();
                $registro->setArchivo($result["filename"]);
                $registro->setThumbnail($result["filename"]);
                $registro->setTitulo($result["titulo"]);
                $registro->setIsActive(true);
                $registro->setPosition($max+1);
                $registro->setTipoArchivo(RpsStms::TIPO_ARCHIVO_IMAGEN);
                //unset($result["filename"],$result['original'],$result['titulo'],$result['contenido']);
                $em->persist($registro);
                $registro->crearThumbnail();
                $autobus->getGalerias()->add($registro);
                $em->flush();
            }
        }else{
            $result = $request->request->all(); 
            $registro = new Galeria();
            $registro->setArchivo($result["archivo"]);
            $registro->setIsActive($result['isActive']);
            $registro->setPosition($result['position']);
            $registro->setTipoArchivo($result['tipoArchivo']);
            $em->persist($registro);
            $autobus->getGalerias()->add($registro);
            $em->flush();  
        }
        
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData($result);
        return $response;
    }
    
    /**
     * Crea una galeria link video de una autobus.
     *
     * @Route("/{id}/galerias/link/video", name="publicaciones_galerias_link_video", requirements={"id" = "\d+"})
     * @Method({"POST","GET"})
     */
    public function galeriasLinkVideoAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $autobus=$em->getRepository('PublicacionesBundle:Publicacion')->find($id);
        $parameters = $request->request->all();
      
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
     * Deletes una Galeria entity de una Proyecto.
     *
     * @Route("/{id}/galerias/{idGaleria}", name="publicaciones_galerias_delete", requirements={"id" = "\d+","idGaleria"="\d+"})
     * @Method("DELETE")
     */
    public function deleteGaleriaAction(Request $request, $id, $idGaleria)
    {
            $em = $this->getDoctrine()->getManager();
            $autobus = $em->getRepository('PublicacionesBundle:Publicacion')->find($id);
            $galeria = $em->getRepository('GaleriasBundle:Galeria')->find(intval($idGaleria));

            if (!$autobus) {
                throw $this->createNotFoundException('Unable to find Proyecto entity.');
            }
            
            $autobus->getGalerias()->removeElement($galeria);
            $em->remove($galeria);
            $em->flush();
        

        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData(array("ok"=>true));
        return $response;
    }
}
