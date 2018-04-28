<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AideController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function aideAction()
    {
        return $this->render('Aide/aide.html.twig');
    }
}
