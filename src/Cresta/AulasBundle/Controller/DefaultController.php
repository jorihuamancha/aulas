<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CrestaAulasBundle:Default:index.html.twig', array());
    }
    
    public function acercadeAction()
    {
        return $this->render('CrestaAulasBundle:Default:acercade.html.twig', array());
    }

    public function ayudaAction()
    {
        return $this->render('CrestaAulasBundle:Default:ayuda.html.twig', array());
<<<<<<< HEAD
    }	 
=======
    }
>>>>>>> 9904df976dec1d423c53b2040f437a5aa887b46c

}
