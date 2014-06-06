<?php

namespace Richpolis\PublicacionesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\PublicacionesBundle\Entity\CategoriaPublicacion;
use Richpolis\PublicacionesBundle\Form\CategoriaPublicacionType;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Richpolis\PublicacionesBundle\Entity\Publicacion;
use PHPExcel_Cell;

/**
 * CategoriaPublicacion controller.
 *
 * @Route("/categorias/publicaciones")
 */
class CategoriaPublicacionController extends Controller {

    private $categorias = null;

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
     * Lists all CategoriaPublicacion entities.
     *
     * @Route("/", name="categorias_publicaciones")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CategoriaPublicacion entity.
     *
     * @Route("/", name="categorias_publicaciones_create")
     * @Method("POST")
     * @Template("PublicacionesBundle:CategoriaPublicacion:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new CategoriaPublicacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categorias_publicaciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
     * Creates a form to create a CategoriaPublicacion entity.
     *
     * @param CategoriaPublicacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CategoriaPublicacion $entity) {
        $form = $this->createForm(new CategoriaPublicacionType(), $entity, array(
            'action' => $this->generateUrl('categorias_publicaciones_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CategoriaPublicacion entity.
     *
     * @Route("/new", name="categorias_publicaciones_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new CategoriaPublicacion();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
     * Finds and displays a CategoriaPublicacion entity.
     *
     * @Route("/{id}", name="categorias_publicaciones_show", requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaPublicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CategoriaPublicacion entity.
     *
     * @Route("/{id}/edit", name="categorias_publicaciones_edit", requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaPublicacion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm)
        );
    }

    /**
     * Creates a form to edit a CategoriaPublicacion entity.
     *
     * @param CategoriaPublicacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CategoriaPublicacion $entity) {
        $form = $this->createForm(new CategoriaPublicacionType(), $entity, array(
            'action' => $this->generateUrl('categorias_publicaciones_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CategoriaPublicacion entity.
     *
     * @Route("/{id}", name="categorias_publicaciones_update", requirements={"id" = "\d+"})
     * @Method("PUT")
     * @Template("PublicacionesBundle:CategoriaPublicacion:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaPublicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('categorias_publicaciones_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm)
        );
    }

    /**
     * Deletes a CategoriaPublicacion entity.
     *
     * @Route("/{id}", name="categorias_publicaciones_delete", requirements={"id" = "\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoriaPublicacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('categorias_publicaciones'));
    }

    /**
     * Creates a form to delete a CategoriaPublicacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('categorias_publicaciones_delete', array('id' => $id)))
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
     * Ordenar las posiciones de las categorias publicaciones.
     *
     * @Route("/ordenar/registros", name="categorias_publicaciones_ordenar")
     * @Method("PATCH")
     */
    public function ordenarRegistrosAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $registro_order = $request->query->get('registro');
            $em = $this->getDoctrine()->getManager();
            $result['ok'] = true;
            foreach ($registro_order as $order => $id) {
                $registro = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->find($id);
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
     * @Route("/exportar", name="categorias_publicaciones_exportar")
     * @Method({"GET", "POST"})
     */
    public function exportarAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            if ($request->request->has('exportarTodos') && $request->request->get('exportarTodos')) {
                $entities = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')->findAll();
            } elseif ($request->request->has('inputDesde') &&
                    $request->request->has('inputHasta')) {
                $entities = $em->getRepository('PublicacionesBundle:CategoriaPublicacion')
                        ->findEntreFechas($request->request->get('inputDesde'), $request->request->get('inputHasta'));
            }
            $filename = "maldivino_db.xls";
            $response = $this->render('PublicacionesBundle:CategoriaPublicacion:tablaExportar.html.twig', array('entities' => $entities));
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            return $response;
        }

        return $this->render("PublicacionesBundle:CategoriaPublicacion:exportar.html.twig");
    }

    /**
     * @Route("/importar", name="categorias_publicaciones_importar")
     * @Method({"GET", "POST"})
     */
    public function importarAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $archivo = $request->files->get('archivo');
            if ($archivo instanceof UploadedFile) {
                $uploads = $this->container->getParameter('richpolis.uploads');
                $archivo->move(
                        $uploads, $archivo->getClientOriginalName()
                );
                $fileName = $uploads . '/' . $archivo->getClientOriginalName();
                $this->importar($fileName);
            } else {
                print_r("Error al subir archivo");
                die();
            }

            return $this->redirect($this->generateUrl('categorias_publicaciones'));  
        }

        return $this->render("PublicacionesBundle:CategoriaPublicacion:importar.html.twig");
    }

    private function importar($filename) {
        // estas lineas nos puede servir para comprobar que nuestro fichero
        // que queremos cargar existe
        // $fileWithPath - Es el nombre del fichero con el path completo
        // if(file_exists($fileWithPath)) {
        //      echo 'exist'."<br>";
        // } else {
        //      echo 'dont exist'."<br>";
        //      die;
        // }
        //cargamos el archivo a procesar.
        $objPHPExcel = $this->get('phpexcel')->createPHPExcelObject($filename);
        //se obtienen las hojas, el nombre de las hojas y se pone activa la primera hoja
        $total_sheets = $objPHPExcel->getSheetCount();
        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        //Se obtiene el número máximo de filas
        $highestRow = $objWorksheet->getHighestRow();
        //Se obtiene el número máximo de columnas
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        //$headingsArray contiene las cabeceras de la hoja excel. Llos titulos de columnas
        $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
        $headingsArray = $headingsArray[1];

        //Se recorre toda la hoja excel desde la fila 2 y se almacenan los datos
        $r = -1;
        $namedDataArray = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
            if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                ++$r;
                foreach ($headingsArray as $columnKey => $columnHeading) {
                    $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                } //endforeach
            } //endif
        }
        $this->loadToDB($namedDataArray);
    }

    private function loadToDB($registros = null) {
        $em = $this->getDoctrine()->getManager();
        if ($registros && count($registros) > 1) {
            foreach ($registros as $botella) {
                if (strtolower($botella['ACTION']) == "alta") {
                    $categoria = $this->getCategoria($botella, $em);
                    $producto = new Publicacion();
                    $producto->setTitulo($botella['PRODUCTO']);
                    $producto->setPrecio($botella['PRECIO']);
                    $producto->setPosition($botella['POSITION']);
                    $producto->setIsActive($botella['IS_ACTIVE']);
                    $producto->setCategoria($categoria);
                    $producto->setUsuario($this->getUser());
                    $em->persist($producto);
                    $em->flush();
                }
            }
        }
    }

    private function getCategoria($botella, $em) {
        $categoria = null;
        if (is_numeric($botella['CATEGORIA_ID']) && $botella['CATEGORIA_ID'] > 0) {
            $categoria = $this->getCategoriaActual($botella['CATEGORIA_ID']);
        } elseif (strlen($botella['CATEGORIA']) > 0) {
            $categorias = $this->getCategoriasPublicacion();
            foreach($categorias as $cat) {
                if ($cat->getNombre() == $botella['CATEGORIA']) {
                    $categoria = $cat;
                    break;
                }
            }
        }
        if (!$categoria) {
            $categoria = new CategoriaPublicacion();
            $categoria->setNombre($botella['CATEGORIA']);
            $max = $em->getRepository('GaleriasBundle:Galeria')->getMaxPosicion();
            if ($max == null) {
                $max = 0;
            }
            $categoria->setPosition($max + 1);
            $categoria->setIsActive(true);
            $em->persist($categoria);
            $em->flush();
            $this->categorias[] = $categoria;
        }
        return $categoria;
    }

}
