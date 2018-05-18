<?php

namespace AppBundle\Controller;

use AppBundle\Security\CampagneBrhpVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\CampagneBrhp;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Agent;
use AppBundle\Repository\AgentRepository;
use AppBundle\AppBundle;
use AppBundle\Service\CrepManager;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\StatutValidationAgentsType;
use AppBundle\EnumTypes\EnumStatutValidationAgent;
use AppBundle\Service\AgentManager;
use Symfony\Component\Validator\Constraints\Valid;

class CampagneShdController extends Controller
{
    /**
     * Lists all CampagneBrhp entities.
     *
     * @Security("has_role('ROLE_SHD')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $campagnesShd = $em->getRepository('AppBundle:CampagneBrhp')->findCampagnesRecentesShd($this->getUser());

        return $this->render('campagneShd/index.html.twig', array(
            'campagnesShd' => $campagnesShd,
        ));
    }

    /**
     * Finds and displays a CampagneBrhp entity.
     *
     * @Security("has_role('ROLE_SHD')")
     */
    public function showAction(CampagneBrhp $campagneShd, Request $request)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_SHD, $campagneShd);

        $em = $this->getDoctrine()->getManager();

        /* @var $agentRepository AgentRepository */
        $agentRepository = $em->getRepository('AppBundle:Agent');

        // On récupère le SHD de l'Utilisateur courant
        /* @var $shd Agent */
        $shd = $agentRepository->getAgentByEmail($this->getUser()->getEmail(), $campagneShd->getCampagnePnc());

        // On récupère la liste des agents du N+1
        $agents = $agentRepository->getAgentsByShd($shd, $campagneShd);

        //Formulaire de validation/Rejet des agents pour un N+1
        $validerForm = $this->creerValiderAgentsForm($agents, $campagneShd);

        $validerForm->handleRequest($request);

        if ($validerForm->isSubmitted() && $validerForm->isValid()) {
            //Voter
            $this->denyAccessUnlessGranted(CampagneBrhpVoter::VALIDER_AGENT, $campagneShd);

            $agentsAValider = $validerForm->getData()['agents'];

            /* @var $agentManager AgentManager */
            $agentManager = $this->get('app.agent_manager');
            $agentManager->validerRejeterAgents($agentsAValider);

            $this->get('session')->getFlashBag()->set('notice', 'La liste a bien été envoyée !');

            // Si le N+1 ne possède plus de liste, donc il n'a plus de campagne SHD. Il faut le renvoyer, dans ce cas, vers l'accueil de l'appli
            if ($this->isGranted(CampagneBrhpVoter::VOIR_SHD, $campagneShd)) {
                $url = $this->generateUrl('campagne_shd_show', array('id' => $campagneShd->getId()));
            } else {
                $url = $this->generateUrl('accueil');
            }

            return $this->redirect($url);
        }

        // Récupérer les agents non évaluables du shd
        $agentsNonEvaluables = $agentRepository->findBy(['shd' => $shd, 'campagneBrhp' => $campagneShd, 'evaluable' => false]);

        // Tableau dont les clés sont les id de l'agent et les valeurs sont les formulaires de détachement d'un shd
        $detacherShdForms = [];

        /* @var $agent Agent */
        foreach ($agentsNonEvaluables as $agent) {
            $detacherShdForms[$agent->getId()] = $this->createDetacherShdForm($agent->getId())->createView();
        }

        // Récupérer les agents sans SHD du périmètre du BRHP
        //$agentsSansShd = $agentRepository->findBy(["shd" => null , "campagneBrhp" => $campagneShd]);

        /*@var $crepManager CrepManager */
        $crepManager = $this->get('app.crep_manager');

        $indicateurs = $crepManager->calculIndicateurs($campagneShd, null, null, $shd);

        //On initialise un array qui va contenir tous
        //les crep afin de supprimer les doc liés
        $agentsValides = array();

        //tableau qui contient les agents n'ayant pas encore de crep (en attente de validation)
        $agentsEnCoursDeValidation = array();

        /* @var $agent Agent */
        foreach ($agents as $agent) {
            if (EnumStatutValidationAgent::VALIDE == $agent->getStatutValidation() && $agent->getEvaluable()) {
                $agentsValides[] = $agent;
                $detacherShdForms[$agent->getId()] = $this->createDetacherShdForm($agent->getId())->createView();
            } else {
                $agentsEnCoursDeValidation[] = $agent;
            }
        }

        $template = 'campagneShd/show.html.twig';

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        $response = $this->render($template, array(
            'campagneShd' => $campagneShd,
            'indicateurs' => $indicateurs,
            'agentsEnCoursDeValidation' => $agentsEnCoursDeValidation,
            'agentsValides' => $agentsValides,
            'detacherShdForms' => $detacherShdForms,
            'agentsNonEvaluables' => $agentsNonEvaluables,
            //'agentsSansShd'			=> $agentsSansShd,
            'valider_form' => $validerForm->createView(),
            'agents' => $agents,
            'modelesCrep' => $modelesCrep,
        ));

        return $response;
    }

    /**
     * Générer le formulaire de rejet d'une liste de SHD.
     *
     * @param CampagneBrhp $campagneShd
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerValiderAgentsForm($agents, CampagneBrhp $campagneShd)
    {
        // On retire les agents déjà validés
        foreach ($agents as $index => $agent) {
            if (EnumStatutValidationAgent::VALIDE == $agent->getStatutValidation() || !$agent->getEvaluable()) {
                unset($agents[$index]);
            }
        }

        return $this->createFormBuilder(null, ['validation_groups' => array('validationShd')])
                    ->add('agents', CollectionType::class, array(
                            'constraints' => [new Valid()],
                            'entry_type' => StatutValidationAgentsType::class,
                            'data' => $agents, ))
                    ->setAction($this->generateUrl('campagne_shd_show', array('id' => $campagneShd->getId())))
                    ->setMethod('POST')
                    ->getForm();
    }

    private function auMoinsUnAgentValide($agents)
    {
        foreach ($agents as $agent) {
            if (EnumStatutValidationAgent::VALIDE == $agent->getStatutValidation()) {
                return true;
            }
        }

        return false;
    }

    private function createDetacherShdForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('agent_detacher_shd', array('id' => $id)))
        ->setMethod('PUT')
        ->getForm();
    }
}
