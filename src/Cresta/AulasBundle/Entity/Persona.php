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
     * Article
     *
     * @ORM\Table(name="Persona")
     * @ORM\Entity(repositoryClass="Cresta\AulasBundle\Entity\Persona")
     * @ORM\InheritanceType("JOINED")
     * @ORM\DiscriminatorColumn(name="discr", type="string")
     * @ORM\DiscriminatorMap({"docente" = "Docente","administrador" = "Administrador"})
     */

    /**
     * @OneToOne(targetEntity="Docente")
     * @JoinColumn(name="id", referencedColumnName="id")
     */

    /**
     * @OneToOne(targetEntity="Administrador")
     * @JoinColumn(name="id", referencedColumnName="id")
     */

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
     * @return Persona
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

}
