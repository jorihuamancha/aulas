<?php

namespace Cresta\AulasBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cresta\AulasBundle\Entity\Usuario;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrestaAulasBundle:Usuario')->findAll();

        return $this->render('CrestaAulasBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrestaAulasBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        return $this->render('CrestaAulasBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
