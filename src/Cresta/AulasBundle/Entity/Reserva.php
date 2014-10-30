<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Reserva
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=45)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="horaDesde", type="time")
     */
    private $horaDesde;

    /**
     * @var string
     *
     * @ORM\Column(name="horaHasta", type="time")
     */
    private $horaHasta;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaReserva", type="date")
     */
    private $fechaReserva;
    /* ---------------------------------------------- Reserva-Tarea-----------------------------------------------------------*/
    /**
     * @ORM\OneToOne(targetEntity="Tarea")
     */

    private $tareas;
      
    /* ---------------------------------------------- Reserva-Recursos----------------------------------------------------------*/
    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="Reserva")
     */

    private $recursos;

    /**
     * @ORM\OneToOne(targetEntity="Persona", inversedBy="Reserva")
    */

    private $reservaPersona;

    /* ---------------------------------------------- Persona-reserva-------------------------------------------------------*/
     /**
     * @ORM\OneToOne(targetEntity="Aula", inversedBy="Reserva")
     */

    private $reservaAula;
      




    /* ---------------------------------------------- Get Movimientos -------------------------------------------------------------------*/
    public function getMovimientos(){
        return $this->movimientos;
    }
          /*-------By neg---------*/
    /* ---------------------------------------------- Fin Get Movientos -----------------------------------------------------------------*/
    
    /* ---------------------------------------------- Set Movimientos -------------------------------------------------------------------*/
    public function addMovimientos(\src\Cresta\AulasBundle\Entity\Movimiento $movimientos){
        $this->movimientos [] =$movimientos;
    }
          /*-------By neg---------*/

    /* ---------------------------------------------- Fin Set Movimientos----------------------------------------------------------------*/

    /* ---------------------------------------------- Get Recursos ---------------------------------------------------------------------*/
    public function getRecursos(){
        return $this->recursos;
    }
          /*-------By neg---------*/
    /* ---------------------------------------------- Fin Get Recursos -----------------------------------------------------------------*/
    
    /* ---------------------------------------------- Set Recursos   -------------------------------------------------------------------*/
    public function addRecursos(\src\Cresta\AulasBundle\Entity\Recurso $recursos){
        $this->recursos [] =$recursos;
    }
          /*-------By neg---------*/

    /* ---------------------------------------------- Fin Set recursos------------------------------------------------------------------*/

    /* ---------------------------------------------- Get tarea -----------------------------------------------------------------*/
    public function getTareas() {
        return $this->tareas;
    }
        /*-------By neg---------*/
    /* ---------------------------------------------- fin Get tarea -------------------------------------------------------------*/
     /* ---------------------------------------------- set tarea ----------------------------------------------------------------*/
     public function setTareas (\src\Cresta\AulasBundle\Entity\Tarea $tareas){
         
         $this->tareas =$tareas;
     }
        /*-------By neg---------*/
    /* ---------------------------------------------- fin set tarea -------------------------------------------------------------*/


    /* ---------------------------------------------- Get aula ------------------------------------------------------------------*/
    public function getAula() {
        return $this->aula;
    }
        /*-------By neg---------*/
    /* ---------------------------------------------- fin Get aula --------------------------------------------------------------*/
     /* ---------------------------------------------- set aula  ----------------------------------------------------------------*/
     public function setAula (\src\Cresta\AulasBundle\Entity\Aula $aula){
         
         $this->aula =$aula;
     }
        /*-------By neg---------*/
    /* ---------------------------------------------- fin set aula -------------------------------------------------------------*/

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Reserva
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Reserva
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set fechaRegistro
     *
     * @param string $fechaRegistro
     * @return Reserva
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return string 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set horaDesde
     *
     * @param string $horaDesde
     * @return Reserva
     */
    public function setHoraDesde($horaDesde)
    {
        $this->horaDesde = $horaDesde;

        return $this;
    }

    /**
     * Get horaDesde
     *
     * @return string 
     */
    public function getHoraDesde()
    {
        return $this->horaDesde;
    }

    /**
     * Set horaHasta
     *
     * @param string $horaHasta
     * @return Reserva
     */
    public function setHoraHasta($horaHasta)
    {
        $this->horaHasta = $horaHasta;

        return $this;
    }

    /**
     * Get horaHasta
     *
     * @return string 
     */
    public function getHoraHasta()
    {
        return $this->horaHasta;
    }

    /**
     * Set fechaReserva
     *
     * @param string $fechaReserva
     * @return Reserva
     */
    public function setFechaReserva($fechaReserva)
    {
        $this->fechaReserva = $fechaReserva;

        return $this;
    }

    /**
     * Get fechaReserva
     *
     * @return string 
     */
    public function getFechaReserva()
    {
        return $this->fechaReserva;
    }
}
