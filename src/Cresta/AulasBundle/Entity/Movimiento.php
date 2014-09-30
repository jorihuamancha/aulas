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


    /* ---------------------------------------------- Reserva-Movimientos-------------------------------------------------------*/

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", inversedBy="Reserva")
     */

    private $reservas;
        /*-------By neg---------*/

    /* ---------------------------------------------- Fin Relaciones-------------------------------------------------------------*/

    /* ---------------------------------------------- Persona-Movimiento-------------------------------------------------------*/

     /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="Persona")
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
