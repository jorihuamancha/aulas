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

 
}
