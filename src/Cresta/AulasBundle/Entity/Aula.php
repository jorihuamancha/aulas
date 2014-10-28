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
     * @ORM\Column(name="nombre", type="string", length=45)
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
     * @ORM\Column(name="capacidad", type="string", length=45)
     */
    private $capacidad;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /* ---------------------------------------------- Tarea-Reserva------------------------------------------------------------*/
    /**
     * @ORM\OneToOne(targetEntity="Aula", mappedBy="Reserva")
     */

    private $aulas;
        /*-------By neg---------*/

    /* ----------------------------------------------Fin recurso-Recurso----------------------------------------------------------*/



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
     * @return string 
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
}
