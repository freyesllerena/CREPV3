<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        return $this->render('Accueil/accueil.html.twig');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deployCollapseMenuAction(Request $request, $etat)
    {
        if ($request->isXmlHttpRequest()) {
            $this->get('session')->set('deployCollapseMenu', $etat);
        }

        return new Response('');
    }
}
