<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table()
 * @ORM\Entity
 */

/** @ORM\MappedSuperclass */

abstract class Persona
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
     * @ORM\Column(name="apellido", type="string", length=45)
     */
    private $apellido;

   

    /* ---------------------------------------------- Constructor -----------------------------------------------------------*/

    public function _construct(){
        
        $this->reservapersonas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();   
    } 
        /*---By Neg---*/
    /* ---------------------------------------------- Fin Constructor -------------------------------------------------------*/
    
    
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

        /**
     * Set apellido
     *
     * @param string $apellido
     * @return Docente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Get apellidonombre
     *
     * @return string 
     */
    public function getApellidoNombre()
    {
        $apellidoNombre=$this->getApellido().', '.$this->getNombre();
        return $apellidoNombre;
    }

}
