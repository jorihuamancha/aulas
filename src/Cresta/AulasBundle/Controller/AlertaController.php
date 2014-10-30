<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cresta\AulasBundle\Entity\Alerta;
use Cresta\AulasBundle\Form\AlertaType;

/**
 * Alerta controller.
 *
 * @Route("/aulas_alerta")
 */
class AlertaController extends Controller
{

    /**
     * Lists all Alerta entities.
     *
     * @Route("/", name="aulas_alerta")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Alerta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Alerta entity.
     *
     * @Route("/", name="aulas_alerta_create")
     * @Method("POST")
     * @Template("CrestaAulasBundle:Alerta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Alerta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_alerta_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Alerta entity.
     *
     * @param Alerta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Alerta $entity)
    {
        $form = $this->createForm(new AlertaType(), $entity, array(
            'action' => $this->generateUrl('aulas_alerta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Alerta entity.
     *
     * @Route("/new", name="aulas_alerta_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Alerta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Alerta entity.
     *
     * @Route("/{id}", name="aulas_alerta_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alerta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Alerta entity.
     *
     * @Route("/{id}/edit", name="aulas_alerta_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alerta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Alerta entity.
    *
    * @param Alerta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Alerta $entity)
    {
        $form = $this->createForm(new AlertaType(), $entity, array(
            'action' => $this->generateUrl('aulas_alerta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Alerta entity.
     *
     * @Route("/{id}", name="aulas_alerta_update")
     * @Method("PUT")
     * @Template("CrestaAulasBundle:Alerta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alerta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_alerta_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Alerta entity.
     *
     * @Route("/{id}", name="aulas_alerta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alerta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aulas_alerta'));
    }

    /**
     * Creates a form to delete a Alerta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_alerta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
