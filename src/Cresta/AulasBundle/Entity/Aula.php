<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aula
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Aula
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
     * @ORM\Column(name="piso", type="string", length=45)
     */
    private $piso;

    /**
     * @var string
     *
     * @ORM\Column(name="capacidad", type="integer", length=11)
     */
    private $capacidad;

        /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="recursosFijos", type="string", length=255, nullable=true)
     */
    private $recursosFijos;

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
     * @return Aula
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
     * Set piso
     *
     * @param string $piso
     * @return Aula
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return string 
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Get nombrecapacidad
     *
     * @return string 
     */
    public function getNombreCapacidad()
    {
        $nombreCapacidad=$this->getNombre().' - ('.$this->getCapacidad().')';
        return $nombreCapacidad;
    }

    /**
     * Set capacidad
     *
     * @param string $capacidad
     * @return Aula
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Aula
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

        /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Aula
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
     * Set recursosFijos
     *
     * @param string $recursosFijos
     * @return Aula
     */
    public function setRecursosFijos($recursosFijos)
    {
        $this->recursosFijos = $recursosFijos;

        return $this;
    }

    /**
     * Get recursosFijos
     *
     * @return string 
     */
    public function getRecursosFijos()
    {
        return $this->recursosFijos;
    }

}
