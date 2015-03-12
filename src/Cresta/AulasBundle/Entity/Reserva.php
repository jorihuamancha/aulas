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
     * @ORM\ManyToOne(targetEntity="Docente")
     */
    private $docente;

    /**
     * @ORM\ManyToOne(targetEntity="Aula")
     */
    private $aula;

    /**
     * @ORM\ManyToOne(targetEntity="Curso")
     */
    private $curso;

    /**
     * @ORM\ManyToOne(targetEntity="Actividad")
     */
    private $actividad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaDesde", type="datetime")
     */
    private $horaDesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaHasta", type="datetime")
     */
    private $horaHasta;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="diosReserva", type="string", length=255, nullable=false)
     */
    private $diosReserva;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaRegistro", type="datetime")
     */
    private $horaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rangoHasta", type="datetime")
     */
    private $rangoHasta;

    /**
     * @var integer
     *
     * @ORM\Column(name="rango", type="integer")
     */
    private $rango;

    /**
    * @ORM\ManyToMany(targetEntity="Recurso")
    * @ORM\JoinTable(name="Reservas_Recursos",
    *      joinColumns={@ORM\JoinColumn(name="idReserva", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="idRecurso", referencedColumnName="id")}
    *      )
    */
    private $recursos;

    /**
     * @var string
     *
     * @ORM\Column(name="suspendida", type="boolean", length=1, nullable=true)
     */
    private $suspendida;


    public function __construct(){
        $this->recursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set rangoHasta
     *
     * @param \DateTime $rangoHasta
     * @return Reserva
     */
    public function setrangoHasta($rangoHasta)
    {
        $this->rangoHasta = $rangoHasta;

        return $this;
    }

    /**
     * Get rangoHasta
     *
     * @return \DateTime
     */
    public function getrangoHasta()
    {
        return $this->rangoHasta;
    }

    /**
     * Get rango
     *
     * @return integer 
     */
    public function getRango()
    {
        return $this->rango;
    }

     /**
     * Set rango
     *
     * @param integer $rango
     * @return Reserva
     */
    public function setrango($rango)
    {
        $this->rango = $rango;

        return $this;
    }


    public function getRecursos(){
        return $this->recursos;
    }

    public function setRecursos($recursos){
        $this->recursos []=$recursos;
    }


    /**
     * Set suspendida
     *
     * @param string $suspendida
     * @return Reserva
     */
    public function setSuspendida($suspendida)
    {
        $this->suspendida = $suspendida;

        return $this;
    }

    /**
     * Get suspendida
     *
     * @return string 
     */
    public function getSuspendida()
    {
        return $this->suspendida;
    }

     /**
     * Set diosReserva
     *
     * @param string $diosReserva
     * @return Reserva
     */
    public function setdiosReserva($diosReserva)
    {
        $this->diosReserva = $diosReserva;

        return $this;
    }

    /**
     * Get diosReserva
     *
     * @return string 
     */
    public function getdiosReserva()
    {
        return $this->diosReserva;
    }

    /**
     * Set docente
     *
     * @param integer $docente
     * @return Reserva
     */
    public function setDocente($docente)
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * Get docente
     *
     * @return integer 
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set aula
     *
     * @param integer $aula
     * @return Reserva
     */
    public function setAula($aula)
    {
        $this->aula = $aula;

        return $this;
    }

    /**
     * Get aula
     *
     * @return integer 
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * Set curso
     *
     * @param integer $curso
     * @return Reserva
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return integer 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set actividad
     *
     * @param integer $actividad
     * @return Reserva
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return integer 
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Reserva
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set horaDesde
     *
     * @param \DateTime $horaDesde
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
     * @return \DateTime 
     */
    public function getHoraDesde()
    {
        return $this->horaDesde;
    }

    /**
     * Set horaHasta
     *
     * @param \DateTime $horaHasta
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
     * @return \DateTime 
     */
    public function getHoraHasta()
    {
        return $this->horaHasta;
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
     * @param \DateTime $fechaRegistro
     * @return Reserva
     */
    public function setFechaRegistro($fechaRegistro)//$fechaRegistro)
    {
        //$fechaRegistro=date('Y-m-d');
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set horaRegistro
     *
     * @param \DateTime $horaRegistro
     * @return Reserva
     */
    public function setHoraRegistro($horaRegistro)//$horaRegistro)
    {
        //$horaRegistro= date('h:i:s');
        $this->horaRegistro = $horaRegistro;

        return $this;
    }

    /**
     * Get horaRegistro
     *
     * @return \DateTime 
     */
    public function getHoraRegistro()
    {
        return $this->horaRegistro;
    }

}
