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
                        throw new Exception("La fecha para reservar deberia ser igual o psoterior a la fecha actual.");  
                    }elseif (!($entity->getHoraDesde() < $entity->getHoraHasta())) {
                        throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
                    }elseif (!$this::conprobarAlerta($entity->getFecha())){
                        throw new Exception("Hay una alerta activa para el dia que desea agregar una reserva.");
                    }elseif (!($this->sePuede($entity))) {
                        throw new Exception("Hay reservas para esa aula con esas fecha y hora");
                    } 
                    try{
                        if($this->freeWilly($entity)){
                            $motivo = true;
                        }else{
                            $motivo = false;
                        }    
                        $em->persist($entity);
                        $em->flush();              

                    }catch(Exception $e){}
                    return $this->render('CrestaAulasBundle:Reserva:showOne.html.twig', array('entity' => $entity,'motivo'=>$motivo));
                    
                }else{
                    if (($entity->getFecha() >= $entity->getrangoHasta())) {
                        throw new Exception("La fecha final de las reservas debe ser posterior a la fecha actual");  
                    }elseif (!($entity->getHoraDesde() < $entity->getHoraHasta())) {
                        throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
                    }
                    if ($entity->getRango() > 0) {
                    $fechaReservaActual = $entity->getFecha();
                    $reservasCargadas = array();   
                    $arrayReservasConcatenadas = array();
                    $index = 0;
                    while ($entity->getrangoHasta() >= $fechaReservaActual) {
                        if($entity->getRango() == 7){
                            $arrayReservasConcatenadas[$index] = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+7 day');
                            $index++;
                        }elseif ($entity->getRango() == 14) {
                            $arrayReservasConcatenadas[$index] = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+14 day');
                            $index++;
                        }elseif ($entity->getRango() == 1) {
                            $arrayReservasConcatenadas[$index] = $this->crearReservaOP($entity,$fechaReservaActual,$reservasCargadas,$index,$fechaActual); 
                            $fechaReservaActual->modify('+1 day');
                            $index++;
                        }
                    }  
                   
                    }
                    return $this->render('CrestaAulasBundle:Reserva:showArray.html.twig', array('array' => $arrayReservasConcatenadas));
                } 
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
        $asd = $entityAux->getFecha()->format("d-m-Y");
        /*if ((date("D",$asd)) <> 'Sun' ){
            //No es domingo
            $cancelaDomingo = true;
        }else{
            $cancelaDomingo = false;
        }*/
        $reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> '','fechaReserva'=>$asd  ,'pizaCarrera'=> '');
        if($this->freeWilly($entityAux) and ($record)){
            $reservasCargadas[$index]['pizaCarrera'] = 'N/A';
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> '','fechaReserva'=> $asd ,'pizaCarrera'=> 'N/A');
        }else{
            $reservasCargadas[$index]['pizaCarrera'] = 'Existen reservas para esa misma carrera y año';
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> '','fechaReserva'=> $asd ,'pizaCarrera'=> 'Existen reservas para esa misma carrera y año');
        }
        if (!$this::conprobarAlerta($entityAux->getFecha()) and ($record)){
            $cancelarAlerta = true;
            $reservasCargadas[$index]['motivo'] = 'Hay un feriado en esta fecha'; 
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Hay un feriado en esta fecha','fechaReserva'=>$asd ,'pizaCarrera'=>'');
            $record = false;
        }else{
            $cancelarAlerta = false;
            $reservasCargadas[$index]['motivo'] = 'Se agrego correctamente'; 
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Se agrego correctamente','fechaReserva'=>$asd ,'pizaCarrera'=>'N/A' );
        }
        if($this->sePuede($entityAux) and ($record)){
            $canceloPiso = false;
            $reservasCargadas[$index]['motivo'] = 'Se agrego correctamente';
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> ,'fechaReserva'=> $asd ,'pizaCarrera'=> '');
        }else{ 
            $canceloPiso = true;
            $reservasCargadas[$index]['motivo'] = 'Ya hay una reserva para esa hora en ese dia.';
            //$reservasCargadas[ $index ] = array('entidad'=>$entityAux,'motivo'=> 'Ya hay una reserva para esa hora en ese dia.','fechaReserva'=> $asd ,'pizaCarrera'=> '');
            $record = false;
        }
        
        
        if  ((!$canceloPiso) and (!$cancelarAlerta) ){
            $em->merge($entityAux);
            $em->flush();
            $em->clear();
        }

        return $reservasCargadas;    

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
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        //trae la lista de reservas dentro del rango q el user quiere cargar.
        $query = $reserva->createQueryBuilder('r')
                ->where('
                (r.fecha= :fecha) AND
                ((r.horaDesde >= :horaDesde AND r.horaDesde < :horaHasta ) OR
                (r.horaHasta > :horaDesde AND r.horaHasta <= :horaHasta ) OR
                (r.horaDesde <= :horaDesde AND r.horaHasta >= :horaHasta ) OR
                (r.horaDesde >= :horaDesde AND r.horaHasta <= :horaHasta ) )
                ')
                ->setParameter('fecha', $fecha)
                ->setParameter('horaDesde', $horaDesde)
                ->setParameter('horaHasta', $horaHasta)
                ->getQuery();

        $listado = $query->getResult();
        
      
        //verifica que no etngo choque de otros cursos del mismo año y la misma carrera
        if ($entity->getCurso() != null){

            for ($i=0; $i <= count($listado) - 1; $i++) {
                 if ($listado[$i]->getCurso() != null){ 
                    if(($listado[$i]->getCurso()->getCarrera() == $entity->getCurso()->getCarrera()) and ($listado[$i]->getCurso()->getAnio() == $entity->getCurso()->getAnio())){
                        return false;
                    }else{
                        return true;    
                    }
                }
            }
        }else{
            return true; 
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
        $em = $this->getDoctrine()->getManager();  
        return $this->render('CrestaAulasBundle:Reserva:new.html.twig', array(
                
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reserva entity.
     *
     */
    public function showOneAction($array){
    
        if (!$entity) {
            throw $this->createNotFoundException('');
        }

        return $this->render('CrestaAulasBundle:Reserva:showOne.html.twig', array(
            'array'  => $array));
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
                throw new Exception("La fecha para reservar deberia ser igual o psoterior a la fecha actual.");  
            }elseif (!($entity->getHoraDesde() != $entity->getHoraHasta())) {
                throw new Exception("La hora de comienzo coincide con la hora final de la reserva :(");
            }elseif (!$this::conprobarAlerta($entity->getFecha())){
                throw new Exception("Hay una feriado activo para el dia que desea agregar una reserva.");
            }elseif (!($this->sePuedeEdit($entity))) {
                throw new Exception("Hay reservas para esa aula con esas fecha y hora");
            }elseif ($entity->getHoraDesde() > $entity->getHoraHasta()) {
                throw new Exception("La hora desde es posterior a la hora hasta.");
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

        //return $this->redirect($this->generateUrl('reserva'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
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
        $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
        
        switch ($nombrefiltro){
            case 'Hoy':
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                        ->where('r.fecha = :fecha')
                        ->setParameter('fecha', date('Y-m-d'))
                        ->getQuery();
                $entities = $query->getResult(); 

                $datosFiltro = 'Asignación de Aulas ( ' . date('d/m/Y') . ' )';
                break;
            
            case 'DiaSiguiente':
                $fechaHoy= date_create(date('d-m-Y'));
                $fechaManiana = $fechaHoy->modify('+1 day');
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                        ->where('r.fecha = :fecha')
                        ->setParameter('fecha', $fechaManiana)
                        ->getQuery();
                $entities = $query->getResult();

                $fechaManiana= $fechaManiana->format('d-m-Y');
                $datosFiltro = 'Asignación de Aulas ( ' . $fechaManiana . ' )';
                break;

            case 'Todos':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();
                $datosFiltro = 'TODAS las reservas del sistema';
                break;

            case 'Docente':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($filtro);
                $datosFiltro = null; 
                break;

            case 'Fecha':
                if ((!isset($_SESSION['fecha1'])) AND (isset($_POST['fecha1'])) ){
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    
                }
                else if ((!isset($_SESSION['fecha1'])) AND (!isset($_POST['fecha1']))){
                    $_POST['fecha1'] = date('now');
                    $_POST['fecha2'] = date('now');
                }
                
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2' )
                ->setParameter('fecha1', $_SESSION['fecha1'])
                ->setParameter('fecha2', $_SESSION['fecha2'])
                ->orderBy('r.fecha', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                $fecha1 = new \DateTime($_SESSION['fecha1']);
                $fecha1 = $fecha1 -> format('d/m/Y');

                $fecha2 = new \DateTime($_SESSION['fecha2']);
                $fecha2 = $fecha2 -> format('d/m/Y');

                $datosFiltro = 'Reservas del ' . $fecha1 . ' al ' . $fecha2;
                break;

            case 'Aula':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByAula($filtro);
                $datosFiltro = null;
                break;

            case 'Curso':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($filtro);
                $datosFiltro = null;
                break;

            case 'Actividad':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($filtro);
                $datosFiltro = null;
                break;

            case 'TodasActividades':
                $actividad = $em->getRepository('CrestaAulasBundle:Actividad')->findAll();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($actividad);
                $datosFiltro = 'TODAS las Actividades';
                break;

            case 'TodasMaterias':
                $materia = $em->getRepository('CrestaAulasBundle:Curso')->findAll();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($materia);
                $datosFiltro = 'TODAS las reservas de Materias';
                break;

            case 'fechaMateria':
                if ((!isset($_SESSION['fecha1'])) AND (isset($_POST['fecha1'])) ){
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    
                }
                else if ((!isset($_SESSION['fecha1'])) AND (!isset($_POST['fecha1']))){
                    $_POST['fecha1'] = date('now');
                    $_POST['fecha2'] = date('now');
                }

                $reservas = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reservas->createQueryBuilder('r')
                    ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2 and r.curso IS NOT NULL')
                    ->setParameter('fecha1', $_SESSION['fecha1'])
                    ->setParameter('fecha2', $_SESSION['fecha2'])
                    ->orderBy('r.fecha', 'ASC')
                    ->orderBy('r.horaDesde', 'ASC')
                    ->getQuery();
                $entities = $query->getResult();
                $datosFiltro = 'TODAS las reservas de materias entre ' . $_SESSION['fecha1'] . ' al ' . $_SESSION['fecha2'];
                break;
            
            case 'fechaActividad':
                if ((!isset($_SESSION['fecha1'])) AND (isset($_POST['fecha1'])) ){
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    
                }
                else if ((!isset($_SESSION['fecha1'])) AND (!isset($_POST['fecha1']))){
                    $_POST['fecha1'] = date('now');
                    $_POST['fecha2'] = date('now');
                }

                $reservas = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reservas->createQueryBuilder('r')
                    ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2 and r.actividad IS NOT NULL')
                    ->setParameter('fecha1', $_SESSION['fecha1'])
                    ->setParameter('fecha2', $_SESSION['fecha2'])
                    ->orderBy('r.fecha', 'ASC')
                    ->orderBy('r.horaDesde', 'ASC')
                    ->getQuery();
                $entities = $query->getResult();
                $datosFiltro = 'TODAS las reservas de actividades entre ' . $_SESSION['fecha1'] . ' al ' . $_SESSION['fecha2'];
                break;
        }

        $formato=$this->get('request')->get('_format');
        return $this->render(sprintf('CrestaAulasBundle:Reserva:imprimirlistado.pdf.twig', $formato ),  
        array( 'entities'=>$entities, 'filtro' => $nombrefiltro, 'datosFiltro' => $datosFiltro) );   //'nombre'=>$nombre) );
    }


    public function filtroAction(){
        $filtro=$this->get('request')->get('filtro');
        $em = $this->getDoctrine()->getManager();
        switch ($filtro) {

            case 'Todos':
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();
                $_SESSION['nombrefiltro']='Todos';//Para imprimir
                break;

            case 'DiaSiguiente':
                $fechaHoy= date_create(date('Y-m-d'));
                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                        ->where('r.fecha = :fecha')
                        ->setParameter('fecha', $fechaHoy->modify('+1 day'))
                        ->getQuery();
                $entities = $query->getResult();
                $_SESSION['nombrefiltro']='DiaSiguiente';
                break;


            case 'Fecha':
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    

                $reserva = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2' )
                ->setParameter('fecha1', $_SESSION['fecha1'])
                ->setParameter('fecha2', $_SESSION['fecha2'])
                //
                //->addOrderBy('r.fecha', 'ASC')
                //->addOrderBy('r.horaDesde', 'ASC')
                ->add('orderBy', 'r.fecha ASC','r.horaDesde ASC' )
                //->orderBy('r.fecha', 'ASC', 'r.horaDesde', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                $_SESSION['nombrefiltro']='Fecha';
                if (($_SESSION['fecha1'] == date('now')) AND  ($_SESSION['fecha2'] == date('now'))) $_SESSION['nombrefiltro']='Hoy';
                break;

            case 'Docente':
                /*$docente = $em->getRepository('CrestaAulasBundle:Docente')->findByApellido($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($docente);
                */
                if ((isset($_POST['dato'])) ){
                    $_SESSION['dato']=$_POST['dato'];
                }

                $docente = $em->getRepository('CrestaAulasBundle:Docente');
                $query = $docente->createQueryBuilder('d')
                ->where('d.nombre LIKE :dato or d.apellido LIKE :dato' )
                ->setParameter('dato', '%'.$_SESSION['dato'].'%')
                //agrego esto para ver si anda
                ->addOrderBy('d.apellido', 'ASC')
                ->addOrderBy('d.nombre', 'ASC')
                //
                //->orderBy('d.apellido', 'ASC', 'd.nombre', 'ASC')
                ->getQuery();
                $docente = $query->getResult();
                $_SESSION['filtro']=$docente;//Para imprimir
                $_SESSION['nombrefiltro']='Docente';//Para imprimir
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByDocente($docente);
                break;

            case 'Aula':
                if ((isset($_POST['dato'])) ){
                    $_SESSION['dato']=$_POST['dato'];
                }

                $aula = $em->getRepository('CrestaAulasBundle:Aula')->findByNombre($_SESSION['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByAula($aula);
                $_SESSION['filtro']=$aula;//Para imprimir
                $_SESSION['nombrefiltro']='Aula';//Para imprimir
                break;

            case 'TodasActividades':
                $actividad = $em->getRepository('CrestaAulasBundle:Actividad')->findAll();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($actividad);
                $_SESSION['filtro']=$actividad;//Para imprimir
                $_SESSION['nombrefiltro']='TodasActividades';//Para imprimir
                break;

            case 'TodasMaterias':
                $materia = $em->getRepository('CrestaAulasBundle:Curso')->findAll();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($materia);
                $_SESSION['filtro']=$materia;//Para imprimir
                $_SESSION['nombrefiltro']='TodasMaterias';//Para imprimir
                break;

            case 'fechaMateria':
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    

                $reservas = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reservas->createQueryBuilder('r')
                    ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2 and r.curso IS NOT NULL')
                    ->setParameter('fecha1', $_SESSION['fecha1'])
                    ->setParameter('fecha2', $_SESSION['fecha2'])
                    ->orderBy('r.fecha', 'ASC')
                    ->orderBy('r.horaDesde', 'ASC')
                    ->getQuery();
                $entities = $query->getResult();
                $_SESSION['nombrefiltro']='fechaMateria';
                break;
            
            case 'fechaActividad':
                if ((!isset($_SESSION['fecha1'])) AND (isset($_POST['fecha1'])) ){
                    $_SESSION['fecha1']=$_POST['fecha1'];//Para imprimir
                    $_SESSION['fecha2']=$_POST['fecha2'];//Para imprimir                    
                }
                else if ((!isset($_SESSION['fecha1'])) AND (!isset($_POST['fecha1']))){
                    $_POST['fecha1'] = date('now');
                    $_POST['fecha2'] = date('now');
                }

                $reservas = $em->getRepository('CrestaAulasBundle:Reserva');
                $query = $reservas->createQueryBuilder('r')
                    ->where('r.fecha >= :fecha1 and r.fecha <= :fecha2 and r.actividad IS NOT NULL')
                    ->setParameter('fecha1', $_SESSION['fecha1'])
                    ->setParameter('fecha2', $_SESSION['fecha2'])
                    ->orderBy('r.fecha', 'ASC')
                    ->orderBy('r.horaDesde', 'ASC')
                    ->getQuery();
                $entities = $query->getResult();
                
                $_SESSION['nombrefiltro']='fechaActividad';
                break;
            

            case 'Tarea':
                /*$tarea= $em->getRepository('CrestaAulasBundle:Curso')->findByNombre($_POST['dato']);
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($tarea);
                if (!$tarea){
                    $tarea= $em->getRepository('CrestaAulasBundle:Actividad')->findByNombre($_POST['dato']);
                    $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByActividad($tarea);
                }
                */

                if ((isset($_POST['dato'])) ){
                    $_SESSION['dato']=$_POST['dato'];
                }

                $curso = $em->getRepository('CrestaAulasBundle:Curso');
                $query = $curso->createQueryBuilder('c')
                ->where('c.nombre LIKE :dato' )
                ->setParameter('dato', '%'.$_SESSION['dato'].'%')
                ->getQuery();
                $curso = $query->getResult();
                $entities = $em->getRepository('CrestaAulasBundle:Reserva')->findByCurso($curso);
                $_SESSION['filtro']=$curso;
                $_SESSION['nombrefiltro']='Curso';
                if (!$entities){
                    $actividad = $em->getRepository('CrestaAulasBundle:Actividad');
                    $query = $actividad->createQueryBuilder('a')
                    ->where('a.nombre LIKE :dato' )
                    ->setParameter('dato', '%'.$_SESSION['dato'].'%')
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
