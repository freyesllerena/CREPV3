<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Service\AgentManager;
use AppBundle\Entity\Utilisateur;
use AppBundle\Security\AgentVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Repository\AgentRepository;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Repository\CampagneBrhpRepository;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Security\CampagnePncVoter;
use AppBundle\Util\Util;
use AppBundle\Security\CampagneRlcVoter;
use AppBundle\Entity\Campagne;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Security\CampagneBrhpVoter;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Perimetre;
use AppBundle\Repository\CampagneRlcRepository;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Ministere;
use AppBundle\Service\CrepManager;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Security\CrepVoter;
use AppBundle\Repository\ModeleCrepRepository;
use AppBundle\Twig\AppExtension;
use AppBundle\Entity\Document;
use AppBundle\Service\DocumentManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Agent controller.
 */
class AgentController extends Controller
{
    /**
     * Lists all agent entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agents = $em->getRepository('AppBundle:Agent')->findAll();

        return $this->render('agent/index.html.twig', array(
            'agents' => $agents,
        ));
    }

    /**
     * Creates a new agent entity by BRHP.
     */
    public function newAgentBrhpAction(Request $request, CampagneBrhp $campagneBrhp, AgentManager $agentMananger)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::AJOUTER_AGENT, $campagneBrhp);

        $agent = new Agent();

        $agent->setCampagnePnc($campagneBrhp->getCampagnePnc());

        $agent->setAjouteManuellement(true);

        $unitesOrganisationnelles = $campagneBrhp->getPerimetreBrhp()->getUnitesOrganisationnelles();

        $form = $this->createForm('AppBundle\Form\AgentType', $agent, ['validation_groups' => array('Default', 'AjoutManuel'),
                                                                        'unitesOrganisationnelles' => $unitesOrganisationnelles,
                                                                        'roleUtilisateur' => 'ROLE_BRHP',
                                                                        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentMananger->creer($agent, $campagneBrhp->getCampagnePnc(), $campagneBrhp->getCampagneRlc(), $campagneBrhp);

            $this->get('session')->getFlashBag()->set('notice', 'Agent créé avec succès !');

            return $this->redirectToRoute('campagne_brhp_show', array('id' => $campagneBrhp->getId()));
        }

        return $this->render('agent/new.html.twig', array(
            'agent' => $agent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new agent entity by RLC.
     */
    public function newAgentRlcAction(Request $request, CampagneRlc $campagneRlc, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneRlcVoter::AJOUTER_AGENT, $campagneRlc);

        $agent = new Agent();

        $agent->setCampagnePnc($campagneRlc->getCampagnePnc());

        $agent->setAjouteManuellement(true);

        $em = $this->getDoctrine()->getManager();

        $perimetresBrhp = $campagneRlc->getPerimetresBrhp();

        $form = $this->createForm('AppBundle\Form\AgentType', $agent, ['validation_groups' => array('Default', 'AjoutManuel'),
                                                                        'perimetresBrhp' => $perimetresBrhp,
                                                                        'roleUtilisateur' => 'ROLE_RLC',
                                                                        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /* @var $campagneBrhpRepository CampagneBrhpRepository */
            $campagneBrhpRepository = $em->getRepository('AppBundle:CampagneBrhp');

            $campagneBrhp = null;

            if ($agent->getPerimetreBrhp()) {
                $campagneBrhp = $campagneBrhpRepository->getCampagneBrhp($campagneRlc->getCampagnePnc(), $agent->getPerimetreBrhp());
            }

            $agent->setCampagneRlc($campagneRlc);

            $agentManager->creer($agent, $campagneRlc->getCampagnePnc(), $campagneRlc, $campagneBrhp);

            $this->get('session')->getFlashBag()->set('notice', 'Agent créé avec succès !');

            return $this->redirectToRoute('campagne_rlc_show', array('id' => $campagneRlc->getId()));
        }

        return $this->render('agent/new.html.twig', array(
            'agent' => $agent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new agent entity by PNC.
     */
    public function newAgentPncAction(Request $request, CampagnePnc $campagnePnc, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::AJOUTER_AGENT, $campagnePnc);

        $agent = new Agent();

        $agent->setCampagnePnc($campagnePnc);

        $agent->setAjouteManuellement(true);

        $em = $this->getDoctrine()->getManager();

        $perimetresRlc = $campagnePnc->getPerimetresRlc();

        $form = $this->createForm('AppBundle\Form\AgentType', $agent, ['validation_groups' => array('Default', 'AjoutManuel'),
                                                                        'roleUtilisateur' => 'ROLE_PNC',
                                                                        'perimetresRlc' => $perimetresRlc,
                                                                        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagneRlc = null;

            if ($agent->getPerimetreRlc()) {
                /* @var $campagneRlcRepository CampagneRlcRepository */
                $campagneRlcRepository = $em->getRepository('AppBundle:CampagneRlc');

                $campagneRlc = $campagneRlcRepository->getCampagneRlc($campagnePnc, $agent->getPerimetreRlc());
            }

            $agentManager->creer($agent, $campagnePnc, $campagneRlc);

            $this->get('session')->getFlashBag()->set('notice', 'Agent créé avec succès !');

            return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
        }

        return $this->render('agent/new.html.twig', array(
            'agent' => $agent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agent entity.
     */
    public function showAction(Agent $agent)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::VOIR, $agent);

        return $this->render('agent/show.html.twig', array(
            'agent' => $agent,
        ));
    }

    /**
     * Displays a form to edit an existing agent entity.
     */
    public function editAction(Request $request, Agent $agent, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::MODIFIER, $agent);

        $campagneBrhp = $agent->getCampagneBrhp();

        $em = $this->getDoctrine()->getManager();

        $unitesOrganisationnelles = null;
        if ($campagneBrhp) {
            $unitesOrganisationnelles = $campagneBrhp->getPerimetreBrhp()->getUnitesOrganisationnelles();
        }

        $roleSelected = $this->get('session')->get('selectedRole');

        $perimetresBrhp = null;
        if ($agent->getCampagneRlc()) {
            $perimetresBrhp = $agent->getCampagneRlc()->getPerimetresBrhp();
        }

        $perimetresRlc = $agent->getCampagnePnc()->getPerimetresRlc();

        $editForm = $this->createForm('AppBundle\Form\AgentType', $agent, ['validation_groups' => array('Default', 'AjoutManuel'),
                                                                           'unitesOrganisationnelles' => $unitesOrganisationnelles,
                                                                           'perimetresBrhp' => $perimetresBrhp,
                                                                           'perimetresRlc' => $perimetresRlc,
                                                                           'roleUtilisateur' => $roleSelected,
                                                                           ]);

        // Récupérer l'agent 'avant modification'
        $ancienAgent = clone $agent;
        $editForm->handleRequest($request);
        $deteteDocumentsForms = $this->creerDeleteDocumentsForms($agent);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $agentManager->update($agent, $ancienAgent);

            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Agent modifié avec succès !');

            $url = $this->generateUrlShowCampagneByRole($agent);

            return $this->redirect($url);
        }

        return $this->render('agent/edit.html.twig', array('agent' => $agent,
                                                           'form' => $editForm->createView(),
                                                              'deteteDocumentsForms' => $deteteDocumentsForms,
                                                           ));
    }

    /**
     * Détache un agent de son N+1.
     *
     * @Security("has_role('ROLE_SHD')")
     */
    public function detacherShdAction(Request $request, Agent $agent, AgentManager $agentManager)
    {
        $this->denyAccessUnlessGranted(AgentVoter::DETACHER_SHD, $agent);

        $form = $this->createDetacherShdForm($agent->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $agentManager->detacherShd($agent);

            $this->get('session')->getFlashBag()->set('notice', 'Agent libéré !');
        }

        return $this->redirectToRoute('campagne_shd_show', array('id' => $agent->getCampagneBrhp()->getId()));
    }

    /**
     * Rattacher un agent à un N+1 : cette action est demandée par le N+1 qui est l'utilisateur connecté.
     *
     * @Security("has_role('ROLE_SHD')")
     */
    public function rattacherShdAction(Request $request, Agent $agent, CampagneBrhp $campagneBrhp, AgentManager $agentManager)
    {
        // Voter
        $this->denyAccessUnlessGranted(AgentVoter::RATTACHER_SHD, ['agent' => $agent, 'campagneBrhp' => $campagneBrhp]);

        $form = $this->createRattacherShdForm($agent->getId(), $campagneBrhp);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /* @var $utilisateur Utilisateur */
            $utilisateur = $this->getUser();

            /* @var $agentRepository AgentRepository */
            $agentRepository = $em->getRepository('AppBundle:Agent');

            /* @var $shd Agent */
            $shd = $agentRepository->getAgentByEmail($utilisateur->getEmail(), $agent->getCampagnePnc());

            $agent->setCampagneBrhp($campagneBrhp);

            $agentManager->rattacherShd($agent, $shd);

            $this->get('session')->getFlashBag()->set('notice', 'Agent ajouté à votre liste !');
        }

        return $this->redirectToRoute('campagne_shd_show', array('id' => $campagneBrhp->getId()));
    }

    /**
     * Détache un agent de son BRHP.
     *
     * @Security("has_role('ROLE_BRHP')")
     */
    public function detacherPerimetreBrhpAction(Request $request, Agent $agent, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::DETACHER_PERIMETRE_BRHP, $agent);

        $form = $this->createDetacherBrhpForm($agent->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $url = $this->generateUrlShowCampagneByRole($agent);

            $agentManager->detacherPerimetreBrhp($agent);

            $this->get('session')->getFlashBag()->set('notice', 'Agent libéré !');
        }

        return $this->redirect($url);
    }

    /**
     * Rattache un agent à son BRHP.
     *
     * @Security("has_role('ROLE_BRHP')")
     */
    public function rattacherPerimetreBrhpAction(Request $request, Agent $agent, CampagneBrhp $campagneBrhp, AgentManager $agentManager)
    {
        //Voters
        $this->denyAccessUnlessGranted(AgentVoter::RATTACHER_PERIMETRE_BRHP, ['agent' => $agent, 'campagneBrhp' => $campagneBrhp]);
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::MODIFIER, $campagneBrhp);

        $form = $this->createRattacherBrhpForm($agent->getId(), $campagneBrhp);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $agentManager->rattacherPerimetreBrhp($agent, $campagneBrhp, $this->getUser());

            $this->get('session')->getFlashBag()->set('notice', 'Agent rattaché !');
        }

        $url = $this->generateUrlShowCampagneByRole($agent);

        return $this->redirect($url);
    }

    /*
     * Générer une url vers show campagne rlc, brhp ou pnc selon le role de l'utilisateur connecté
     */
    private function generateUrlShowCampagneByRole(Agent $agent)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->get('session')->get('selectedRole');

        switch ($roleUtilisateurSession) {
            case 'ROLE_BRHP':
                $idCampagne = $agent->getCampagneBrhp()->getId();

                return $this->generateUrl('campagne_brhp_show', array('id' => $idCampagne));

            case 'ROLE_RLC':
                $idCampagne = $agent->getCampagneRlc()->getId();

                return $this->generateUrl('campagne_rlc_show', array('id' => $idCampagne));

            case 'ROLE_PNC':
                $idCampagne = $agent->getCampagnePnc()->getId();

                return $this->generateUrl('campagne_pnc_show', array('id' => $idCampagne));

            case 'ROLE_SHD':
                $idCampagne = $agent->getCampagneBrhp()->getId();

                return $this->generateUrl('campagne_shd_show', array('id' => $idCampagne));
            case 'ROLE_ADMIN':
                   $idCampagne = $agent->getCampagnePnc()->getId();

                   return $this->generateUrl('campagne_pnc_show', array('id' => $idCampagne));
        }
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function serverProcessingCampagnePncAction(Request $request, CampagnePnc $campagnePnc, $perimetreRlc, $evaluable, $sansShd, $sansPerimetre, $onglet)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR, $campagnePnc);

        switch ($onglet) {
            case 'agents_sans_shd':
                $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'agent.email', 'perimetreRlc.libelle', 'perimetreBrhp.libelle', 'ah.nom', 'ah.prenom'];
                $colonnesTri = ['agent.nom', 'agent.email', 'perimetreRlc.libelle', 'perimetreBrhp.libelle', 'ah.prenom'];
                break;

            case 'population_globale':
                $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'uniteOrganisationnelle.code', 'uniteOrganisationnelle.libelle', 'perimetreRlc.libelle', 'perimetreBrhp.libelle', 'shd.nom', 'shd.prenom', 'ah.nom', 'ah.prenom'];
                $colonnesTri = ['agent.nom', 'perimetreRlc.libelle', 'perimetreBrhp.libelle', 'shd.prenom', 'ah.prenom', 'agent.evaluable', 'crep.statut'];
                break;
        }

        if (0 != $perimetreRlc) {
            $em = $this->getDoctrine()->getManager();
            $perimetreRlc = $em->getRepository('AppBundle:PerimetreRlc')->find($perimetreRlc);
        } else {
            $perimetreRlc = null;
        }

        return $this->serverProcessingCampagne($request, $campagnePnc, $colonnesRecherche, $colonnesTri, $perimetreRlc, $evaluable, $sansShd, $sansPerimetre);
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function serverProcessingCampagneAdminMinAction(Request $request, CampagnePnc $campagnePnc)
    {
    	$this->denyAccessUnlessGranted(CampagnePncVoter::VOIR, $campagnePnc);
    
    	$colonnesTri = ['agent.nom', 'agent.email', 'agent.uniteOrganisationnelle', 'agent.perimetreRlc', 'agent.perimetreBrhp', 'shd.nom', 'ah.nom'];
    	
    	return $this->serverProcessingCampagne($request, $campagnePnc, [], $colonnesTri, null, 2, 0, 0);
    }
    
    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function serverProcessingCampagneRlcAction(Request $request, CampagneRlc $campagneRlc, $evaluable, $sansShd, $sansPerimetre, $onglet)
    {
        $this->denyAccessUnlessGranted(CampagneRlcVoter::VOIR, $campagneRlc);

        switch ($onglet) {
            case 'agents_sans_shd':
                $colonnesTri = ['agent.nom', 'perimetreBrhp.libelle', 'agent.affectation', 'ah.prenom', 'agent.evaluable'];
                break;

            case 'ma_population':
                $colonnesTri = ['agent.nom', 'perimetreBrhp.libelle', 'shd.prenom', 'ah.prenom', 'agent.affectation', 'agent.evaluable', 'crep.statut'];
                break;
        }

        return $this->serverProcessingCampagne($request, $campagneRlc, [], $colonnesTri, null, $evaluable, $sansShd, $sansPerimetre);
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_BRHP') or has_role('ROLE_BRHP_CONSULT')")
     */
    public function serverProcessingCampagneBrhpAction(Request $request, CampagneBrhp $campagneBrhp, $evaluable, $sansShd, $sansPerimetre, $onglet)
    {
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_BRHP, $campagneBrhp);

        $campagneBrhpPourRattachement = null;

        switch ($onglet) {
            case 'ma_population':
                $colonnesTri = ['agent.nom', 'agent.affectation', 'shd.nom', 'ah.nom', 'agent.evaluable', 'agent.statutValidation', 'crep.statut'];
                break;
            case 'agents_sans_perimetre_brhp':
                $colonnesTri = ['agent.nom', 'agent.affectation', 'uniteOrganisationnelle.code', 'shd.prenom', 'ah.prenom'];
                $campagneBrhpPourRattachement = $campagneBrhp;
                break;
            case 'agents_sans_shd':
                $colonnesTri = ['agent.nom', 'agent.affectation', 'ah.prenom'];
                break;
            case 'liste_creps':
                $colonnesTri = ['agent.nom', 'agent.affectation', 'shd.nom', 'ah.prenom', 'crep.statut'];
                break;
        }

        return $this->serverProcessingCampagne($request, $campagneBrhp, [], $colonnesTri, null, $evaluable, $sansShd, $sansPerimetre, null, $campagneBrhpPourRattachement);
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function serverProcessingCampagnePncSansPerimetreAction(Request $request, CampagnePnc $campagnePnc, CampagneRlc $campagneRlc = null, CampagneBrhp $campagneBrhp = null)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR_SANS_PERIMETRE, $campagnePnc);

        $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'agent.email', 'shd.nom', 'shd.prenom', 'ah.nom', 'ah.prenom'];
        $colonnesTri = ['agent.nom', 'agent.email', 'shd.prenom', 'ah.prenom'];

        return $this->serverProcessingCampagne($request, $campagnePnc, $colonnesRecherche, $colonnesTri, null, 2, 0, 1, $campagneRlc, $campagneBrhp);
    }

    private function serverProcessingCampagne(Request $request, Campagne $campagne, array $colonnesRecherche, array $colonnesTri, Perimetre $perimetre = null, $evaluable = 2, $sansShd = 0, $sansPerimetre = 0, $campagneRlcPourRattachement = null, $campagneBrhpPourRattachement = null)
    {
        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $search = $request->get('search')['value'];

        // Dans le cas où c'est une recherche multi filtre et pas une recherche générale
        if (empty($search)) {
            // Récupérer les colonnes du tableau
            $columns = $request->get('columns');

            //On construit un tableau pour stocker seulement les champs des filtres avec leurs valeurs
            $search = array();

            foreach ($columns as $column) {
                //on met dans le tableau que les valeurs non null
                if ($column['search']['value'] != null) {
                    $search[$column['data']] = $column['search']['value'];
                }
            }
        }

        $columnOrder = $request->get('order')[0]['column'];
        $dirOrder = $request->get('order')[0]['dir'];

        /* @var $repository AgentRepository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Agent');
        $agents = $repository->dataTableServerProcessing($campagne, $colonnesRecherche, $colonnesTri, $perimetre, $evaluable, $sansShd, $sansPerimetre, $search, $start, $length, true, $columnOrder, $dirOrder);

        $recordsFiltered = $repository->countAgentsByCampagne($campagne, $colonnesRecherche, $perimetre, $evaluable, $sansShd, $sansPerimetre, $search);

        $recordsTotal = $repository->countAgentsByCampagne($campagne, [], $perimetre, $evaluable, $sansShd, $sansPerimetre);

        $output = array(
                'data' => array(),
                'recordsFiltered' => $recordsFiltered,
                'recordsTotal' => $recordsTotal,
        );

        // pour génrer l'unicité des ID des popups de confirmations des actions
        $uniqid = uniqid().'_'.bin2hex(random_bytes(5));
        /* @var $agent Agent */
        foreach ($agents as $agent) {
            $deleteImportCrepForm = ($agent->getCrep() && $agent->getCrep()->getCrepPapier()) ? $this->createDeleteCrepPapierForm($agent, $this->createFormBuilder())->createView() : null;

            $output['data'][] = [
                    'id' => $agent->getId(),
                    'agent' => htmlspecialchars(Util::identite($agent)),
                    'email' => htmlspecialchars(Util::twig_lower($agent->getEmail())),
                    'perimetreBrhp' => htmlspecialchars($agent->getPerimetreBrhp() ? $agent->getPerimetreBrhp()->getLibelle() : ''),
                    'perimetreRlc' => htmlspecialchars($agent->getPerimetreRlc() ? $agent->getPerimetreRlc()->getLibelle() : ''),
                    'affectation' => htmlspecialchars($agent->getAffectation()),
                    'uniteOrganisationnelle' => htmlspecialchars($agent->getUniteOrganisationnelle() ? $agent->getUniteOrganisationnelle()->getCode().' : '.$agent->getUniteOrganisationnelle()->getLibelle() : ''),
                    'shd' => $agent->getShd() ? htmlspecialchars(Util::identite($agent->getShd())) : $this->render('campagneBrhp/blocsTableauDeBord/onglets/colonnes/agentSansShd.html.twig', array('agent' => $agent))->getContent(),
                    'ah' => $agent->getAh() ? htmlspecialchars(Util::identite($agent->getAh())) : $this->render('campagneBrhp/blocsTableauDeBord/onglets/colonnes/agentSansAh.html.twig', array('agent' => $agent))->getContent(),
                    'evaluable' => $agent->getEvaluable() ? 'Oui' : 'Non',
                    'motif_non_evaluation' => htmlspecialchars($agent->getMotifNonEvaluation()),
                    'MODIFIER' => $this->isGranted(AgentVoter::MODIFIER, $agent),
                    'DETACHER_PERIMETRE_BRHP' => $this->isGranted(AgentVoter::DETACHER_PERIMETRE_BRHP, $agent),
                    'avancement' => $this->render('campagneBrhp/blocsTableauDeBord/onglets/colonnes/avancementStatut.html.twig', array('agent' => $agent))->getContent(),
                    'statutValidation' => $this->render('campagneBrhp/blocsTableauDeBord/onglets/colonnes/statutValidation.html.twig', array('agent' => $agent, 'campagneBrhp' => $campagne))->getContent(),
                    'actions' => $this->render('agent/actionsAgent.html.twig', array(
                                                                                    'agent' => $agent,
                                                                                    'campagneBrhpPourRattachement' => $campagneBrhpPourRattachement,
                                                                                    'campagneRlcPourRattachement' => $campagneRlcPourRattachement,
                                                                                    'uniqid' => $uniqid,
                                                                                    'detacherRlcForm' => $this->createDetacherRlcForm($agent->getId())->createView(),
                                                                                    'rattacherRlcForm' => $campagneRlcPourRattachement ? $this->createRattacherRlcForm($agent->getId(), $campagneRlcPourRattachement)->createView() : null,
                                                                                    'detacherBrhpForm' => $this->createDetacherBrhpForm($agent->getId())->createView(),
                                                                                    'rattacherBrhpForm' => $campagneBrhpPourRattachement ? $this->createRattacherBrhpForm($agent->getId(), $campagneBrhpPourRattachement)->createView() : null,
                                                                                    'rattacherShdForm' => $campagneBrhpPourRattachement ? $this->createRattacherShdForm($agent->getId(), $campagneBrhpPourRattachement)->createView() : null,
                                                                                    ))
                                ->getContent(),
                    'actionImportCrepPapier' => $this->render('crep/actions/actionImportCrepPapier.html.twig', array('agent' => $agent, 'deleteImportCrepForm' => $deleteImportCrepForm))->getContent(),
                    'actionShowCrep' => $this->render('crep/actions/actionShowCrep.html.twig', array('agent' => $agent))->getContent(),
            ];

            unset($agent);
        }

        unset($agents);

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    private function createDetacherRlcForm($id)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('agent_detacher_perimetre_rlc', array('id' => $id)))
                    ->setMethod('PUT')
                    ->getForm();
    }

    private function createDetacherBrhpForm($id)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('agent_detacher_perimetre_brhp', array('id' => $id)))
                    ->setMethod('PUT')
                    ->getForm();
    }

    private function createDetacherShdForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('agent_detacher_shd', array('id' => $id)))
        ->setMethod('PUT')
        ->getForm();
    }

    private function createRattacherRlcForm($id, CampagneRlc $campagneRlc)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('agent_rattacher_perimetre_rlc', array('id' => $id, 'campagneRlc' => $campagneRlc->getId())))
                    ->setMethod('PUT')
                    ->getForm();
    }

    private function createRattacherBrhpForm($id, CampagneBrhp $campagneBrhp)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('agent_rattacher_perimetre_brhp', array('id' => $id, 'campagneBrhp' => $campagneBrhp->getId())))
                    ->setMethod('PUT')
                    ->getForm();
    }

    private function createRattacherShdForm($id, CampagneBrhp $campagneBrhp)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('agent_rattacher_shd', array('id' => $id, 'campagneBrhp' => $campagneBrhp->getId())))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Détache un agent de son RLC.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function detacherPerimetreRlcAction(Request $request, Agent $agent, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::DETACHER_PERIMETRE_RLC, $agent);

        $form = $this->createDetacherRlcForm($agent->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $url = $this->generateUrlShowCampagneByRole($agent);

            $agentManager->detacherPerimetreRlc($agent);

            $this->get('session')->getFlashBag()->set('notice', 'Agent libéré !');
        }

        return $this->redirect($url);
    }

    /**
     * Rattache un agent à son RLC.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function rattacherPerimetreRlcAction(Request $request, Agent $agent, CampagneRlc $campagneRlc, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::RATTACHER_PERIMETRE_RLC, $agent);
        $this->denyAccessUnlessGranted(CampagneRlcVoter::MODIFIER, $campagneRlc);

        $form = $this->createRattacherRlcForm($agent->getId(), $campagneRlc);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $agentManager->rattacherPerimetreRlc($agent, $campagneRlc);

            $this->get('session')->getFlashBag()->set('notice', 'Agent rattaché !');
        }
        $url = $this->generateUrlShowCampagneByRole($agent);

        return $this->redirect($url);
    }

    /*
     * La fonction renvoie au crep de l'agent s'il en a un. Sinon, elle renvoie à un écran demandant au N+1 de choisir un modèle de crep pour l'agent.
     */
    public function checkCrepAgentAction(Request $request, Agent $agent, CrepManager $crepManager, EntityManagerInterface $em)
    {
        if ($agent->getCrep()) {
            return $this->redirectToRoute('crep_show', ['id' => $agent->getCrep()->getId()]);
        }

        if($agent->getModeleCrep()){
        	$crep = $crepManager->creer($agent, $agent->getModeleCrep());
        	
        	$em->persist($crep);
        	$em->flush();
        	
        	return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
        }
        
        // TODO : Afficher un message au N+1 l'invitant à se rapprocher de son BRHP 
        // pour sélectionner le modèlme de CREP de l'agent
        
        $this->denyAccessUnlessGranted(AgentVoter::CHOISIR_CREP, $agent);

        // Si l'agent ne possède pas encore un CREP
        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');

        // Récupérer les modèle de CREP actifs du ministère
        /* @var $modeleCrep  ModeleCrep */
        $modelesCrepMinistere = $modeleCrepRepository->getModelesCrep($ministere, true);

        // Si le ministère a un seul modèle, on initialise un crep pour $agent, et on renvoie vers le show du crep
        if (1 == count($modelesCrepMinistere)) {
            $modeleCrep = $modelesCrepMinistere[0];

            $crep = $crepManager->creer($agent, $modeleCrep);

            $em->persist($crep);
            $em->flush();

            return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
        } else { // Si le ministère a plus de deux modèles, on redirige vers un écran pour en choisir un
            return $this->redirectToRoute('crep_modele_choix', ['id' => $agent->getId()]);
        }
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function serverProcessingAgentsSansPerimetreRlcAction(Request $request, CampagnePnc $campagnePnc, CampagneRlc $campagneRlc)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR_SANS_PERIMETRE, $campagnePnc);

        $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'agent.email', 'uniteOrganisationnelle.libelle', 'uniteOrganisationnelle.code', 'shd.nom', 'shd.prenom', 'ah.nom', 'ah.prenom'];
        $colonnesTri = ['agent.nom', 'agent.email', 'uniteOrganisationnelle.code', 'shd.prenom', 'ah.prenom'];

        return $this->serverProcessingCampagne($request, $campagnePnc, $colonnesRecherche, $colonnesTri, null, 2, 0, 1, $campagneRlc, null);
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_BRHP')")
     */
    public function serverProcessingAgentsSansPerimetreBrhpAction(Request $request, CampagnePnc $campagnePnc, CampagneBrhp $campagneBrhp)
    {
        // Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_BRHP, $campagneBrhp);

        $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'agent.email', 'agent.affectation', 'shd.nom', 'shd.prenom', 'ah.nom', 'ah.prenom'];
        $colonnesTri = ['agent.nom', 'agent.email', 'agent.affectation', 'shd.prenom', 'ah.prenom'];

        return $this->serverProcessingCampagne($request, $campagneBrhp, $colonnesRecherche, $colonnesTri, null, 2, 0, 1, null, $campagneBrhp);
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_SHD')")
     */
    public function serverProcessingCampagneShdAction(Request $request, CampagneBrhp $campagneShd, $evaluable, $sansShd, $sansPerimetre, $onglet)
    {
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_SHD, $campagneShd);

        $colonnesRecherche = ['agent.civilite', 'agent.nom', 'agent.prenom', 'agent.email', 'agent.affectation', 'ah.nom', 'ah.prenom'];
        $colonnesTri = ['agent.nom', 'agent.email', 'agent.affectation', 'ah.prenom'];
        $campagneBrhpPourRattachement = $campagneShd;

        return $this->serverProcessingCampagne($request, $campagneShd, $colonnesRecherche, $colonnesTri, null, $evaluable, $sansShd, $sansPerimetre, null, $campagneBrhpPourRattachement);
    }

    //Return route selon le role
    private function returnRoute($role)
    {
        //Valeur par défaut, si par exemple c'est  admin
        $route = 'campagne_brhp_show';
        switch ($role) {
            case 'ROLE_SHD':
                $route = 'campagne_shd_show';
                break;
            case 'ROLE_AH':
                $route = 'campagne_ah_show';
                break;
            case 'ROLE_BRHP':
                $route = 'campagne_brhp_show';
                break;
        }

        return $route;
    }

    /**
     * Creates a form to delete a Document from Crep entity.
     *
     * @param Crep $crep The Crep entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteCrepPapierForm(Agent $agent, $formBuilder)
    {
        return $formBuilder->setAction($this->generateUrl('agent_delete_crep_papier', array('id' => $agent->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    public function newServerProcessingPncAction(Request $request, CampagnePnc $campagnePnc, $agent_id)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::LISTER_AGENTS, $campagnePnc);

        $search = $request->get('term');

        $em = $this->getDoctrine()->getManager();

        /* @var $agentRepository AgentRepository */
        $agentRepository = $em->getRepository('AppBundle:Agent');

        $evaluateurs = $agentRepository->searchAgent($campagnePnc, $search, $agent_id);

        $data = [];

        /* @var $evaluateur Agent */
        foreach ($evaluateurs as $evaluateur) {
            $data[] = ['id' => $evaluateur['id'], 'text' => $evaluateur['email']];
        }

        $output = ['results' => $data];

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    //*********  Action permettant l'affichage et l'envoie du form d'import CREP*********//
    public function importCrepPapierAction(Request $request, Agent $agent, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::IMPORTER_CREP_PAPIER, $agent);

        // On récupère le role selectionné par l'utilisateur
        $role = $request->getSession()->get('selectedRole');

        // Si l'agent possède déjà un CREP
        if ($agent->getCrep()) {
            $modelesCrep = [$agent->getCrep()->getModeleCrep()];
        }
        // Si l'agent ne possède pas encore un CREP
        // on récupère tous les CREP de son ministere
        else {
            /* @var $ministere Ministere */
            $ministere = $agent->getCampagnePnc()->getMinistere();

            $em = $this->getDoctrine()->getManager();

            /* @var $modeleCrepRepository  ModeleCrepRepository */
            $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');

            // Récupérer les modèle de CREP actifs du ministère
            /* @var $modeleCrep  ModeleCrep */
            $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);
        }

        // Formulaire de chargement du crep Papier
        $importCrepForm = $this->createForm('AppBundle\Form\ImportCrepPapierType', null, ['modelesCrep' => $modelesCrep]);

        $importCrepForm->handleRequest($request);

        if ($importCrepForm->isSubmitted() && $importCrepForm->isValid()) {
            // Récupération des champs du formulaire
            $crepPapier = $importCrepForm->get('crepPapier')->getData();
            $statut = $importCrepForm->get('statut')->getData();
            $modeleCrep = $importCrepForm->get('modeleCrep')->getData();

            $agentManager->ImporterCrepPapier($agent, $crepPapier, $statut, $modeleCrep);

            $this->get('session')->getFlashBag()->set('notice', 'Le CREP a bien été importé !');

            return $this->redirectToRoute($this->returnRoute($role), array('id' => $agent->getCampagneBrhp()->getId()));
        }

        return $this->render('crep/importCrepPapier.html.twig', array(
                'import_crep_form' => $importCrepForm->createView(),
                'agent' => $agent,
        ));
    }

    /**
     * Deletes a Document from CREP entity.
     */
    public function deleteCrepPapierAction(Request $request, Agent $agent)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::SUPPRIMER_CREP_PAPIER, $agent);

        //On appel la méthode de suppression du document d'un crep
        $form = $this->createDeleteCrepPapierForm($agent, $this->createFormBuilder());
        $form->handleRequest($request);

        // On récupère le role selectionné par l'utilisateur
        // FIXME: Not use the session because the value of session can change in future
        $role = $request->getSession()->get('selectedRole');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //On remet le statut crep à "l'ancien statut avant import"
            $statutCrepAvantImport = $agent->getCrep()->getStatutCrepAvantImport();
            if ($statutCrepAvantImport) {
                $agent->getCrep()->setStatut($statutCrepAvantImport);
                //On supprime le document liée
                $document = $agent->getCrep()->getCrepPapier();
                $agent->getCrep()->setCrepPapier(null);

                $em->remove($document);
            } else {
                $crep = $agent->getCrep();
                $agent->setCrep(null);

                $em->remove($crep);
            }

            // Suppression de tous les recours liés au crep
            foreach ($agent->getCrep()->getRecours() as $recours) {
                $em->remove($recours);
            }

            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Le CREP papier de l\'agent "'.$agent->getPrenom().' '.$agent->getNom().'" a bien été supprimé !');
        }

        return $this->redirectToRoute($this->returnRoute($role), array('id' => $agent->getCampagneBrhp()->getId()));
    }

    public function getDocumentAction(Request $request, Agent $agent, Document $document, DocumentManager $documentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::VOIR, $agent);

        if (!$agent->getDocuments()->contains($document)) {
            throw new AccessDeniedHttpException();
        }

        return $documentManager->getDocument($document);
    }

    public function deleteDocumentAction(Request $request, Agent $agent, Document $document, DocumentManager $documentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::MODIFIER, $agent);

        if (!$agent->getDocuments()->contains($document)) {
            throw new AccessDeniedHttpException();
        }

        $documentManager->deleteDocuments([$document], true);

        $this->get('session')->getFlashBag()->set('notice', 'Document supprimé !');

        return $this->redirectToRoute('agent_show', ['id' => $agent->getId()]);
    }

    private function creerDeleteDocumentsForms(Agent $agent)
    {
        $deleteForms = [];
        foreach ($agent->getDocuments() as $document) {
            if ($document->getId()) {
                $deleteForms[] = $this->createFormBuilder()
                ->setAction($this->generateUrl('agent_delete_document', [
                    'id' => $agent->getId(),
                    'document' => $document->getId(),
                    ]))
                ->setMethod('DELETE')
                ->getForm()->createView();
            }
        }

        return $deleteForms;
    }
}
