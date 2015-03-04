<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Pdf controller.
 *
 */
class PdfController extends Controller
{
	//Caso de prueba
	public function helloAction($name) {
		
		die("hola");

		$format = $this->get('request')->get('_format');
		$name = "ejemplo";
		

	    return $this->render(sprintf('SomeBundle:SomeController:helloAction.%s.twig', $format), array('name' => $name));
	}

}

?>