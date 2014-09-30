<?php

namespace Cresta\AulasBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Usuario 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /* ---------------------------------------------- Usuario-Persona------------------------------------------------------*/
    /**
     * @ORM\OneToOne(targetEntity="Persona")
     */

    private $personas;
        /*-------By neg---------*/
     /* ---------------------------------------------- Fin de relaciones ------------------------------------------------------*/



    /* ---------------------------------------------- Get Persona ------------------------------------------------------*/
    
    public function getPesona (){
        
        return $this->personas;
    }
        /*-------By neg---------*/
    /* ---------------------------------------------- Fin Get ----------------------------------------------------------*/ 

    /* ---------------------------------------------- set Persona ------------------------------------------------------*/
    public function setPersona(Cresta\AulasBundle\Entity\Persona $persona){
        
        $this->persona = $persona;
    }

        /*-------By neg---------*/
    /* ----------------------------------------------Fin set Persona ---------------------------------------------------*/


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
