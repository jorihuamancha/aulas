<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Administrador extends Persona
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToOne(targetEntity="Persona", inversedBy="Admnistrador")
    */

    private $personaAdministrador;

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Docente
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
     * Get activo
     *
     * @return boolean 
     */
    public function getId()
    {
        return $this->id;
    }


    public function getPersonaAdministrador(){
        return $this->personaAdministrador;
    }

}
