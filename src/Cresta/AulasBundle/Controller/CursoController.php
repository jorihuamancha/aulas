<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Curso;
use Cresta\AulasBundle\Form\CursoType;
use Exception;

/**
 * Curso controller.
 *
 */
class CursoController extends Controller
{

    /**
     * Lists all Curso entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Curso')->findAll();

        return $this->render('CrestaAulasBundle:Curso:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Curso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Curso();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if($this::existeCurso($entity)){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('aulas_curso_show', array('id' => $entity->getId())));
            }

            return $this->render('CrestaAulasBundle:Curso:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        }else{
            throw new Exception("Ya existe un Curso con ese nombre modifique e intente nuevamente");
        }
    }

    /**
     * Creates a form to create a Curso entity.
     *
     * @param Curso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Curso $entity)
    {
        $form = $this->createForm(new CursoType(), $entity, array(
            'action' => $this->generateUrl('aulas_curso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../curso','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }

    /**
     * Displays a form to create a new Curso entity.
     *
     */
    public function newAction()
    {
        $entity = new Curso();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Curso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Curso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el curso :/ intenta recargando la pagina');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Curso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Curso entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el curso :/ intenta recargando la pagina');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Curso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Curso entity.
    *
    * @param Curso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Curso $entity)
    {
        $form = $this->createForm(new CursoType(), $entity, array(
            'action' => $this->generateUrl('aulas_curso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../curso','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }
    /**
     * Edits an existing Curso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el curso :/ intenta recargando la pagina');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

//            return $this->redirect($this->generateUrl('aulas_curso_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('aulas_curso_show', array('id' => $id)));
        }

        return $this->render('CrestaAulasBundle:Curso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

    }
        
    /**
     * Deletes a Curso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Curso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No pudimos encontrar el curso :/ intenta recargando la pagina');
            }

            $em->remove($entity);
            $em->flush();
  //      }

        return $this->redirect($this->generateUrl('aulas_curso'));
    }

    /**
     * Creates a form to delete a Curso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_curso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-default botonTabla')))
            ->getForm()
        ;
    }

    private function existeCurso ($entity){
        $em = $this->getDoctrine()->getManager();
        $nombre = $entity->getNombre();
        $carrera = $entity->getCarrera();
        $parameters = array('nombre' => $nombre,'carrera' =>  $carrera);

        $query = $em->createQuery('SELECT c FROM CrestaAulasBundle:curso c WHERE c.nombre = :nombre and c.Carrera = :carrera ')->setParameters($parameters);
        $curso = $query->getResult();
        
        if (empty($curso)) {
            $compara = null;
        }else{
            $compara = $curso[0]->getNombre();
        }
        
        if (strtolower($compara) != strtolower($entity->getNombre())){
            return true;
        }else{
            return false;
        }
     }
}
