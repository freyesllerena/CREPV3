<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Agent;
use AppBundle\AppBundle;
use AppBundle\Security\CampagneBrhpVoter;
use AppBundle\Repository\ModeleCrepRepository;
use AppBundle\Entity\Ministere;

class CampagneAgentController extends Controller
{
    /**
     * Lists all CampagneBrhp entities.
     *
     * @Security("has_role('ROLE_AGENT')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $campagnesAgent = $em->getRepository('AppBundle:CampagneBrhp')->findCampagnesRecentesAgent($this->getUser());

        return $this->render('campagneAgent/index.html.twig', array(
            'campagnesAgent' => $campagnesAgent,
        ));
    }

    /**
     * Finds and displays a CampagneBrhp entity.
     *
     * @Security("has_role('ROLE_AGENT')")
     */
    public function showAction(CampagneBrhp $campagne)
    {
        // Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_AGENT, $campagne);

        $em = $this->getDoctrine()->getManager();

        /* @var $agent Agent */
        $agent = $em->getRepository('AppBundle:Agent')->getAgentByUser($this->getUser(), $campagne->getCampagnePnc());

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        return $this->render('campagneAgent/show.html.twig', array(
            'campagneBrhp' => $campagne,
            'agent' => $agent,
            'modelesCrep' => $modelesCrep,
        ));
    }
}
