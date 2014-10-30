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


    /* ---------------------------------------------- Reserva-Movimientos-------------------------------------------------------*/

    /**
     * @ORM\OneToOne(targetEntity="Movimiento", mappedBy="Reserva")
     */

    private $reservas;
        /*-------By neg---------*/

    /* ---------------------------------------------- Fin Relaciones-------------------------------------------------------------*/

    /* ---------------------------------------------- Persona-Movimiento-------------------------------------------------------*/
            
     /**
     * @ORM\OneToOne(targetEntity="Movimiento", mappedBy="Persona")
     */

     private $personas;
        /*---By Neg---*/
     /* ---------------------------------------------- Fin relacion      -------------------------------------------------------*/

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
