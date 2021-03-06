<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Docente;
use Cresta\AulasBundle\Form\DocenteType;
use Exception;


/**
 * Docente controller.
 *
 */
class DocenteController extends Controller
{

    /**
     * Lists all Docente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $filtroActivo=0;
        //$entities = $em->getRepository('CrestaAulasBundle:Docente')->findAll();
        $docente = $em->getRepository('CrestaAulasBundle:Docente');
        $query = $docente->createQueryBuilder('r')
                        ->orderBy('r.apellido', 'ASC')
                        ->getQuery();
        $entities = $query->getResult();

        if (!$entities){
            $entities=null;
        }
        else {
            $_SESSION['entities']=$entities;
        }

        return $this->render('CrestaAulasBundle:Docente:index.html.twig', array(
            'entities' => $entities,
            'filtroActivo' => $filtroActivo,
        ));
    }
    /**
     * Creates a new Docente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Docente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_docente_show', array('id' => $entity->getId())));

        }
        

        return $this->render('CrestaAulasBundle:Docente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Docente entity.
     *
     * @param Docente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Docente $entity)
    {
        $form = $this->createForm(new DocenteType(), $entity, array(
            'action' => $this->generateUrl('aulas_docente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../docente','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }

    /**
     * Displays a form to create a new Docente entity.
     *
     */
    public function newAction()
    {
        $entity = new Docente();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Docente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Docente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el docente, intente recargar la pagina');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Docente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Docente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el docente, intente recargar la pagina');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Docente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Docente entity.
    *
    * @param Docente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Docente $entity)
    {
        $form = $this->createForm(new DocenteType(), $entity, array(
            'action' => $this->generateUrl('aulas_docente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../docente','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }
    /**
     * Edits an existing Docente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el docente, intente recargar la pagina');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            //return $this->redirect($this->generateUrl('aulas_docente_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('aulas_docente_show', array('id' => $id)));
        }

        return $this->render('CrestaAulasBundle:Docente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Docente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrestaAulasBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el docente, intente recargar la pagina');
        }elseif ($this::estaEnUso($entity)){
            throw new Exception("Este docente esta actualmente en una reserva, elimine la reserva y podra eliminar el docente");
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('aulas_docente'));
    }

    /**
     * Creates a form to delete a Docente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_docente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function estaEnUso($entity){ 
        $em = $this->getDoctrine()->getManager();
        $docente = $entity->getId();
        $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:Reserva r WHERE r.docente = :docente')
                    ->setParameter('docente', $docente);
        $unaConsulta = $query->getResult();
        if(empty($unaConsulta)){
            return false;
        }else{
            return true;
        }
    }

        public function filtroAction(){
        $filtro=$this->get('request')->get('filtro');
        $em = $this->getDoctrine()->getManager();
        switch ($filtro) {

            case 'todos':
                //$entities = $em->getRepository('CrestaAulasBundle:Docente')->findAll();
                $reserva = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $reserva->createQueryBuilder('r')
                ->orderBy('r.apellido', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;


            case 'apellido':
                $reserva = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.apellido LIKE :apellido')
                ->setParameter('apellido', '%'.$_POST['dato'].'%')
                ->orderBy('r.apellido', 'ASC')
                //->orderBy('r.nombre', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;

            case 'email':
                $reserva = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.email LIKE :email')
                ->setParameter('email', '%'.$_POST['dato'].'%')
                ->orderBy('r.email', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;

             case 'telefono':
                $reserva = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.telefono LIKE :telefono')
                ->setParameter('telefono', '%'.$_POST['dato'].'%')
                ->orderBy('r.telefono', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;
            
        }
        if (!$entities){
            $entities=null;
        }

        $filtroActivo = 1;

        return $this->render('CrestaAulasBundle:Docente:index.html.twig', array('entities' => $entities,'filtroActivo' => $filtroActivo));

    }

     
}
