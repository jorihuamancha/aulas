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
     * @var string
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;


    /**
     * @var string
     *
     * @ORM\Column(name="reservaAula", type="string")
     */
    private $reservaAula;


    /**
     * @var string
     *
     * @ORM\Column(name="reservaHoraDesde", type="time")
     */
    private $reservaHoraDesde;


    /**
     * @var string
     *
     * @ORM\Column(name="reservaHoraHasta", type="time")
     */
    private $reservaHoraHasta;


    /**
     * @var string
     *
     * @ORM\Column(name="reservaParaDiaDeReserva", type="date")
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
     * @param string $fecha
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
     * @return string 
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
     * Set reservaHoraDesde
     *
     * @param string $reservaHoraDesde
     * @return Movimiento
     */
    public function setReservaHoraDesde($reservaHoraDesde)
    {
        $this->reservaHoraDesde = $reservaHoraDesde;

        return $this;
    }



    /**
     * Set reservaHoraHasta
     *
     * @param string $reservaHoraHasta
     * @return Movimiento
     */
    public function setReservaHoraHasta($reservaHoraHasta)
    {
        $this->reservaHoraHasta = $reservaHoraHasta;

        return $this;
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
}
