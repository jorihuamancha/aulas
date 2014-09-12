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
     * @ORM\Column(name="horaRegistro", type="string", length=45)
     */
    private $horaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaRegistro", type="string", length=45)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="horaDesde", type="string", length=45)
     */
    private $horaDesde;

    /**
     * @var string
     *
     * @ORM\Column(name="horaHasta", type="string", length=45)
     */
    private $horaHasta;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaReserva", type="string", length=45)
     */
    private $fechaReserva;

    /**
     * @var integer
     *
     * @ORM\Column(name="idTarea", type="integer")
     */
    private $idTarea;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPersona", type="integer")
     */
    private $idPersona;

    /**
     * @var integer
     *
     * @ORM\Column(name="idAula", type="integer")
     */
    private $idAula;


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
     * Set horaRegistro
     *
     * @param string $horaRegistro
     * @return Reserva
     */
    public function setHoraRegistro($horaRegistro)
    {
        $this->horaRegistro = $horaRegistro;

        return $this;
    }

    /**
     * Get horaRegistro
     *
     * @return string 
     */
    public function getHoraRegistro()
    {
        return $this->horaRegistro;
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

    /**
     * Set idTarea
     *
     * @param integer $idTarea
     * @return Reserva
     */
    public function setIdTarea($idTarea)
    {
        $this->idTarea = $idTarea;

        return $this;
    }

    /**
     * Get idTarea
     *
     * @return integer 
     */
    public function getIdTarea()
    {
        return $this->idTarea;
    }

    /**
     * Set idPersona
     *
     * @param integer $idPersona
     * @return Reserva
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return integer 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * Set idAula
     *
     * @param integer $idAula
     * @return Reserva
     */
    public function setIdAula($idAula)
    {
        $this->idAula = $idAula;

        return $this;
    }

    /**
     * Get idAula
     *
     * @return integer 
     */
    public function getIdAula()
    {
        return $this->idAula;
    }
}
