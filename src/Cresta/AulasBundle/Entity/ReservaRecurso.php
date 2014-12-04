<?php

namespace Cresta\AulasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservaRecurso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ReservaRecurso
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
     * @ORM\ManyToOne(targetEntity="ReservaRecurso", inversedBy="id")
     * @ORM\JoinColumn(name="idReserva", referencedColumnName="id")
     * @return integer
     */
    private $idReserva;

    /**
     * @ORM\ManyToOne(targetEntity="ReservaRecurso", inversedBy="id")
     * @ORM\JoinColumn(name="idRecurso", referencedColumnName="id")
     * @return integer
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
     * @return ReservaRecurso
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
     * @return ReservaRecurso
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
