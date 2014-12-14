<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Recurso;
use Cresta\AulasBundle\Form\RecursoType;
use Exception;

/**
 * Recurso controller.
 *
 */
class RecursoController extends Controller
{

    /**
     * Lists all Recurso entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Recurso')->findAll();

        return $this->render('CrestaAulasBundle:Recurso:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Recurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Recurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

    

        if ($this::existeRecurso($entity)){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('aulas_recurso_show', array('id' => $entity->getId())));
            }
            return $this->render('CrestaAulasBundle:Recurso:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        }else{
           throw new Exception("Ya existe un recurso con ese nombre modifique e intente nuevamente"); 
        }
    }

    /**
     * Creates a form to create a Recurso entity.
     *
     * @param Recurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Recurso $entity)
    {
        $form = $this->createForm(new RecursoType(), $entity, array(
            'action' => $this->generateUrl('aulas_recurso_create'),
            'method' => 'POST',
        ));


        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../recurso','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }

    /**
     * Displays a form to create a new Recurso entity.
     *
     */
    public function newAction()
    {
        $entity = new Recurso();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Recurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Recurso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Recurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Recurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Recurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Recurso entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Recurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el recurso :/ intente recargar la pagina.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Recurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Recurso entity.
    *
    * @param Recurso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Recurso $entity)
    {
        $form = $this->createForm(new RecursoType(), $entity, array(
            'action' => $this->generateUrl('aulas_recurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../recurso','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }
    /**
     * Edits an existing Recurso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Recurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el recurso :/ intente recargar la pagina.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($this::existeRecurso($entity)){
            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('aulas_recurso_edit', array('id' => $id)));
            }

            return $this->render('CrestaAulasBundle:Recurso:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            throw new Exception("Ya existe un recurso con ese nombre modifique e intente nuevamente");
        }
       
    }
    /**
     * Deletes a Recurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Recurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No pudimos encontrar el recurso :/ intente recargar la pagina.');
            }

            $em->remove($entity);
            $em->flush();
//        }

        return $this->redirect($this->generateUrl('aulas_recurso'));
    }

    /**
     * Creates a form to delete a Recurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_recurso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function existeRecurso ($entity){
        $em = $this->getDoctrine()->getManager();
        $pasar = $entity->getNombre();

        $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:recurso r WHERE r.nombre = :nombre')->setParameter('nombre', $pasar);
        $recurso = $query->getResult();
        
        if (empty($recurso)) {
            $compara = null;
        }else{
            $compara = $recurso[0]->getNombre();
        }
        
        if (strtolower($compara) != strtolower($entity->getNombre())){
            return true;
        }else{
            return false;
        }
     }
}
