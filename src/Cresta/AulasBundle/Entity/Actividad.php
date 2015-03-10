<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Actividad extends Tarea
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
     * @ORM\Column(name="tipo", type="string", length=45)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="disertantes", type="string", length=255, nullable=true)
     */
    private $disertantes;


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Actividad
     */

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set disertantes
     *
     * @param string $disertantes
     * @return Actividad
     */

    public function setDisertantes($disertantes)
    {
        $this->disertantes = $disertantes;

        return $this;
    }

    /**
     * Get disertantes
     *
     * @return string 
     */
    public function getDisertantes()
    {
        return $this->disertantes;
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
}
