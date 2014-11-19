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
}
