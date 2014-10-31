<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarea
 *
 * @ORM\Table()
 * @ORM\Entity
 */
/** @ORM\MappedSuperclass */

class Tarea
{

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;

    /**
     * @OneToOne(targetEntity="Curso")
     * @JoinColumn(name="id", referencedColumnName="id")
     */

    /**
     * @OneToOne(targetEntity="Actividad")
     * @JoinColumn(name="id", referencedColumnName="id")
     */
    
    /* ------------------------------------------------ Fin Relacion  ---------------------------------------------------------- */

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tarea
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
