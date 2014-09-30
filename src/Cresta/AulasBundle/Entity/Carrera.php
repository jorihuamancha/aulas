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
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

        /*---By Neg---*/
    /* -----------------------------------------------  Relacion carrera-curso ------------------------------------------------ */
     /**
     * @ORM\OneToMany(targetEntity="Carrera", inversedBy="Curso")
     */
    private $cursos;  
        /*---By Neg---*/
    /* ------------------------------------------------ Fin Relacion  ------------------------------------------------ */
   
   


   /* ------------------------------------------------- Constructor Cursos ------------------------------------------------ */

   public function __construct(){
       
       $this->cursos = new \Doctrine\Common\Collections\ArrayCollection();
   }
    /*---By Neg---*/

   /* ------------------------------------------------- Fin Constructor Cursos ------------------------------------------------ */

   /* ------------------------------------------------- set Cursos ------------------------------------------------ */

   public function setCursos (\src\Cresta\AulasBundle\Entity\Carrera $cursos){
       
       $this->cursos [] = $cursos;
   }
        /*---By Neg---*/
   /* -------------------------------------------------  Fin set Cursos ------------------------------------------------ */

   /* ------------------------------------------------- Get Cursos ------------------------------------------------ */

   public function getCursos (){

        return $this->cursos;   

   }

   /* ------------------------------------------------- Fin Get Cursos ------------------------------------------------ */


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
