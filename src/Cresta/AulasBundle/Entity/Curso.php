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
     * @ORM\JoinColumn(name="carrera_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $carrera;

        /* ---------------------------------------------- Reserva-Actividad-----------------------------------------------------------*/
    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=45)
     */
    private $anio;

    /**
     * @var string
     *
     * @ORM\Column(name="ciclo", type="string", length=20)
     */
    private $Ciclo;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", length=20)
     */
    private $Semestre;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

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
     * @param string $carrera
     * @return Curso
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;

        return $this;
    }

    /**
     * Set Ciclo
     *
     * @param string $Ciclo
     * @return Curso
     */
    public function setCiclo($Ciclo)
    {
        $this->Ciclo = $Ciclo;

        return $this;
    }

    /**
     * Set Semestre
     *
     * @param string $Semestre
     * @return Curso
     */
    public function setSemestre($Semestre)
    {
        $this->Semestre = $Semestre;

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
        return $this->carrera;
    }

    /**
     * Get Ciclo
     *
     * @return string 
     */
    public function getCiclo()
    {
        return $this->Ciclo;
    }

    /**
     * Get Semestre
     *
     * @return string 
     */
    public function getSemestre()
    {
        return $this->Semestre;
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

     /**
     * Get CursoCarrera
     *
     * @return string 
     */
    public function getCursoCarrera()
    {
        $Carrera=$this->getCarrera()->getNombre();
        $cursoCarrera=$this->getNombre().' - ( '.$Carrera.' )';
        return $cursoCarrera;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Curso
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