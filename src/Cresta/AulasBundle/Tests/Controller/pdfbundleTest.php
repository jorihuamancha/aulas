<?php
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;


class PdfBundleController extends Controller{
   /**
	 * @Pdf()
	 */
	public function helloAction($name)
	{
	    $format = $this->get('request')->get('_format');

	    return $this->render(sprintf('SomeBundle:SomeController:helloAction.%s.twig', $format), array(
	        'name' => $name,
	    ));
	}
}
?>