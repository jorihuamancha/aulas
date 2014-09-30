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
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45)
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=45)
     */
    private $clave;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45)
<<<<<<< HEAD
     */
    private $email;


    /* ---------------------------------------------- Usuario-Persona------------------------------------------------------*/
    /**
     * @ORM\OneToOne(targetEntity="Persona", mappedBy="Usuario")
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
    public function setPersona(\src\Cresta\AulasBundle\Entity\Persona $persona){
        
        $this->persona = $persona;
    }

        /*-------By neg---------*/
    /* ----------------------------------------------Fin set Persona ---------------------------------------------------*/
=======
     */
    private $email;


    /* ---------------------------------------------- Usuario-Persona------------------------------------------------------*/
    /**
     * @ORM\OneToOne(targetEntity="Persona", mappedBy="Usuario")
     */

    private $personas;
        /*-------By neg---------*/
     /* ---------------------------------------------- Fin de relaciones ------------------------------------------------------*/

>>>>>>> 3d2ad3b480862ae1ceb0db94284582bb727d4a0f


    /* ---------------------------------------------- Get Persona ------------------------------------------------------*/
    
    public function getPesona (){
        
        return $this->personas;
    }
    
    
        /*-------By neg---------*/
    /* ---------------------------------------------- Fin Get ------------------------------------------------------*/ 
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
     * Set clave
     *
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUserName($username)
    {
        $this->username = $username;

        return $this;
    }

     /**
     * Get username
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->username;
    }


    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */

     
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Usuario
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
