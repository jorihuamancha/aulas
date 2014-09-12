<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservaDeRecurso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ReservaDeRecurso
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
     * @var integer
     *
     * @ORM\Column(name="idReserva", type="integer")
     */
    private $idReserva;

    /**
     * @var integer
     *
     * @ORM\Column(name="idRecurso", type="integer")
     */
    private $idRecurso;


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
     * Set idReserva
     *
     * @param integer $idReserva
     * @return ReservaDeRecurso
     */
    public function setIdReserva($idReserva)
    {
        $this->idReserva = $idReserva;

        return $this;
    }

    /**
     * Get idReserva
     *
     * @return integer 
     */
    public function getIdReserva()
    {
        return $this->idReserva;
    }

    /**
     * Set idRecurso
     *
     * @param integer $idRecurso
     * @return ReservaDeRecurso
     */
    public function setIdRecurso($idRecurso)
    {
        $this->idRecurso = $idRecurso;

        return $this;
    }

    /**
     * Get idRecurso
     *
     * @return integer 
     */
    public function getIdRecurso()
    {
        return $this->idRecurso;
    }
}
