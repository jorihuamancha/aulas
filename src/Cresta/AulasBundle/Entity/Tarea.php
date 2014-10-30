<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarea
 *
 * @ORM\Table()
 * @ORM\Entity
 */

/** @MappedSuperclass */
class Tarea
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
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;


    /* ------------------------------------------------ Tarea-Curso Relacion  ---------------------------------------------------------- */
    /**
    * @OneToOne(targetEntity="Curso")
    * @JoinColumn(name="id", referencedColumnName="id")
    */
    protected $mapeoCursos;
    /* ------------------------------------------------ Fin Relacion  ---------------------------------------------------------- */

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
