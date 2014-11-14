<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Aula;
use Cresta\AulasBundle\Form\AulaType;

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

        $entities = $em->getRepository('CrestaAulasBundle:Aula')->findAll();

        return $this->render('CrestaAulasBundle:Aula:index.html.twig', array(
            'entities' => $entities,
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
        $form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formaction'=>$_SERVER['HTTP_REFERER'],'formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));

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
            throw $this->createNotFoundException('Unable to find Aula entity.');
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

        $form->add('submit', 'submit', array('label' => 'Editar','attr'=>array('class'=>'btn btn-default botonTabla')));
        $form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formaction'=>$_SERVER['HTTP_REFERER'],'formnovalidate'=>'formnovalidate','class'=>'btn btn-default botonTabla')));


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
            throw $this->createNotFoundException('Unable to find Aula entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aulas_aula_edit', array('id' => $id)));
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
                throw $this->createNotFoundException('Unable to find Aula entity.');
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

     public function disponibilidadAction()
        {  
         if (empty($_GET["mes"])) {
            $em = $this->getDoctrine()->getManager();
            $aulasMostrar = $em->getRepository('CrestaAulasBundle:Aula')->findAll();
            $mesSelect = array();
            if (empty($_GET["aula"])){
                $aulaSeleccionada = 0;
            }
            else{
                $aulaSeleccionada = $_GET["aula"];
            }
            $diaActual =date('d');
            $buscameEsto='Mes';
            $mesActual = date('m');
            $elmesEnNumero= array('Enero'=>1,'Febrero'=>2,'Marzo'=>3,'Abril'=>4,'Mayo'=>5,'Junio'=>6,'Julio'=>7,
            'Agosto'=>8,'Septiembre'=>9,'Octubre'=>10,'Noviembre'=>11,'Diciembre'=>12);
            //$asd= $elmesEnNumero[$buscameEsto];
            $horarios = array(1=>'08:00 a 08:30',2=>'08:30 a 09:00',3=>'09:00 a 09:30',4=>'09:30 a 10:00',5=>'10:00 a 10:30',
            6=>'10:30 a 11:00',7=>'11:00 a 11:30 ',8=>'11:30 a 12:00',9=>'12:00 a 12:30',10=>'12:30 a 13:30',11=>'13:30 a 14:00',
            12=>'14:00 a 14:30',13=>'14:30 a 15:00',14=>'15:00 a 15:30',15=>'15:30 a 16:00',16=>'16:00 a 16:30',17=>'16:30 a 17:00',
            18=>'17:30 a 18:00',19=>'18:30 a 19:00',20=>'19:00 a 19:30',21=>'20:00 a 20:30',22=>'20:00 a 21:00',23=>'21:00 a 21:30',
            24=>'21:30 a 22:00');
            $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',
            8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');

            
            $buscameEstoAhora = $meses[$mesActual];
            return $this->render('CrestaAulasBundle:Aula:disponibilidad.html.twig',array('mesSelect'=>$mesSelect,
            'seleccionado'=>$buscameEsto,'meses'=>$meses,'horarios'=>$horarios,'aulasMostrar'=>$aulasMostrar,'mesActual'=>$mesActual
            ,'diaActual'=>$diaActual,'aulaSeleccionada'=>$aulaSeleccionada,'seleccionadoAhora'=>$buscameEstoAhora));

        }
        else{
            $em = $this->getDoctrine()->getManager();
            $aulasMostrar = $em->getRepository('CrestaAulasBundle:Aula')->findAll();

            $reservasMostrar = $em->getRepository('CrestaAulasBundle:Reserva')->findAll();
            $contador = 0;
            foreach ($reservasMostrar as $aux) {
                $reservasMostrar[$contador]->getHoraDesde();
                //Busco los minutos para saber si es 30 o 00
                $minutoComparable = $reservasMostrar[$contador]->getHoraDesde()->format('i');
                $horaComparable = $reservasMostrar[$contador]->getHoraDesde()->format('H');
                //Traigo la hora desde de las reservas.
                $hh = $reservasMostrar[$contador]->getHoraHasta()->format('H:i');
                $hd = $reservasMostrar[$contador]->getHoraDesde()->format('H:i');
                //si el min es 30 deberia concatenar con la hora siguente.
                if($minutoComparable == 30){
                    //a la hora le sumo uno para llegar al valor.
                    $horaComparable = $horaComparable + 1;
                    //concateno todo para tener el valor exacto estilo "12:30 a 13:00"
                    $hd = $hd . ' a ' . $horaComparable . ':00';
                    $arrayCargadoConHorariosConcat = array (1=>$hd);
                    echo ($arrayCargadoConHorariosConcat[1]);
                }
                else{
                    echo('NOPE');
                }
                $contador = $contador + 1;
            }
            //$q = $reservasMostrar[1]->getHoraDesde();
            //echo $pepe = $q->format('i');
            //if ($pepe == 30){
                
           // }else{
                
           // }


            //Pintar la matriz


            
            if (empty($_GET["aula"])){
                $aulaSeleccionada = 0;
            }
            else{
                $aulaSeleccionada = $_GET["aula"];
              
            }
            $buscameEsto= $_GET["mes"];
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
                    //NOPE
                     while ($dias < 29){
                        $Febrero[$dias] = $dias;
                        $dias = $dias + 1;
                     }
                }
            $mesActual = date('m');
            $diaActual =date('d'); 
            $horarios = array(1=>'08:00 a 08:30',2=>'08:30 a 09:00',3=>'09:00 a 09:30',4=>'09:30 a 10:00',5=>'10:00 a 10:30',
            6=>'10:30 a 11:00',7=>'11:00 a 11:30 ',8=>'11:30 a 12:00',9=>'12:00 a 12:30',10=>'12:30 a 13:30',11=>'13:30 a 14:00',
            12=>'14:00 a 14:30',13=>'14:30 a 15:00',14=>'15:00 a 15:30',15=>'15:30 a 16:00',16=>'16:00 a 16:30',17=>'16:30 a 17:00',
            18=>'17:30 a 18:00',19=>'18:30 a 19:00',20=>'19:00 a 19:30',21=>'20:00 a 20:30',22=>'20:00 a 21:00',23=>'21:00 a 21:30',
            24=>'21:30 a 22:00');
            $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',
            8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
            $unArray = array('Enero' => $MeseDe31,'Febrero' => $Febrero,'Marzo' => $MeseDe31,'Abril' => $MesesDe30,
            'Mayo' => $MeseDe31,'Junio' => $MesesDe30,'Julio' => $MeseDe31,'Agosto' => $MeseDe31,'Septiembre' => $MesesDe30,
            'Octubre' => $MeseDe31,'Noviembre' => $MesesDe30,'Diciembre' => $MeseDe31);
            //$mesSelect=1;
            $mesSelect = $unArray[$buscameEsto];
            

            $elmesEnNumero= array('Enero'=>1,'Febrero'=>2,'Marzo'=>3,'Abril'=>4,'Mayo'=>5,'Junio'=>6,'Julio'=>7,
            'Agosto'=>8,'Septiembre'=>9,'Octubre'=>10,'Noviembre'=>11,'Diciembre'=>12);
            $asd= $elmesEnNumero[$buscameEsto];

            $buscameEstoAhora = $buscameEsto; 
            return $this->render('CrestaAulasBundle:Aula:disponibilidad.html.twig',array('mesSelect'=>$mesSelect,
            'seleccionado'=>$buscameEsto,'mesActual'=>$mesActual,'meses'=>$meses,'horarios'=>$horarios,'aulasMostrar'=>$aulasMostrar,
            'diaActual'=>$diaActual,'asd'=>$asd,'aulaSeleccionada'=>$aulaSeleccionada,'seleccionadoAhora'=>$buscameEstoAhora));


            //Por el neg de la gente
        }
     }
}
