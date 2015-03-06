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
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

      /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Docente
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
