<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Alerta;
use Cresta\AulasBundle\Form\AlertaType;
use Exception;

/**
 * Alerta controller.
 *
 */
class AlertaController extends Controller
{

    /**
     * Lists all Alerta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('CrestaAulasBundle:Alerta')->findAll();
        $Alerta = $em->getRepository('CrestaAulasBundle:Alerta');
        $query = $Alerta ->createQueryBuilder('r')
                        ->orderBy('r.fecha', 'ASC')
                        //->addOrderBy('r.nombre', 'ASC')
                        ->getQuery();
        $entities = $query->getResult();

        return $this->render('CrestaAulasBundle:Alerta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Alerta entity.
     *
     */
    public function createAction(Request $request){
        $entity = new Alerta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if (!$this::hayReserva($entity)) {
            throw new Exception("Hay una reserva para ese día.");
        }
        try{
            if ($this::existeAlerta($entity)) {
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fecha=$entity->getFecha();
                    $fecha->setTime(00, 00, 00);
                    $entity->setFecha($fecha);
                    $em->persist($entity);
                    $em->flush();

                    return $this->redirect($this->generateUrl('aulas_alerta_show', array('id' => $entity->getId())));
                }
            }
        }catch(Exception $e){}

            return $this->render('CrestaAulasBundle:Alerta:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        
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

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../alerta','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }

    /**
     * Displays a form to create a new Alerta entity.
     *
     */
    public function newAction()
    {
        $entity = new Alerta();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Alerta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Alerta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar esta alerta, intenta recargar la pagina.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Alerta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Alerta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar esta alerta, intenta recargar la pagina.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Alerta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../alerta','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

        return $form;
    }
    /**
     * Edits an existing Alerta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar esta alerta, intenta recargar la pagina.');
        }

        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
             if (!$this::hayReserva($entity)) {
                throw new Exception("No puede editar la alerta, hay una o más reservas ese día.");
            }
            $fecha=$entity->getFecha();
            $fecha->setTime(00, 00, 00);
            $entity->setFecha($fecha);
            $em->flush();
             //return $this->redirect($this->generateUrl('aulas_alerta_edit', array('id' => $id)));
             return $this->redirect($this->generateUrl('aulas_alerta_show', array('id' => $entity->getId())));
          }


    return $this->render('CrestaAulasBundle:Alerta:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
    }
    /**
     * Deletes a Alerta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Alerta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No pudimos encontrar esta alerta, intenta recargar la pagina.');
            }

            $em->remove($entity);
            $em->flush();
//        }

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

    private function existeAlerta ($entity){
        $em = $this->getDoctrine()->getManager();
        $fecha = $entity->getFecha();

        $query = $em->createQuery('SELECT a FROM CrestaAulasBundle:alerta a WHERE a.fecha = :fecha ')
                    ->setParameter('fecha',$fecha);

        $actividad = $query->getResult();
        
        if (empty($actividad)) {
            return true;

        }else{
           return false;
        }
    
     }

    private function hayReserva ($entity){
        $em = $this->getDoctrine()->getManager();
        $fecha = $entity->getFecha();
        $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:Reserva r WHERE r.fecha = :fecha ')
                    ->setParameter('fecha',$fecha);
        $reserva = $query->getResult();
        if (empty($reserva)) {
            return true;
        }else{
            return false;
        }
    
    }

}
