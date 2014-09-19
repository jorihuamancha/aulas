<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrestaAulasBundle:Default:index.html.twig', array('name' => $name));
    }

    public function acercadeAction()
    {
        return $this->render('CrestaAulasBundle:Default:acercade.html.twig', array());
    }

    public function ayudaAction()
    {
        return $this->render('CrestaAulasBundle:Default:ayuda.html.twig', array());
    }
}
