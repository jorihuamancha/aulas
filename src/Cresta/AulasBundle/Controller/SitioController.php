<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;

class SitioController extends Controller
{
    /*public function indexAction($name)
    {
        return $this->render('CrestaAulasBundle:Default:index.html.twig', array('name' => $name));
    }*/
	public function estaticaAction($pagina)
		{
			//no me lo toma para entrar por ejemplo a /ayuda
			return $this->render('CrestaAulasBundle:Default:'.$pagina.'.html.twig'); //new Response ('Ayuda');
		}

	
}
