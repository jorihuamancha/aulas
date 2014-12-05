<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movimiento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Movimiento
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;


    /**
     * @var string
     *
     * @ORM\Column(name="reservaAula", type="string")
     */
    private $reservaAula;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservaHoraDesde", type="datetime")
     */
    private $reservaHoraDesde;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservaHoraHasta", type="datetime")
     */
    private $reservaHoraHasta;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservaParaDiaDeReserva", type="datetime")
     */
    private $reservaParaDiaDeReserva; //esta es la fecha para la cual iba a estar hecha la reserva



    /**
     * @var string
     *
     * @ORM\Column(name="movimientoPersona", type="string")
     */
    private $movimientoPersona;



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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Movimiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \Date 
     */
    public function getFecha()
    {
        return $this->fecha;
    }


    /**
     * Set reservaAula
     *
     * @param string $reservaAula
     * @return Movimiento
     */
    public function setReservaAula($reservaAula)
    {
        $this->reservaAula = $reservaAula;

        return $this;
    }

    /**
     * Get reservaAula
     *
     * @return string 
     */
    public function getReservaAula()
    {
        return $this->reservaAula;
    }

    /**
     * Set reservaHoraDesde
     *
     * @param \DateTime $reservaHoraDesde
     * @return Movimiento
     */
    public function setReservaHoraDesde($reservaHoraDesde)
    {
        $this->reservaHoraDesde = $reservaHoraDesde;

        return $this;
    }



    /**
     * Get reservaHoraDesde
     *
     * @return \DateTime 
     */
    public function getReservaHoraDesde()
    {
        return $this->reservaHoraDesde;
    }



    /**
     * Set reservaHoraHasta
     *
     * @param \DateTime $reservaHoraHasta
     * @return Movimiento
     */
    public function setReservaHoraHasta($reservaHoraHasta)
    {
        $this->reservaHoraHasta = $reservaHoraHasta;

        return $this;
    }



    /**
     * Get reservaHoraHasta
     *
     * @return \DateTime 
     */
    public function getReservaHoraHasta()
    {
        return $this->reservaHoraHasta;
    }



    /**
     * Set reservaParaDiaDeReserva
     *
     * @param string $reservaParaDiaDeReserva
     * @return Movimiento
     */
    public function setReservaParaDiaDeReserva($reservaParaDiaDeReserva)
    {
        $this->reservaParaDiaDeReserva = $reservaParaDiaDeReserva;

        return $this;
    }



    /**
     * Get reservaParaDiaDeReserva
     *
     * @return string 
     */
    public function getReservaParaDiaDeReserva()
    {
        return $this->reservaParaDiaDeReserva;
    }



    /**
     * Set movimientoPersona
     *
     * @param string $movimientoPersona
     * @return Movimiento
     */
    public function setUsuario($movimientoPersona)
    {
        $this->movimientoPersona = $movimientoPersona;

        return $this;
    }



    /**
     * Get movimientoPersona
     *
     * @return string 
     */
    public function getMovimientoPersona()
    {
        return $this->movimientoPersona;
    }
    

}
