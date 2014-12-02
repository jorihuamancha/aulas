<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 *
 * @ORM\Table()
 * @ORM\Entity
 */

class Curso extends Tarea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    
    
    /* ---------------------------------------------- Reserva-Curso-----------------------------------------------------------*/
    /**
     * @ORM\ManyToOne(targetEntity="Carrera")
    */
    private $Carrera;

        /* ---------------------------------------------- Reserva-Actividad-----------------------------------------------------------*/
    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=45)
     */
    private $anio;

    /**
     * Set anio
     *
     * @param string $anio
     * @return Curso
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Set Carrera
     *
     * @param string $anio
     * @return Curso
     */
    public function setCarrera($Carrera)
    {
        $this->Carrera = $Carrera;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Get Carrera
     *
     * @return string 
     */
    public function getCarrera()
    {
        return $this->Carrera;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

}
