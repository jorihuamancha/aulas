<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Carrera;
use Cresta\AulasBundle\Form\CarreraType;

/**
 * Carrera controller.
 *
 */
class CarreraController extends Controller
{

    /**
     * Lists all Carrera entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Carrera')->findAll();

        return $this->render('CrestaAulasBundle:Carrera:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Carrera entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Carrera();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_carrera_show', array('id' => $entity->getId())));
        }

        return $this->render('CrestaAulasBundle:Carrera:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Carrera entity.
     *
     * @param Carrera $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Carrera $entity)
    {
        $form = $this->createForm(new CarreraType(), $entity, array(
            'action' => $this->generateUrl('aulas_carrera_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formaction'=>$_SERVER['HTTP_REFERER'],'formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }

    /**
     * Displays a form to create a new Carrera entity.
     *
     */
    public function newAction()
    {
        $entity = new Carrera();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Carrera:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Carrera entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Carrera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrera entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Carrera:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Carrera entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Carrera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrera entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Carrera:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Carrera entity.
    *
    * @param Carrera $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carrera $entity)
    {
        $form = $this->createForm(new CarreraType(), $entity, array(
            'action' => $this->generateUrl('aulas_carrera_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formaction'=>$_SERVER['HTTP_REFERER'],'formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }
    /**
     * Edits an existing Carrera entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Carrera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrera entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_carrera_edit', array('id' => $id)));
        }

        return $this->render('CrestaAulasBundle:Carrera:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Carrera entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Carrera')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Carrera entity.');
            }

            $em->remove($entity);
            $em->flush();
//        }

        return $this->redirect($this->generateUrl('aulas_carrera'));
    }

    /**
     * Creates a form to delete a Carrera entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_carrera_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
