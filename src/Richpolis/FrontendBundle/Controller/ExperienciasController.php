<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\FrontendBundle\Entity\Experiencias;
use Richpolis\FrontendBundle\Form\ExperienciasType;

use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Experiencias controller.
 *
 * @Route("/backend/experiencias")
 */
class ExperienciasController extends Controller
{

    /**
     * Lists all Experiencias entities.
     *
     * @Route("/", name="experiencias")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontendBundle:Experiencias')->getExperienciasActivas();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Experiencias entity.
     *
     * @Route("/", name="experiencias_create")
     * @Method("POST")
     * @Template("FrontendBundle:Experiencias:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Experiencias();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('experiencias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
    * Creates a form to create a Experiencias entity.
    *
    * @param Experiencias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Experiencias $entity)
    {
        $form = $this->createForm(new ExperienciasType(), $entity, array(
            'action' => $this->generateUrl('experiencias_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Experiencias entity.
     *
     * @Route("/new", name="experiencias_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Experiencias();
        $em = $this->getDoctrine()->getManager();
        $max = $em->getRepository('FrontendBundle:Experiencias')->getMaxPosicion();
        if($max == null){
            $max=0;
        }
        $entity->setPosition($max+1);
        $form   = $this->createCreateForm($entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form)
        );
    }

    /**
     * Finds and displays a Experiencias entity.
     *
     * @Route("/{id}", name="experiencias_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Experiencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Experiencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Experiencias entity.
     *
     * @Route("/{id}/edit", name="experiencias_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Experiencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Experiencias entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm)
        );
    }

    /**
    * Creates a form to edit a Experiencias entity.
    *
    * @param Experiencias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Experiencias $entity)
    {
        $form = $this->createForm(new ExperienciasType(), $entity, array(
            'action' => $this->generateUrl('experiencias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Experiencias entity.
     *
     * @Route("/{id}", name="experiencias_update")
     * @Method("PUT")
     * @Template("FrontendBundle:Experiencias:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Experiencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Experiencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('experiencias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm)
        );
    }
    /**
     * Deletes a Experiencias entity.
     *
     * @Route("/{id}", name="experiencias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Experiencias')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Experiencias entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('experiencias'));
    }

    /**
     * Creates a form to delete a Experiencias entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('experiencias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            /*->add('submit', 'submit', array(
                'label' => 'Eliminar',
                'attr'=>array(
                    'class'=>'btn btn-danger'
            )))*/
            ->getForm()
        ;
    }
	
    /**
     * Ordenar las posiciones de los autobuses.
     *
     * @Route("/ordenar/registros", name="experiencias_ordenar")
     * @Method("PATCH")
     */
    public function ordenarRegistrosAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $registro_order = $request->query->get('registro');
            $em = $this->getDoctrine()->getManager();
            $result['ok'] = true;
            foreach ($registro_order as $order => $id) {
                $registro = $em->getRepository('FrontendBundle:Experiencias')->find($id);
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

}
