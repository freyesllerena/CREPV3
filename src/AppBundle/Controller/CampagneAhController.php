<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Agent;
use AppBundle\Repository\AgentRepository;
use AppBundle\Security\CampagneBrhpVoter;
use AppBundle\Service\CrepManager;

class CampagneAhController extends Controller
{
    /**
     * Lists all CampagneBrhp entities.
     *
     * @Security("has_role('ROLE_AH')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $campagnesAh = $em->getRepository('AppBundle:CampagneBrhp')->findCampagnesRecentesAh($this->getUser(), $this->get('session')->get('selectedRole'));

        return $this->render('campagneAh/index.html.twig', array(
            'campagnesAh' => $campagnesAh,
        ));
    }

    /**
     * @Security("has_role('ROLE_AH')")
     */
    public function showAction(CampagneBrhp $campagneAh, CrepManager $crepManager)
    {
        // Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_AH, $campagneAh);

        $em = $this->getDoctrine()->getManager();

        /* @var $agentRepository AgentRepository */
        $agentRepository = $em->getRepository('AppBundle:Agent');

        // On récupère le AH de l'Utilisateur courant
        /* @var $ah Agent */
        $ah = $agentRepository->getAgentByEmail($this->getUser()->getEmail(), $campagneAh->getCampagnePnc());

        // On récupère la liste des agents du AH
        $agentsAh = $em->getRepository('AppBundle:Agent')->getAgentsByAh($ah, $campagneAh);

        $indicateurs = $crepManager->calculIndicateurs($campagneAh, null, null, null, $ah);

        $template = 'campagneAh/show.html.twig';

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        return $this->render($template, array(
            'campagneAh' => $campagneAh,
            'agentsAh' => $agentsAh,
            'indicateurs' => $indicateurs,
            'listeAgentsAvecCrep' => $agentsAh,
            'modelesCrep' => $modelesCrep,
        ));
    }
}
