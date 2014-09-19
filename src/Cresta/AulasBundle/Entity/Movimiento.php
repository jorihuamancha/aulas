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
     * @ORM\Column(name="fecha", type="string", length=45)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="idReserva", type="integer")
     */
    private $idReserva;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPersona", type="integer")
     */
    private $idPersona;


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
     * Set idReserva
     *
     * @param integer $idReserva
     * @return Movimiento
     */
    public function setIdReserva($idReserva)
    {
        $this->idReserva = $idReserva;

        return $this;
    }

    /**
     * Get idReserva
     *
     * @return integer 
     */
    public function getIdReserva()
    {
        return $this->idReserva;
    }

    /**
     * Set idPersona
     *
     * @param integer $idPersona
     * @return Movimiento
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
}
