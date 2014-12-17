<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Reserva;
use Cresta\AulasBundle\Entity\Aula;
use Cresta\AulasBundle\Form\ReservaType;
use Cresta\AulasBundle\Controller\MovimientoController;
use Ps\PdfBundle\Annotation\Pdf;
use Exception;



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
        $filtroActivo=0;

        $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();                
        if (!$entities){
            $entities=null;
        }
        else {
            $_SESSION['entities']=$entities;
        }
        return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array(
            'entities' => $entities,
            'filtroActivo' => $filtroActivo,
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
                
                $fecha=$entity->getFecha();
                $fecha->setTime(00, 00, 00);
                $entity->setFecha($fecha);

                $horaDesde=$entity->getHoraDesde();
                $horaDesde->setDate(2000, 01, 01);
                $entity->setHoraDesde($horaDesde);

                $horaHasta=$entity->getHoraHasta();
                $horaHasta->setDate(2000, 01, 01);
                $entity->setHoraHasta($horaHasta);

                $fechaActual=new \DateTime('now');
                $fechaActual->setTime(00, 00, 00);


                if(($entity->getFecha()>=$fechaActual)&&($entity->getHoraDesde()<$entity->getHoraHasta())){
                    $gola=1; //antes solíamos ser creativos en los nombres de las variables.
                }else{
                    throw new Exception("Compruebe los campos de las fechas y las horas de la reserva.");   
                }
                try{
                    if(($this::sePuede($entity->getFecha(), $entity->getHoraDesde(), $entity->getHoraHasta(), $entity->getAula()))){
                    //&&$entity->getFecha()>=$fechaActual)&&($entity->getHoraDesde()<$entity->getHoraHasta())){
                        $em->persist($entity);   
                        die($entity->getId());
                        $em->flush();
                        }
                }catch(Exception $e){
                //}
                    //$e->getMessage();
                //throw new Exception("Compruebe los campos de las fechas y las horas de la reserva.");
                }

            return $this->redirect($this->generateUrl('reserva_show', array('id' => $entity->getId())));
            }
        return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    private function estaEntre ($fecha, $paramDesde, $paramHasta, $aula){
       //die($paramHasta);
        //$em = $this->getDoctrine()->getManager();//tiro todas las reservas que podrian chocar con la mia
        $em = $this->getDoctrine()->getManager();
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        //dar formato a la fecha
        $fecha->setTime(00, 00, 00);
        $idAula=$aula->getId();
        //$parameters=array('fecha'=>$fecha, 'horaDesde'=>$paramDesde, 'horaHasta'=>$paramHasta, 'aula'=>$idAula);
        //$query=$reserva->createQuery('   SELECT r FROM CrestaAulasBundle:Reserva r
                                       //  WHERE fecha= :fecha AND aula_id= :aula)

    private function sePuede($fecha, $paramDesde, $paramHasta, $aula){
        //die($paramHasta);
        //$em = $this->getDoctrine()->getManager();//tiro todas las reservas que podrian chocar con la mia
        $em = $this->getDoctrine()->getManager();
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        //dar formato a la fecha
        $fecha->setTime(00, 00, 00);
        $idAula=$aula->getId();
        //$parameters=array('fecha'=>$fecha, 'horaDesde'=>$paramDesde, 'horaHasta'=>$paramHasta, 'aula'=>$idAula);
        $query=$reserva->createQuery('   SELECT r FROM CrestaAulasBundle:Reserva r
                                         WHERE fecha= :fecha AND aula_id= :aula)

        /*('   SELECT r FROM CrestaAulasBundle:Reserva r
                                         WHERE fecha= :fecha AND aula_id= :aula AND
                                    ( 
                                      /*  (r.horaDesde<= :horaDesde OR r.horaDesde>:horaDesde ) OR
                                        (r.horaHasta<= :horaDesde OR r.horaHasta>:horaDesde ) OR
                                        (r.horaDesde<= :horaDesde AND r.horaHasta>=:horaDesde ) OR
                                        (r.horaDesde> :horaDesde AND r.horaHasta<=:horaDesde )*/
                                    )
                                    ')->setParameter('fecha', $fecha)
                                      ->setParameter('horaDesde', $paraDesde)
                                      ->setParameter('horaHasta', $paramHasta)
                                      ->setParameter('aula', $idAula)
                                      ->getQuery();

        //->setParameters($parameters);
        /*echo 'fecha </br>';
        var_dump($fecha);
        echo '</br> paramDesde </br>';
        var_dump($paramDesde);
         echo '</br> paramHasta </br>';
        var_dump($paramHasta);
         echo '</br> Aula    </br>';
        var_dump($idAula);
        die();*/
        //r.horaDesde y r.horaHasta son los valores de las tuplas

        $listado = $query->getResult();
        die('hola');
        //$re=$listado[0]->getObservaciones();
        //die($re);
        if(empty($listado)){
            
            die('hola');
            return true;
        }else{
            return false;
        }
    }
    /*public function sePuede($fecha, $paramDesde, $paramHasta, $aula){
        die($paramHasta);
        $em = $this->getDoctrine()->getManager();//tiro todas las reservas que podrian chocar con la mia
        $query=$em->createQuery('   SELECT r FROM CrestaAulasBundle:Reserva r 
                                    WHERE r.aula= :aula AND r.fecha= :fecha AND 
                                    (r.horaDesde BETWEEN (:paramDesde AND :paramHasta) ) OR 
                                    (r.horaHasta BETWEEN (:paramDesde AND :paramHasta) ) OR
                                    (r.horaDesde<=:paramDesde AND r.horaHasta>=:paramHasta)                                    
                                    ');
        //r.horaDesde y r.horaHasta son los valores de las tuplas
        $listado=$query->getResult();
        $re=$listado[0]->getObservaciones();
        die($re);
        /*if(empty($listado)){
            return false;
        }else{
            return true;
        }

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
            'action' => $this->generateUrl('reserva_create'),
            'method' => 'POST',
        ));
        //$user = $this->container->get('security.context')->getToken()->getUser();

        $form->add('submit', 'submit', array('label' => 'Registrar','attr'=>array('class'=>'btn btn-default botonTabla')));

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
        //$user='1';
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CrestaAulasBundle:Usuario')->find($this->container->get('security.context')->getToken()->getUser());
        $idUsuario=$usuario->getId();
        
        return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
            'usuario'=> $idUsuario,
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
            'action' => $this->generateUrl('reserva_update', array('id' => $entity->getId())),
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
            //modificado para que grabe las fechas y horas con formato
            $fecha=$entity->getFecha();
            $fecha->setTime(00, 00, 00);
            $entity->setFecha($fecha);

            $horaDesde=$entity->getHoraDesde();
            $horaDesde->setDate(2000, 01, 01);
            $entity->setHoraDesde($horaDesde);

            $horaHasta=$entity->getHoraHasta();
            $horaHasta->setDate(2000, 01, 01);
            $entity->setHoraHasta($horaHasta);

            $fechaActual=new \DateTime('now');
            $fechaActual->setTime(00, 00, 00);
            //fin de configuracion de las fechas y horas

            $em->flush();

            //return $this->redirect($this->generateUrl('reserva_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('reserva_show', array('id' => $id)));
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
        //$fechaDeHoy = date('Y-m-d'); //Asigno la fecha del dia de la baja para pasarlo a la vista y mostrarlo
        
        //$movimiento->setFecha(new \Date($fechaDeHoy));
        $movimiento->setFecha(new \DateTime('now'));
        //Busco el objeto reserva a eliminar para asignarle los valores de ese objeto al movimiento
        //$query = $em->createQuery('SELECT u FROM Cresta\AulasBundle\Entity\Reserva u WHERE u.id = :id');
        //$query->setParameter(':id', $idReserva);
        //$reserva = $query->getResult(); // array de objetos Reserva
        //$asd = $reserva[0];
        //$reservaPersona = $reservaEliminada->getReservaPersona();
        //PREGUNTO EL NOMBRE DE USUARIO DEL USUARIO QUE EJECUTO LA ACCION DE ELIMINAR
        $user = $this->container->get('security.context')->getToken()->getUser();
        $movimientoPersona = $user->getUsername(); //ASIGNO EL NOMBRE DE USUARIO A UNA VARIABLE
        //var_dump($movimientoPersona);
        $horaDesde = $reservaEliminada->getHoraDesde();
        $horaHasta = $reservaEliminada->getHoraHasta();
        $reservaParaElDiaDeReserva = $reservaEliminada->getFecha();
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
        //                                                          $horaDesde->format('H:i');

        $movimiento->setReservaHoraDesde($horaDesde);       
        
        //$horaHasta->format('h:m:s');
        //                                                          $horaHasta->format('H:i');
        //var_dump($horaHasta1);
        $movimiento->setReservaHoraHasta($horaHasta);
        //                                                          $reservaParaElDiaDeReserva->format('Y-m-d');
        //var_dump($reservaParaElDiaDeReserva1);
        $movimiento->setReservaParaDiaDeReserva($reservaParaElDiaDeReserva);
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


            $em->remove($idReserva);
            $em->flush();
        // } Esto no va nunca

        return $this->redirect($this->generateUrl('reserva'));
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
            ->setAction($this->generateUrl('reserva_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
    * @Pdf()
    */

    public function imprimirAction(){// http://localhost/aulas/web/app_dev.php/imprimir/listado.pdf
        $em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();                
        $entities = $_SESSION['entities'];
        if ($_SESSION['entities']){
            die ('si');
        }
        else {die('no');}
        die();
        $formato=$this->get('request')->get('_format');
        return $this->render(sprintf('CrestaAulasBundle:Reserva:imprimirlistado.pdf.twig', $formato ),  
        array( 'entities'=>$entities) );   //'nombre'=>$nombre) );
    }


    public function filtroAction(){
        $filtro=$this->get('request')->get('filtro');
        $em = $this->getDoctrine()->getManager();
        switch ($filtro) {

            case 'Todos':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();
                $_SESSION['nombrefiltro']='Todos';
                break;

            case 'Fecha':
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2' )
                ->setParameter('fecha1', $_POST['fecha1'])
                ->setParameter('fecha2', $_POST['fecha2'])
                ->orderBy('r.fecha', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                $_SESSION['nombrefiltro']='Fecha';
                $_SESSION['fecha1']=$_POST['fecha1'];
                $_SESSION['fecha2']=$_POST['fecha2'];
                break;

            case 'Docente':
                /*$docente = $em->getRepository('CrestaAulasBundle:Docente')->findByApellido($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($docente);
                */
                $docente = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $docente->createQueryBuilder('d')
                ->where('d.nombre LIKE :dato or d.apellido LIKE :dato' )
                ->setParameter('dato', '%'.$_POST['dato'].'%')
                ->getQuery();
                $docente = $query->getResult();
                $_SESSION['filtro']=$docente;
                $_SESSION['nombrefiltro']='Docente';
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($docente);
                break;

            case 'Aula':
                $aula = $em->getRepository('CrestaAulasBundle:Aula')->findByNombre($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByAula($aula);
                $_SESSION['filtro']=$aula;
                $_SESSION['nombrefiltro']='Aula';
                break;

            case 'Tarea':
                /*$tarea= $em->getRepository('CrestaAulasBundle:Curso')->findByNombre($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($tarea);
                if (!$tarea){
                    $tarea= $em->getRepository('CrestaAulasBundle:Actividad')->findByNombre($_POST['dato']);
                    $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($tarea);
                }
                */
                $curso = $em->getRepository('CrestaAulasBundle:Curso');
                $query = $curso->createQueryBuilder('c')
                ->where('c.nombre LIKE :dato' )
                ->setParameter('dato', '%'.$_POST['dato'].'%')
                ->getQuery();
                $curso = $query->getResult();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($curso);
                $_SESSION['filtro']=$curso;
                $_SESSION['nombrefiltro']='Curso';
                if (!$entities){
                    $actividad = $em->getRepository('CrestaAulasBundle:Actividad');
                    $query = $actividad->createQueryBuilder('a')
                    ->where('a.nombre LIKE :dato' )
                    ->setParameter('dato', '%'.$_POST['dato'].'%')
                    ->getQuery();
                    $actividad = $query->getResult();
                    $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($actividad);
                    $_SESSION['filtro']=$actividad;
                    $_SESSION['nombrefiltro']='Actividad';
                }

                break;
            }

            if (!$entities){
                $entities=null;
            }
            else {
                $_SESSION['entities']=$entities;
            }

            $filtroActivo = 1;


    return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array(
            'entities' => $entities,
            'filtroActivo' => $filtroActivo,
        ));
    }

}

