<?php

namespace Cresta\AulasBundle\Entity;


use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Usuario
 *
 * @ORM\Table()
 * @ORM\Entity
 */

class Usuario extends BaseUser

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
    
    public function getPersona(){
        
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
