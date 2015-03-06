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
$count = 0; 
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
               
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha = :fecha')
                ->setParameter('fecha', date('Y-m-d'))
                ->orderBy('r.horaDesde', 'ASC')
                ->getQuery();
        $entities = $query->getResult();

        $_SESSION['nombrefiltro']='Hoy'; //Para imprimir
        $_SESSION['count']= 0;

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

        if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //Nombre del usuario creador de la reserva (No es relacion).
                $entity->setdiosReserva($this->container->get('security.context')->getToken()->getUser());
                //Fecha de la reserva (fecha desde).
                $fecha=$entity->getFecha();
                $fecha->setTime(00, 00, 00);
                $entity->setFecha($fecha);
                //Hora de incio de la reserva.
                $horaDesde=$entity->getHoraDesde();
                $horaDesde->setDate(2000, 01, 01);
                $entity->setHoraDesde($horaDesde);
                //Hora de fin de la reserva.
                $horaHasta=$entity->getHoraHasta();
                $horaHasta->setDate(2000, 01, 01);
                $entity->setHoraHasta($horaHasta);
                //Fecha actual.
                $fechaActual=new \DateTime('now');
                $fechaActual->setTime(00, 00, 00);
                //Rango final de las reservas.
                $rangoHasta = $entity->getrangoHasta();
                $rangoHasta->setTime(00, 00, 00);
                $entity->setrangoHasta($rangoHasta);
                //By Neg.-
                //No tocar por nada del mundo
                if ($entity->getRango() == 0){
                    if (!($entity->getFecha()>=$fechaActual)) {
                        throw new Exception("La fecha para reservar deberia ser mas grande que la fecha actual.");  
                    }elseif (!($entity->getHoraDesde() < $entity->getHoraHasta())) {
                        throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
                    }elseif (!$this::conprobarAlerta($entity->getFecha())){
                        throw new Exception("Hay una alerta activa para el dia que desea agregar una reserva.");
                    }elseif (!($this->sePuede($entity))) {
                        throw new Exception("Hay reservas para esa aula con esas fecha y hora");
                    } 
                }else{
                    if (($entity->getFecha() >= $entity->getrangoHasta())) {
                        throw new Exception("La fecha final de las reservas debe ser mayor a la fecha inicial");  
                    }
                }
                try{
                    if ($entity->getRango() == 0){
                        $em->persist($entity);
                        $em->flush();

                    }
                    //return $this->redirect($this->generateUrl('reserva_show', array('id' => $id)));
                }catch(Exception $e){}
                if ($entity->getRango() > 0) {
                    $fechaReservaActual = $entity->getFecha();
                    $reservasCargadas = array();
                    $index = 0;
                    while ($entity->getrangoHasta() >= $fechaReservaActual) {
                        if($entity->getRango() == 7){
                            $arrayReservasConcatenadas = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+7 day');
                            $index++;
                        }elseif ($entity->getRango() == 14) {
                            $arrayReservasConcatenadas = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+14 day');
                            $index++;
                        }elseif ($entity->getRango() == 1) {
                            $arrayReservasConcatenadas = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+1 day');
                            $index++;
                        }
                    }  
                   
                }
           //return $this->redirect($this->generateUrl('reserva_show_Array', array('reservasCargadas' => $reservasCargadas)));
           return $this->render('CrestaAulasBundle:Reserva:showArray.html.twig', array('array' => $arrayReservasConcatenadas));

                //aca va show de las reservas hechas y los avisos de las reservas q no se pudieron cargar.
           // return $this->redirect($this->generateUrl('reserva', array()));
            }
       return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array('entity' => $entity,'form'=> $form->createView()));
    }
    //By Neg.-
    private function crearReservaOP($entity, $fechaReservaActual, $reservasCargadas,$index,$fechaActual){
        $record = true;
        $entityAux = new Reserva();
        $em = $this->getDoctrine()->getManager();
        $entityAux = $entity;
        $entityAux->setFecha($fechaReservaActual);
        //$fechaComoDate = date(($datetime($entityAux->getFecha())));
        /*if ((date("D",$fechaComoDate)) <> 'Sun' ){
            //No es domingo
            $cancelarCarga = true;
        }else{
            $cancelarCarga = false;
        }*/
        if($this->sePuede($entityAux) and ($record)){
            $canceloPiso = false;
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Se agrego correctamente');
        }else{ 
            $canceloPiso = true;
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Ya hay una reserva para esa hora en ese dia.');
            $record = false;
        }
        if (!$this::conprobarAlerta($entityAux->getFecha()) and ($record)){
            $cancelarAlerta = true;
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Hay un feriado en esta fecha');
            $record = false;
        }else{
            $cancelarAlerta = false;
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Se agrego correctamente');
        }
        if($this->freeWilly($entityAux) and ($record)){
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Se agrego correctamente');
        }else{
            $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Existen reservas para este curso en el mismo rango.');
            $record = false;
        }
      
        if  ((!$canceloPiso) and (!$cancelarAlerta)){
            $em->merge($entityAux);
            $em->flush();
            $em->clear();
        }   
            

    }
    //By Neg.-
    private function conprobarAlerta ($fecha){
        $em = $this->getDoctrine()->getManager();
        $fecha = $fecha ;
        $query = $em->createQuery('SELECT a FROM CrestaAulasBundle:Alerta a WHERE a.fecha = :fecha')->setParameter('fecha',$fecha);
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
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');

        $query = $reserva->createQueryBuilder('r')
                        ->where('
                            (r.fecha= :fecha AND r.aula= :aula) AND
                            ((r.horaDesde >= :horaDesde AND r.horaDesde < :horaHasta ) OR
                            (r.horaHasta > :horaDesde AND r.horaHasta <= :horaHasta ) OR
                            (r.horaDesde <= :horaDesde AND r.horaHasta >= :horaHasta ) OR
                            (r.horaDesde >= :horaDesde AND r.horaHasta <= :horaHasta ) )
                            ')
                        
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
    //By Neg.-
    private function freeWilly($entity){
        $em = $this->getDoctrine()->getManager();
       
        $fecha=$entity->getFecha();
        $horaDesde=$entity->getHoraDesde();
        $horaHasta=$entity->getHoraHasta();
        $curso=$entity->getCurso();
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');

        $query = $reserva->createQueryBuilder('r')
                ->where('
                (r.fecha= :fecha AND r.curso= :curso ) AND
                ((r.horaDesde >= :horaDesde AND r.horaDesde < :horaHasta ) OR
                (r.horaHasta > :horaDesde AND r.horaHasta <= :horaHasta ) OR
                (r.horaDesde <= :horaDesde AND r.horaHasta >= :horaHasta ) OR
                (r.horaDesde >= :horaDesde AND r.horaHasta <= :horaHasta ) )
                ')
                ->setParameter('fecha', $fecha)
                ->setParameter('curso', $curso)
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
    //By Neg.-
    private function sePuedeEdit ($entity){

        $em = $this->getDoctrine()->getManager();
        
        $fecha=$entity->getFecha();
        $idAula=$entity->getAula();
        $horaDesde=$entity->getHoraDesde();
        $horaHasta=$entity->getHoraHasta();
        $id = $entity->getId();
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');

        $query = $reserva->createQueryBuilder('r')
                        ->where('(r.id <> :id) AND
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
    public function showArrayAction($array){
    
        if (!$entity) {
            throw $this->createNotFoundException('');
        }

        return $this->render('CrestaAulasBundle:Reserva:showArray.html.twig', array(
            'array'  => $array));
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
                throw new Exception("Hay una feriado activo para el dia que desea agregar una reserva.");
            }elseif (!($this->sePuedeEdit($entity))) {
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

