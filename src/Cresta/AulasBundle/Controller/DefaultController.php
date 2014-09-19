<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /*public function indexAction($name)
    {
        return $this->render('CrestaAulasBundle:Default:index.html.twig', array('name' => $name));
    }*/
	public function ayudaAction()
		{
			return $this->render('CrestaAulasBundle:Default:ayuda.html.twig'); //new Response ('Ayuda');
		}
}
