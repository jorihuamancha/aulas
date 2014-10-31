<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;

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

    }

    /**
    * @Pdf()
    */

    public function imprimirAction($listado){// http://localhost/aulas/web/app_dev.php/imprimir/listado.pdf
        $formato=$this->get('request')->get('_format');
        return $this->render(sprintf('CrestaAulasBundle:Default:listado.pdf.twig', $formato ),  
        array( 'listado'=>$listado) );   //'nombre'=>$nombre) );
    }

	/*public function imprimirAction($listado){
		$formato=$this->get('request')->get('_format');
		return $this->render(sprintf('AulasBundle:DefaultController:lista.%s.twig', $formato), array('listado'=>$listado ));
	}*/
}
