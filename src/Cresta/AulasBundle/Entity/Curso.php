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
     * @ORM\JoinColumn(name="Carrera_id", referencedColumnName="id", onDelete="CASCADE")
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
     * Set Ciclo
     *
     * @param string $anio
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
     * @param string $anio
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
        return $this->Carrera;
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
        $carrera=$this->getCarrera()->getNombre();
        $cursoCarrera=$this->getNombre().' - ( '.$carrera.' )';
        return $cursoCarrera;
    }

}