<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cresta\AulasBundle\Entity\Reserva;
use Cresta\AulasBundle\Form\ReservaType;
use Cresta\AulasBundle\Controller\MovimientoController;



use Cresta\AulasBundle\Entity\Movimiento;

require_once 'ReservaController.php';
/**
 * Reserva controller.
 *
 */
class ReservaController extends Controller
{

    /**
     * Lists all Reserva entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();                
        return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Reserva entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Reserva();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_reserva_show', array('id' => $entity->getId())));
        }

        return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Reserva entity.
     *
     * @param Reserva $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Reserva $entity)
    {
        $form = $this->createForm(new ReservaType(), $entity, array(
            'action' => $this->generateUrl('aulas_reserva_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Reserva entity.
     *
     */
    public function newAction()
    {
        $entity = new Reserva();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reserva entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Reserva:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Reserva entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserva entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrestaAulasBundle:Reserva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Reserva entity.
    *
    * @param Reserva $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reserva $entity)
    {
        $form = $this->createForm(new ReservaType(), $entity, array(
            'action' => $this->generateUrl('aulas_reserva_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Reserva entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_reserva_edit', array('id' => $id)));
        }

        return $this->render('CrestaAulasBundle:Reserva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    protected function nuevoMovimiento($idReserva)
    {      

        
        //Llamo al manejador de entidades
        $em = $this->getDoctrine()->getEntityManager();                 
        //Creo un repositorio para, que es un objeto, para manejar los datos.
        $reservaEliminada = $em->getRepository('CrestaAulasBundle:Reserva')->find($idReserva); //Busco pasando como parametro el id de reserva
        
        
        //$em = $this->getDoctrine()->getEntityManager();                 
        //Creo un repositorio para, que es un objeto, para manejar los datos.
        //$reservaEliminada = $em->getRepository('CrestaAulasBundle:Reserva')->find($idReserva);


        $movimiento = new Movimiento();
        //$MovimientoController = new MovimientoController();
        //$form   = $MovimientoController->createCreateForm($movimiento);
        $fechaDeHoy = date('Y-m-d'); //Asigno la fecha del dia de la baja para pasarlo a la vista y mostrarlo
        
        $movimiento->setFecha(new \DateTime($fechaDeHoy));

        //Busco el objeto reserva a eliminar para asignarle los valores de ese objeto al movimiento
        //$query = $em->createQuery('SELECT u FROM Cresta\AulasBundle\Entity\Reserva u WHERE u.id = :id');
        //$query->setParameter(':id', $idReserva);
        //$reserva = $query->getResult(); // array de objetos Reserva

        //$asd = $reserva[0];

        $reservaPersona = $reservaEliminada->getReservaPersona();
        //PREGUNTO EL NOMBRE DE USUARIO DEL USUARIO QUE EJECUTO LA ACCION DE ELIMINAR
        $user = $this->container->get('security.context')->getToken()->getUser();
        $movimientoPersona = $user->getUsername(); //ASIGNO EL NOMBRE DE USUARIO A UNA VARIABLE
        //var_dump($movimientoPersona);
        $horaDesde = $reservaEliminada->getHoraDesde();
        $horaHasta = $reservaEliminada->getHoraHasta();

        $reservaParaElDiaDeReserva = $reservaEliminada->getFechaReserva();
        //var_dump($reservaParaElDiaDeReserva);
        
        //tomo el id del aula que esta en la reserva
        $idAula = $reservaEliminada->getAula();

        //busco el aula para tomar el nombre
        $em2 = $this->getDoctrine()->getEntityManager();                 
        //Creo un repositorio para, que es un objeto, para manejar los datos.
        $aula = $em2->getRepository('CrestaAulasBundle:Aula')->find($idAula);

        //asigno nombre a varialbe
        $aulaParaMovimiento = $aula->getNombre();
        //var_dump($aulaParaMovimiento);


        $movimiento->setUsuario($movimientoPersona);
        $movimiento->setReservaAula($aulaParaMovimiento);
        

        //$horaDesde->format('h:m:s');
        $horaDesde = date('h:m:s');
        $movimiento->setReservaHoraDesde(new \DateTime($horaDesde));       
        

        //$horaHasta->format('h:m:s');          
        //var_dump($horaHasta1);
        $horaHasta = date('h:m:s');
        $movimiento->setReservaHoraHasta(new \DateTime($horaHasta));


        //$reservaParaElDiaDeReserva->format('Y-m-d');
        //var_dump($reservaParaElDiaDeReserva1);
        $reservaParaElDiaDeReserva = date('Y-m-d');
        $movimiento->setReservaParaDiaDeReserva(new \DateTime($reservaParaElDiaDeReserva));


        $em3 = $this->getDoctrine()->getEntityManager();        
        $em3->persist($movimiento);
        $em3->flush();
        //die('aca llego');

        

        /*return $this->render('CrestaAulasBundle:Movimiento:new.html.twig', array(
            'fecha' => $fechaDeHoy, //Paso la fecha de hoy para que se muestre en la vista
            'reservaEliminada' => $reservaEliminada, //Paso la reserva eliminada para cargar los valores en la vista
            'entity' => $entity, //Paso la entidad movimiento para cargar los valores del movimiento
            'form'   => $form->createView(),
        
        )); */
    }



    /**
     * Deletes a Reserva entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //Esto no va nunca
        //if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);
            $idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id)->getId(); //tomo el id de la reserva para pasarlo para el alta de un movimiento


            //$entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);
            //$idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id)->getId(); //tomo el id de la reserva para pasarlo para el alta de un movimiento
            $idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);


            //$entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);
            //$idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id)->getId(); //tomo el id de la reserva para pasarlo para el alta de un movimiento
            $idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);

            
            //echo($idReserva);
            
            //esto de abajo esta comentado para para ver si en vardump me da los valores de $entity

            /*if (!$entity) {
                throw $this->createNotFoundException('Unable to find Reserva entity.');
            }else{
                //Si esta todo bien, cuando elimino una reserva, creo un objeto movimiento
                $nuevoObjetoMovimiento = new MovimientoController();
                //Llamo al metodo del objeto moviemiento para crear un movimiento
                
                //El problema esta aca, en la invocacion del metodo
                $nuevoObjetoMovimiento->newAction($id);                
                
            } */

            if (!$idReserva) {
                throw $this->createNotFoundException('Unable to find Reserva entity.');
            }
            
             
            //Si esta todo bien, cuando elimino una reserva, creo un objeto movimiento
            //$nuevoObjetoMovimiento = new MovimientoController();
            //Llamo al metodo del objeto moviemiento para crear un movimiento                                     
            //$nuevoObjetoMovimiento->newAction($idReserva);  
       

            //$soy_un_movimiento = $this->get('nuevo_movimiento');
            
            //$soy_un_movimiento->newAction($idReserva);    
                        
            $this->nuevoMovimiento($idReserva);


            $em->remove($entity);
            $em->flush();
        // } Esto no va nunca

        return $this->redirect($this->generateUrl('aulas_reserva'));
    }




    /**
     * Creates a form to delete a Reserva entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_reserva_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


}
