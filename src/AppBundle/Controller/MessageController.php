<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Utilisateur;

/**
 * Message controller.
 */
class MessageController extends Controller
{
    /**
     * Liste toutes les messages.
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('AppBundle:Message')->getMessagesUtilisateur($utilisateur);

        return $this->render('message/index.html.twig', array('messages' => $messages));
    }
}
