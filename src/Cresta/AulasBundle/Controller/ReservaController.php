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
                ->where('r.fecha = :fecha')
                ->setParameter('fecha', date('Y-m-d'))
                ->orderBy('r.horaDesde', 'ASC')
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
    public function createAction(Request $request){

        $entity = new Reserva();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($entity->getRango > 1){
            $hayVariasCargas = true;
        }else{
            $hayVariasCargas = false;
        }
        if ($form->isValid()) {
            //generico de las dos formas.
            $em = $this->getDoctrine()->getManager();
            //Aca se almacena el nombre de usuario.
            $entity->setdiosReserva($this->container->get('security.context')->getToken()->getUser());
            //Hora desde
            $horaDesde=$entity->getHoraDesde();
            $horaDesde->setDate(2000, 01, 01);
            $entity->setHoraDesde($horaDesde);
            //Hora hasta
            $horaHasta=$entity->getHoraHasta();
            $horaHasta->setDate(2000, 01, 01);
            $entity->setHoraHasta($horaHasta);
            //Fecha actual
            $fechaActual=new \DateTime('now');
            $fechaActual->setTime(00, 00, 00);
            //rangoDesde
            $rangoDesde =$entity->getRangoDesde();
            $rangoDesde->setTime(00, 00, 00);
            $entity->setRangoDesdes($rangoDesde);
            //RangoHasta
            $rangoHasta = $entity->getrangoHasta();
            $rangoHasta->setTime(00, 00, 00);
            $entity->setRangoHasta($rangoHasta);
            //Es una reserva unica
            if(!$hayVariasCargas){
                //Fecha para realizar la reserva
                $fecha=$entity->getFecha();
                $fecha->setTime(00, 00, 00);
                $entity->setFecha($fecha);

                if (!($entity->getFecha()>=$fechaActual)) {
                    throw new Exception("La fecha para reservar deberia ser mas grande que la fecha actual.");  
                }elseif (!($entity->getHoraDesde() < $entity->getHoraHasta())) {
                    throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
                }elseif (!$this::conprobarAlerta($entity->getFecha())){
                    throw new Exception("Hay una alerta activa para el dia que desea agregar una reserva.");
                }elseif (!($this->sePuede($entity))) {
                    throw new Exception("Hay reservas para esa aula con esas fecha y hora");
                }  
                try{
                    $em->persist($entity);
                    $em->flush();
                }catch(Exception $e){
                   
                }
                return $this->redirect($this->generateUrl('reserva_show', array('id' => $entity->getId())));

            }//Son varias reservas.
            else{
                $entityAux = $entity;
                $fechaDeReservaActual = $entity->getFecha();
                $fechaMax = $entity->getrangoHasta();
                $em->flush();
                while ( $fechaMax >= $fechaDeReservaActual ) {
                   $entityNuevo = new Reserva();

                }
            }
        }
       return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
           'entity' => $entity,
           'form'   => $form->createView()
      ));
    }

    private function conprobarAlerta ($fecha){

        $em = $this->getDoctrine()->getManager();
        $fecha = $fecha ;
        $query = $em->createQuery('SELECT a FROM CrestaAulasBundle:Alerta a WHERE a.fecha = :fecha')->setParameter('fecha', $fecha);
        $unaConsulta = $query->getResult();
        if(empty($unaConsulta)){
            return true;
        }else{
            return false;
        }
    }

    private function sePuede ($entity){

        $em = $this->getDoctrine()->getManager();
        
        $fecha=$entity->getFecha();
        $idAula=$entity->getAula();
        $horaDesde=$entity->getHoraDesde();
        $horaHasta=$entity->getHoraHasta();
        $id = $entity->getId();
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');

        $query = $reserva->createQueryBuilder('r')
                        ->where('((r.id <> :id) AND
                            (r.fecha= :fecha AND r.aula= :aula)) AND
                            ((r.horaDesde >= :horaDesde AND r.horaDesde < :horaHasta ) OR
                            (r.horaHasta > :horaDesde AND r.horaHasta <= :horaHasta ) OR
                            (r.horaDesde <= :horaDesde AND r.horaHasta >= :horaHasta ) OR
                            (r.horaDesde >= :horaDesde AND r.horaHasta <= :horaHasta ) )
                            ')
                        ->setParameter('id', $id)
                        ->setParameter('fecha', $fecha)
                        ->setParameter('aula', $idAula)
                        ->setParameter('horaDesde', $horaDesde)
                        ->setParameter('horaHasta', $horaHasta)
                        ->getQuery();

        $listado = $query->getResult();

        if(empty($listado)){
            return true;
        }else{
            return false;
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
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../reserva','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

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

        //$entity->setdiosReserva($this->container->get('security.context')->getToken()->getUser());

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
            throw $this->createNotFoundException('');
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

            throw $this->createNotFoundException('No pudimos encontrar el recurso, vuelva atras');

            throw $this->createNotFoundException('No pudimos encontrar el recurso :/');
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

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../reserva','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

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
            throw $this->createNotFoundException('No pudimos encontrar la Reserva.');
        }

        //entidad auxiliar por deus
        $fechaDesdeAux = $entity->getHoraDesde();
        $fechaHastaAux = $entity->getHoraHasta();
        $fechaAux =  $entity->getFecha();
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //modificado para que grabe las fechas y horas con formato
            $fecha= $entity->getFecha();

            $entity->setdiosReserva($this->container->get('security.context')->getToken()->getUser());

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

            if (!($entity->getFecha()>=$fechaActual)) {
                throw new Exception("La fecha para reservar deberia ser mas grande que la fecha actual.");  
            }elseif (!($entity->getHoraDesde() != $entity->getHoraHasta())) {
                throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
            }elseif (!$this::conprobarAlerta($entity->getFecha())){
                throw new Exception("Hay una alerta activa para el dia que desea agregar una reserva.");
            }elseif (!($this->sePuede($entity))) {
                throw new Exception("Hay reservas para esa aula con esas fecha y hora");
            }
      
           

            $em->flush();
           
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
        //jori
        $idDocente= $reservaEliminada->getDocente();//->getId();
        $docente= $em->getRepository('CrestaAulasBundle:Docente')->find($idDocente);
        $nombreDocente=$docente->getNombre();
        $apellidoDocente=$docente->getApellido();
        if ($reservaEliminada->getActividad()==null){
            //cargo curso
            $idCurso = $reservaEliminada->getCurso();
            $curso = $em->getRepository('CrestaAulasBundle:Curso')->find($idCurso);
            $nombreCurso = $curso->getNombre();
            $nombreActividad = null;
        }else{
            //cargo actividad
            $idActividad = $reservaEliminada->getActividad();
            $actividad = $em->getRepository('CrestaAulasBundle:Actividad')->find($idActividad);
            $nombreActividad = $actividad->getNombre();
            $nombreCurso = null;
        }
        //end jori

        $idAula = $reservaEliminada->getAula();
        //busco el aula para tomar el nombre
        $em2 = $this->getDoctrine()->getEntityManager();                 

        $aula = $em2->getRepository('CrestaAulasBundle:Aula')->find($idAula);

        $aulaParaMovimiento = $aula->getNombre();

        $movimiento->setUsuario($movimientoPersona);
        $movimiento->setReservaAula($aulaParaMovimiento);
        //jori
        $movimiento->setApellidoDocente($apellidoDocente);
        $movimiento->setNombreDocente($nombreDocente);
        if (!($nombreCurso)==null){
            $movimiento->setTarea($nombreCurso . ' (Curso)');
        }
        else{
            $movimiento->setTarea($nombreActividad . ' (Actividad)');
        }
        //end jori

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
                throw $this->createNotFoundException('No pudimos encontrar la reserva.');
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
            if ($_SESSION['fecha1'] == $_SESSION['fecha2'])
                $nombrefiltro = 'Hoy';
            
        }
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        
        switch ($nombrefiltro){
            case 'Hoy':
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                        ->where('r.fecha = :fecha')
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
                ->orderBy('r.horaDesde', 'ASC')
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
                ->orderBy('d.apellido', 'ASC')
                ->orderBy('d.nombre', 'ASC')
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
                    ->orderBy('c.nombre', 'ASC')
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

