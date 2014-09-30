<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Persona
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

     /* ---------------------------------------------- Persona-Movimiento-------------------------------------------------------*/

     /**
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="Movimiento")
     */

     private $movimientos;
        /*---By Neg---*/
     /* ---------------------------------------------- Persona-reserva-------------------------------------------------------*/

      /**
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="Reserva")
     */

      private $reservapersonas;
        /*---By Neg---*/


    /* ---------------------------------------------- Fin relaciones-------------------------------------------------------*/


    /* ---------------------------------------------- Constructor -----------------------------------------------------------*/

    public function _construct(){
        
        $this->reservapersonas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();   
    } 
        /*---By Neg---*/
    /* ---------------------------------------------- Fin Constructor -------------------------------------------------------*/
    
    
    /* ---------------------------------------------- Get reservapersonas ----------------------------------------------------------*/

    public function getResevaPersonas(){
        
        return $this->reservapersonas;
    }
            /*---By Neg---*/
    
    /* ---------------------------------------------- Fin Get reservapersonas-------------------------------------------------------*/  
    
    /* ---------------------------------------------- Set reservapersonas --------------------------------------------------------------*/

    public function addReservaPersonas (Cresta\AulasBundle\Entity\Reserva $reservapersonas){
        
        $this->reservapersonas[] = $reservapersonas;
    }
        /*---By Neg---*/
    /* ---------------------------------------------- fin Get reservapersonas ----------------------------------------------------------*/

    /* ---------------------------------------------- Set movimientos ------------------------------------------------------------------*/
    public function addMovimientos (Cresta\AulasBundle\Entity\Movimiento $movimientos){
        $this->movimientos[] = $movimientos;
    }
        /*---By Neg---*/
    /* ---------------------------------------------- fin set movimientos --------------------------------------------------------------*/

    /* ---------------------------------------------- get movimientos ------------------------------------------------------------------*/

    public function getMovimientos(){
        return $this->movimientos;
    }
        /*---By Neg---*/
    /* ---------------------------------------------- fin set movimientos --------------------------------------------------------------*/

      
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
     * @return Persona
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
