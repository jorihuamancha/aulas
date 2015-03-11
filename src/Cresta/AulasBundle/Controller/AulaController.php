<?php
namespace Cresta\AulasBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cresta\AulasBundle\Entity\Aula;
use Cresta\AulasBundle\Form\AulaType;
use Exception;

/**
 * Aula controller.
 *
 */
class AulaController extends Controller
{
    /**
     * Lists all Aula entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $filtroActivo=0;
        $entities = $em->getRepository('CrestaAulasBundle:Aula')->findAll();
        if (!$entities){
            $entities=null;
        }
        else {
            $_SESSION['entities']=$entities;
        }
        return $this->render('CrestaAulasBundle:Aula:index.html.twig', array(
            'entities' => $entities,
            'filtroActivo' => $filtroActivo,
        ));
    }
    /**
     * Creates a new Aula entity.
     *
     */
    public function createAction(Request $request)
    {
       
        $entity = new Aula();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($this::existeAula($entity)){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('aulas_aula_show', array('id' => $entity->getId())));
            }
            return $this->render('CrestaAulasBundle:Aula:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                ));
        }else{
           throw new Exception("Ya existe un Aula con ese nombre modifique e intente nuevamente"); 
        }

        
    }
    /**
     * Creates a form to create a Aula entity.
     *
     * @param Aula $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Aula $entity)
    {
        $form = $this->createForm(new AulaType(), $entity, array(
            'action' => $this->generateUrl('aulas_aula_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Crear','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../aula','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));
        return $form;
    }
    /**
     * Displays a form to create a new Aula entity.
     *
     */
    public function newAction()
    {
        $entity = new Aula();
        $form   = $this->createCreateForm($entity);
        return $this->render('CrestaAulasBundle:Aula:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Finds and displays a Aula entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrestaAulasBundle:Aula')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aula entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('CrestaAulasBundle:Aula:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing Aula entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrestaAulasBundle:Aula')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad Aula.');
        }
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('CrestaAulasBundle:Aula:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
    * Creates a form to edit a Aula entity.
    *
    * @param Aula $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Aula $entity)
    {
        $form = $this->createForm(new AulaType(), $entity, array(
            'action' => $this->generateUrl('aulas_aula_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver a la lista','attr'=>array('formaction'=>'../../aula','formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));
        return $form;
    }
    /**
     * Edits an existing Aula entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrestaAulasBundle:Aula')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No pudimos encontrar el aula :/ intenta cargar nuevamente la pagina');
        }

       
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            //return $this->redirect($this->generateUrl('aulas_aula_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('aulas_aula_show', array('id' => $entity->getId())));
        }
        return $this->render('CrestaAulasBundle:Aula:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        
    }
    /**
     * Deletes a Aula entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrestaAulasBundle:Aula')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('No pudimos encontrar el aula :/ intenta cargar nuevamente la pagina');
            }elseif ($this::estaEnUso($entity)) {
                throw new Exception("El aula esta ocupada con una reserva, elimine la reserva y luego podrá borrar el aula."); 
            }
            $em->remove($entity);
            $em->flush();
        //}
        return $this->redirect($this->generateUrl('aulas_aula'));
    }
    /**
     * Creates a form to delete a Aula entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {   
       
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aulas_aula_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
      public function disponibilidadAction(){  
        /* $w = 01;
        $x = 11;
        $z = 2015;
        $dfg = new \DateTime('2000-01-01');
        $dfg->setDate($z,$x,$w);
        var_dump($dfg);
        $dfg = getdate();
        print_r($dfg);
        die();*/ 
        if (isset($_REQUEST['asd'])) {
            header('Location:disponibilidad?mes=Marzo&dia=11');
        }  
        //Aca empieza lo generico
        $horarios = array(1=>'08:00 a 08:30',2=>'08:30 a 09:00',3=>'09:00 a 09:30',4=>'09:30 a 10:00',5=>'10:00 a 10:30',
        6=>'10:30 a 11:00',7=>'11:00 a 11:30 ',8=>'11:30 a 12:00',9=>'12:00 a 12:30',10=>'12:30 a 13:00',11=>'13:00 a 13:30',
        12=>'13:30 a 14:00',13=>'14:00 a 14:30',14=>'14:30 a 15:00',15=>'15:00 a 15:30',16=>'15:30 a 16:00',17=>'16:00 a 16:30',
        18=>'16:30 a 17:00',19=>'17:00 a 17:30',20=>'17:30 a 18:00',21=>'18:00 a 18:30',22=>'18:30 a 19:00',23=>'19:00 a 19:30',
        24=>'19:30 a 20:00',25=>'20:00 a 20:30',26=>'20:30 a 21:00',27=>'21:00 a 21:30',28=>'21:30 a 22:00',29=>'22:00 a 22:30',30=>'22:30 a 23:00');
        //Arreglar
        $arrayDeTranformacion  = array('08:00 a 08:30'=>1,'08:30 a 09:00'=>2,'09:00 a 09:30'=>3,'09:30 a 10:00'=>4,'10:00 a 10:30'=>5,
        '10:30 a 11:00'=>6,'11:00 a 11:30'=>7,'11:30 a 12:00'=>8,'12:00 a 12:30'=>9,'12:30 a 13:00'=>10,'13:00 a 13:30'=>11,
        '13:30 a 14:00'=>12,'14:00 a 14:30'=>13,'14:30 a 15:00'=>14,'15:00 a 15:30'=>15,'15:30 a 16:00'=>16,'16:00 a 16:30'=>17,
        '16:30 a 17:00'=>18,'17:00 a 17:30'=>19,'17:30 a 18:00'=>20,'18:00 a 18:30'=>21,'18:30 a 19:00'=>22,'19:00 a 19:30'=>23,'19:30 a 20:00'=>24,
        '20:00 a 20:30'=>25,'20:30 a 21:00'=>26,'21:00 a 21:30'=>27,'21:30 a 22:00'=>28,'22:00 a 22:30'=>29,'22:30 a 23:00'=>30); 
        $elmesEnNumero= array('Enero'=>1,'Febrero'=>2,'Marzo'=>3,'Abril'=>4,'Mayo'=>5,'Junio'=>6,'Julio'=>7,
        'Agosto'=>8,'Septiembre'=>9,'Octubre'=>10,'Noviembre'=>11,'Diciembre'=>12);
        $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',
        8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
        $AnioActual = date('Y');
            $dias = 1;
            $MesesDe30 =  array();
            $MeseDe31 =  array();
            $Febrero = array();
            while ($dias < 32){
                $MeseDe31[$dias] = $dias;
                $dias = $dias + 1;
            }
            $dias = 1;
            while ($dias < 31){
                $MesesDe30[$dias] = $dias;
                $dias = $dias + 1;
            }
            $dias = 1;
            if (($AnioActual % 4 == 0) && ($AnioActual % 100 != 0) || ($AnioActual % 400 == 0)){
                 //es bisiesto   
                while ($dias < 30){
                    $Febrero[$dias] = $dias;
                     $dias = $dias + 1;
                }
            }
            else{
                while ($dias < 29){
                    $Febrero[$dias] = $dias;
                    $dias = $dias + 1;
                }
            }
        $unArray = array('Enero' => $MeseDe31,'Febrero' => $Febrero,'Marzo' => $MeseDe31,'Abril' => $MesesDe30,
        'Mayo' => $MeseDe31,'Junio' => $MesesDe30,'Julio' => $MeseDe31,'Agosto' => $MeseDe31,'Septiembre' => $MesesDe30,
        'Octubre' => $MeseDe31,'Noviembre' => $MesesDe30,'Diciembre' => $MeseDe31);
        $em = $this->getDoctrine()->getManager();
        $mesActual = date('m');
        $diaActual =date('d');
        //Aca termina lo generico
        if ((empty($_GET["mes"])) and (empty($_GET["dia"]))){
            $query1 = $em->createQuery('SELECT a FROM CrestaAulasBundle:Aula a  ORDER BY a.nombre ASC');
            $aulasMostrar =  $query1->getResult();
            $pasar = date('Y-m-d');
            $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:Reserva r WHERE r.fecha = :fechitaMostri')->setParameter('fechitaMostri', $pasar);
            $reservasMostrar = $query->getResult();
            $contador =0;
             foreach ($reservasMostrar as $aux) {
                $reservasMostrar[$contador]->getHoraDesde();
                //Busco los minutos para saber si es 30 o 00
                $minutoComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('i');
                $horaComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('H');
                $minutoComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('i');
                $horaComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('H');
                //Traigo la hora desde de las reservas.
                $hh = $reservasMostrar[$contador]->getHoraHasta()->format('H:i');
                $hd = $reservasMostrar[$contador]->getHoraDesde()->format('H:i');
                //si el min es 30 deberia concatenar con la hora siguente.
                if ( ($minutoComparableDesde == 30) and ($minutoComparableHasta == 00) ){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    //Busco el aula de la reserva (nombre)
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 30) and ($minutoComparableHasta == 30)){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 30)) {
                     //a la hora le sumo uno para llegar al valor.
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);     
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 00)){
                    //a la hora le sumo uno para llegar al valor.
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);    
                }
                else{
                    throw $this->createNotFoundException('Lo sentimos se rompieron las reservas :/ los horarios deberian ser en minutos 00 o 30.');
                }
                $ArrayContenedor[$contador] = array(1=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[1]],
                2=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[2]],3=>$arrayCargadoConHorariosConcat[3],4=>$reservasMostrar[$contador]);
                $contador = $contador + 1;
            }
            if ((count($reservasMostrar)) == 0){
                $ArrayContenedor = null;
            }
            $mesSelect = array();
            $buscameEsto='Mes';
            
            //Arreglo de last moment, con los meses del 1 al 9, como lo tomamos de la fecha actual
            //lo toma como 01 al 09, y se rompe!!!

            
            $mesActual=intval($mesActual);
            $buscameEstoAhora = $meses[$mesActual];

            return $this->render('CrestaAulasBundle:Aula:disponibilidad.html.twig',array('mesSelect'=>$mesSelect,
            'seleccionadoMes'=>$buscameEsto,'meses'=>$meses,'horarios'=>$horarios,'aulasMostrar'=>$aulasMostrar,'mesActual'=>$mesActual
            ,'diaActual'=>$diaActual,'seleccionadoMesAhora'=>$buscameEstoAhora,'ArrayContenedor'=>$ArrayContenedor,'seleccionadoDia' => 'Dia'));
        }
        elseif (((($_GET["mes"] == 'Mes')) or (!isset($_GET["dia"]))) and (isset ($_GET["aula"]))){
             throw new Exception('Para filtrar el aula, primero completa el campo mes y dia para que podamos encontrar lo que estas buscando.');
        }
        elseif ((!empty($_GET["mes"])) and (!empty($_GET["dia"])) and (!empty($_GET["aula"]))) {
            $seleccionadoDia = $_GET["dia"];
            $buscameEsto= $_GET["mes"];
            $asd = $elmesEnNumero[$buscameEsto];
            //tengo la id buscate el aula pedru
            $idDelAulaSeleccionada = $_GET["aula"];
            
            $aulasMostrar[0] = $em->getRepository('CrestaAulasBundle:Aula')->find($idDelAulaSeleccionada); 
            /* dios es cuate
            // $seleccionadoAula = $aulasMostrar->getNombre();
            echo "<PRE>";
            print_r($aulasMostrar);
            echo "</PRE>";*/
            $mesSelect = $unArray[$buscameEsto];
            //$aulasMostrar[]['nombre'] = $seleccionadoAula;
            $mesActual=intval($mesActual);
            $buscameEstoAhora = $meses[$mesActual];
            $pasar = $AnioActual . '-' . $asd . '-' . $seleccionadoDia;
            $parameters = array('fechitaMostri' => $pasar,'elaula' =>  $idDelAulaSeleccionada);
            $query = $em->createQuery(' SELECT r FROM CrestaAulasBundle:Reserva r 
                                        WHERE r.fecha = :fechitaMostri and r.aula = :elaula')->setParameters($parameters);
            $reservasMostrar = $query->getResult();
            $contador =0;
             foreach ($reservasMostrar as $aux) {
                $reservasMostrar[$contador]->getHoraDesde();
                //Busco los minutos para saber si es 30 o 00
                $minutoComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('i');
                $horaComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('H');
                $minutoComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('i');
                $horaComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('H');
                //Traigo la hora desde de las reservas.
                $hh = $reservasMostrar[$contador]->getHoraHasta()->format('H:i');
                $hd = $reservasMostrar[$contador]->getHoraDesde()->format('H:i');
                //si el min es 30 deberia concatenar con la hora siguente.
                if ( ($minutoComparableDesde == 30) and ($minutoComparableHasta == 00) ){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    //Busco el aula de la reserva (nombre)
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 30) and ($minutoComparableHasta == 30)){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 30)) {
                     //a la hora le sumo uno para llegar al valor.
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);     
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 00)){
                    //a la hora le sumo uno para llegar al valor.
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);    
                }
                else{
                    throw $this->createNotFoundException('Lo sentimos se rompieron las reservas :/ los horarios deberian ser en minutos 00 o 30.');
                }
                $ArrayContenedor[$contador] = array(1=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[1]],
                2=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[2]],3=>$arrayCargadoConHorariosConcat[3],4=>$reservasMostrar[$contador]);
                $contador = $contador + 1;
            }
            if ((count($reservasMostrar)) == 0){
                $ArrayContenedor = null;
            }
              return $this->render('CrestaAulasBundle:Aula:disponibilidad.html.twig',array('mesSelect'=>$mesSelect,
            'seleccionadoMes'=>$buscameEsto,'mesActual'=>$mesActual,'meses'=>$meses,'horarios'=>$horarios,'aulasMostrar'=>$aulasMostrar,
            'diaActual'=>$diaActual,'asd'=>$asd,'seleccionadoMesAhora'=>$buscameEstoAhora,
            'ArrayContenedor'=>$ArrayContenedor,'seleccionadoDia' =>$seleccionadoDia));
        }
        else{
            $query1 = $em->createQuery('SELECT a FROM CrestaAulasBundle:Aula a  ORDER BY a.nombre ASC');
            $aulasMostrar =  $query1->getResult();
            $seleccionadoDia = $_GET["dia"];
            $buscameEsto= $_GET["mes"];
            $asd= $elmesEnNumero[$buscameEsto];
            $pasar = $AnioActual . '-' . $asd . '-' . $seleccionadoDia;
            $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:Reserva r WHERE r.fecha = :fechitaMostri')->setParameter('fechitaMostri', $pasar);
            $reservasMostrar = $query->getResult();
            $contador = 0;
         
            foreach ($reservasMostrar as $aux) {
                $reservasMostrar[$contador]->getHoraDesde();
                //Busco los minutos para saber si es 30 o 00
                $minutoComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('i');
                $horaComparableDesde = $reservasMostrar[$contador]->getHoraDesde()->format('H');
                $minutoComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('i');
                $horaComparableHasta = $reservasMostrar[$contador]->getHoraHasta()->format('H');
                //Traigo la hora desde de las reservas.
                $hh = $reservasMostrar[$contador]->getHoraHasta()->format('H:i');
                $hd = $reservasMostrar[$contador]->getHoraDesde()->format('H:i');
                //si el min es 30 deberia concatenar con la hora siguente.
                if ( ($minutoComparableDesde == 30) and ($minutoComparableHasta == 00) ){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    //Busco el aula de la reserva (nombre)
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 30) and ($minutoComparableHasta == 30)){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparableDesde = $horaComparableDesde + 1;
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':00';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre); 
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 30)) {
                     //a la hora le sumo uno para llegar al valor.
                    $horaComparableHasta = $horaComparableHasta + 1;
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':00';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);     
                }
                elseif (($minutoComparableDesde == 00) and ($minutoComparableHasta == 00)){
                    //a la hora le sumo uno para llegar al valor.
                    //Esto pro si la hora es 08 por ejemplo increible, pero real
                    if (strlen($horaComparableDesde) == 1){
                        $horaComparableDesde ='0' . $horaComparableDesde ; 
                    } 
                    if (strlen($horaComparableHasta) == 1){
                        $horaComparableHasta ='0' . $horaComparableHasta ; 
                    } 
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparableDesde . ':30';
                    $hh = $hh . ' a ' . $horaComparableHasta . ':30';
                    $idBuscar = $reservasMostrar[$contador]->getAula();
                    $aulaVar = $em->getRepository('CrestaAulasBundle:Aula')->find($idBuscar);
                    $aulaNombre = $aulaVar->getNombre();
                    $arrayCargadoConHorariosConcat = array (1=>$hd,2=>$hh,3=>$aulaNombre);    
                }
                else{
                    throw $this->createNotFoundException('Lo sentimos se rompieron las reservas :/ los horarios deberian ser en minutos 00 o 30.');
                }
                $ArrayContenedor[$contador] = array(1=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[1]],
                2=>$arrayDeTranformacion[$arrayCargadoConHorariosConcat[2]],3=>$arrayCargadoConHorariosConcat[3],4=>$reservasMostrar[$contador]);
                $contador = $contador + 1;
            }
            if ((count($reservasMostrar)) == 0){
                $ArrayContenedor = null;
            }
           
            
            $diaActual =date('d'); 
            $mesSelect = $unArray[$buscameEsto];
            $asd= $elmesEnNumero[$buscameEsto];
            $buscameEstoAhora = $buscameEsto; 
            $mesActual = date('m');
            return $this->render('CrestaAulasBundle:Aula:disponibilidad.html.twig',array('mesSelect'=>$mesSelect,
            'seleccionadoMes'=>$buscameEsto,'mesActual'=>$mesActual,'meses'=>$meses,'horarios'=>$horarios,'aulasMostrar'=>$aulasMostrar,
            'diaActual'=>$diaActual,'asd'=>$asd,'seleccionadoMesAhora'=>$buscameEstoAhora,
            'ArrayContenedor'=>$ArrayContenedor,'seleccionadoDia' =>$seleccionadoDia));
            //Por el neg de la gente
        }
     }

     private function existeAula ($entity){
        $em = $this->getDoctrine()->getManager();
        $pasar = $entity->getNombre();

        $query = $em->createQuery('SELECT a FROM CrestaAulasBundle:aula a WHERE a.nombre = :nombre')->setParameter('nombre', $pasar);
        $aula = $query->getResult();
        
        if (empty($aula)) {
            $compara = null;
        }else{
            $compara = $aula[0]->getNombre();
        }
        
        if (strtolower($compara) != strtolower($entity->getNombre())){
            return true;
        }else{
            return false;
        }
     }

    private function estaEnUso($entity){ 
        $em = $this->getDoctrine()->getManager();
        $aula = $entity->getId();
        $query = $em->createQuery('SELECT r FROM CrestaAulasBundle:Reserva r WHERE r.aula = :aula')->setParameter('aula', $aula);
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
                $entities = $em->getRepository('CrestaAulasBundle:Aula')->findAll();
                break;


            case 'nombre':
   
                $reserva = $em->getRepository('CrestaAulasBundle:Aula');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.nombre = :nombre')
                ->setParameter('nombre', $_POST['dato'])
                ->orderBy('r.nombre', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;

            case 'piso':
                $reserva = $em->getRepository('CrestaAulasBundle:Aula');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.piso = :piso')
                ->setParameter('piso', $_POST['dato'])
                ->orderBy('r.piso', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;

             case 'capacidad':
                $reserva = $em->getRepository('CrestaAulasBundle:Aula');
                $query = $reserva->createQueryBuilder('r')
                ->where('r.capacidad = :capacidad')
                ->setParameter('capacidad', $_POST['dato'])
                ->orderBy('r.capacidad', 'ASC')
                ->getQuery();
                $entities = $query->getResult();
                break;
            
        }
        if (!$entities){
            $entities=null;
        }

        $filtroActivo = 1;

        return $this->render('CrestaAulasBundle:Aula:index.html.twig', array('entities' => $entities,'filtroActivo' => $filtroActivo));

    }


}
