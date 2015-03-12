<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrera
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Carrera
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
     * @ORM\Column(name="nombre", type="string", length=45 , unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="universidad", type="string", length=255)
     */
    private $universidad;

    /**
     * @var string
     *
     * @ORM\Column(name="facultad", type="string", length=255)
     */
    private $facultad;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=20)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=20, nullable=true)
     */
    private $plan;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

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
     * @return Carrera
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

    /**
     * Set universidad
     *
     * @param string $universidad
     * @return Carrera
     */
    public function setUniversidad($universidad)
    {
        $this->universidad = $universidad;

        return $this;
    }

    /**
     * Get universidad
     *
     * @return string 
     */
    public function getUniversidad()
    {
        return $this->universidad;
    }

    /**
     * Set facultad
     *
     * @param string $facultad
     * @return Carrera
     */
    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;

        return $this;
    }

    /**
     * Get facultad
     *
     * @return string 
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Carrera
     */
    public function setColor($color)
    {
        $this->color = '#' . $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

        /**
     * Set plan
     *
     * @param string $plan
     * @return Carrera
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return string 
     */
    public function getPlan()
    {
        return $this->plan;
    }


    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Carrera
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
}
