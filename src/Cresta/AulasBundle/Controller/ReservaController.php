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

        //$entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();                
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha >= :fecha')
                ->setParameter('fecha', date('Y-m-d'))
                ->getQuery();
        $entities = $query->getResult();

        $_SESSION['nombrefiltro']='Hoy'; //Para imprimir

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
                //if(($entity->getFecha()>=$fechaActual)&&($entity->getHoraDesde()<$entity->getHoraHasta())){
                    $em->persist($entity);
                    $em->flush();
                    
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

        /*('   SELECT r FROM CrestaAulasBundle:Reserva r
                                         WHERE fecha= :fecha AND aula_id= :aula AND
                                    ( 
                                      /*  (r.horaDesde<= :horaDesde OR r.horaDesde>:horaDesde ) OR
                                        (r.horaHasta<= :horaDesde OR r.horaHasta>:horaDesde ) OR
                                        (r.horaDesde<= :horaDesde AND r.horaHasta>=:horaDesde ) OR
                                        (r.horaDesde> :horaDesde AND r.horaHasta<=:horaDesde )*/
                                  //  )
                                //    ')->setParameter('fecha', $fecha)
                                //      ->setParameter('horaDesde', $paraDesde)
                                //      ->setParameter('horaHasta', $paramHasta)
                                //      ->setParameter('aula', $idAula)
                                //      ->getQuery();

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

    }*/

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
        

        $em = $this->getDoctrine()->getEntityManager();                 

        $reservaEliminada = $em->getRepository('CrestaAulasBundle:Reserva')->find($idReserva);

        $movimiento = new Movimiento();
      
        $movimiento->setFecha(new \DateTime('now'));
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        $movimientoPersona = $user->getUsername(); 

        $horaDesde = $reservaEliminada->getHoraDesde();
        $horaHasta = $reservaEliminada->getHoraHasta();
        $reservaParaElDiaDeReserva = $reservaEliminada->getFecha();

        $idAula = $reservaEliminada->getAula();
        $em2 = $this->getDoctrine()->getEntityManager();                 

        $aula = $em2->getRepository('CrestaAulasBundle:Aula')->find($idAula);

        $aulaParaMovimiento = $aula->getNombre();

        $movimiento->setUsuario($movimientoPersona);
        $movimiento->setReservaAula($aulaParaMovimiento);
        


        $movimiento->setReservaHoraDesde($horaDesde);       

        $movimiento->setReservaHoraHasta($horaHasta);

        $movimiento->setReservaParaDiaDeReserva($reservaParaElDiaDeReserva);
        $em3 = $this->getDoctrine()->getEntityManager();        
        $em3->persist($movimiento);
        $em3->flush();
 
    }





    /**
     * Deletes a Reserva entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);
     
            $idReserva = $em->getRepository('CrestaAulasBundle:Reserva')->find($id);

            if (!$idReserva) {
                throw $this->createNotFoundException('Unable to find Reserva entity.');
            }
            
            
            $this->nuevoMovimiento($idReserva);


            $em->remove($idReserva);
            $em->flush();

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
        //$entities = $_SESSION['entities'];
        $nombrefiltro=$_SESSION['nombrefiltro'];
        if (isset($_SESSION['filtro'])){
            $filtro=$_SESSION['filtro'];
        }
        switch ($nombrefiltro){
            case 'Hoy':
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                        ->where('r.fecha >= :fecha')
                        ->setParameter('fecha', date('Y-m-d'))
                        ->getQuery();
                $entities = $query->getResult();
                break;
            
            case 'Todos':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();
                break;

            case 'Docente':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($filtro);
                break;

            case 'Fecha':
                $em = $this->getDoctrine()->getManager();
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2' )
                ->setParameter('fecha1', $_SESSION['fecha1'])
                ->setParameter('fecha2', $_SESSION['fecha2'])
                ->orderBy('r.fecha', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;

            case 'Aula':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByAula($filtro);
                break;

            case 'Curso':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($filtro);
                break;

            case 'Actividad':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($filtro);
                break;
        }

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
                $_SESSION['nombrefiltro']='Todos';//Para imprimir
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
                $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir
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
                $_SESSION['filtro']=$docente;//Para imprimir
                $_SESSION['nombrefiltro']='Docente';//Para imprimir
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($docente);
                break;

            case 'Aula':
                $aula = $em->getRepository('CrestaAulasBundle:Aula')->findByNombre($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByAula($aula);
                $_SESSION['filtro']=$aula;//Para imprimir
                $_SESSION['nombrefiltro']='Aula';//Para imprimir
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
                    $_SESSION['filtro']=$actividad;//Para imprimir
                    $_SESSION['nombrefiltro']='Actividad';//Para imprimir
                }

                break;
            }

            if (!$entities){
                $entities=null;
            }

            $filtroActivo = 1;


    return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array(
            'entities' => $entities,
            'filtroActivo' => $filtroActivo,
        ));
    }

}

