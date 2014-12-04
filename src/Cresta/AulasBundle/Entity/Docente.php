<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Docente extends Persona
{

    /**
     * @ORM\OneToOne(targetEntity="Persona", inversedBy="Docente")
    */

    private $personaDocente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
}
