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

    /**
     * @ORM\OneToOne(targetEntity="Docente",cascade={"persist"})
     */             
    protected $docente;

    /**
     * @ORM\OneToOne(targetEntity="Administrador",cascade={"persist"})
     */              
    protected $administrador;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDocente(){
        return $this->docente;
    }

    public function setDocente($docente){
        $this->docente=$docente;
        return $this;
    }

    public function getAdministrador(){
        return $this->administrador;
    }

    public function setAdministrador($administrador){
        $this->administrador=$administrador;
        return $this;
    }



}
