<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\CampagneBrhp;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\CampagneBrhpManager;
use AppBundle\Repository\AgentRepository;
use AppBundle\Entity\Agent;
use AppBundle\Security\CampagneBrhpVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Service\CrepManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Form\RechercheCampagneBrhpType;

class CampagneBrhpController extends Controller
{
    /**
     * Lists all CampagneBrhp entities.
     *
     * @Security("has_role('ROLE_BRHP') or has_role('ROLE_BRHP_CONSULT')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $campagnesBrhp = $em->getRepository('AppBundle:CampagneBrhp')->findCampagnesRecentesBrhp($this->getUser(), $this->get('session')->get('selectedRole'));

        return $this->render('campagneBrhp/index.html.twig', array(
            'campagnesBrhp' => $campagnesBrhp,
        ));
    }

    /**
     * Displays a form to edit an existing CampagneBrhp entity.
     *
     * @Security("has_role('ROLE_BRHP')")
     */
    public function editAction(Request $request, CampagneBrhp $campagneBrhp, CampagneBrhpManager $campagneBrhpManager)
    {
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::MODIFIER, $campagneBrhp);

        $campagneBrhp->getDocuments()->toArray(); // cette ligne est indspensable pour que le clone se fasse correctement
        $anciensDocuments = clone $campagneBrhp->getDocuments();

        $editForm = $this->createForm('AppBundle\Form\CampagneBrhpType', $campagneBrhp);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Les anciens de documents ne figurent pas dans le formulaire,
            //il faut les rajouter à l'entité sinon ils sont écrasés
            foreach ($anciensDocuments as $ancienDocument) {
                $campagneBrhp->addDocument($ancienDocument);
            }

            $campagneBrhpManager->sauvegarder($campagneBrhp);
            $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', 'Campagne Brhp \"'.$campagneBrhp->getLibelle().'\" mise à jour avec succès !')
            ;

            return $this->redirectToRoute('campagne_brhp_show', array('id' => $campagneBrhp->getId()));
        }

        if ($editForm->isSubmitted() && !$editForm->isValid()) {
            foreach ($anciensDocuments as $ancienDocument) {
                $campagneBrhp->addDocument($ancienDocument);
            }
        }
        $deleteForms = $this->createDeleteDocumentForms($campagneBrhp);

        return $this->render('campagneBrhp/edit.html.twig', array(
                'campagneBrhp' => $campagneBrhp,
                'form' => $editForm->createView(),
                'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Rediriger l'utilisateur vers la vue appropriée selon le statut de la campagne.
     * @param $campagneBrhp CampagneBrhp
     * @Security("has_role('ROLE_BRHP') or has_role('ROLE_BRHP_CONSULT')")
     */
    public function showAction(CampagneBrhp $campagneBrhp, Request $request, CrepManager $crepManager, CampagneBrhpManager $campagneBrhpManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::VOIR_BRHP, $campagneBrhp);

        $em = $this->getDoctrine()->getManager();

        /*@var $agentRepository AgentRepository */
        $agentRepository = $em->getRepository('AppBundle:Agent');

        $agentsEvaluables = $agentRepository->getAgentsEvaluables($campagneBrhp);

        $historiqueIndicateurs = $campagneBrhpManager->getHistoriqueIndicateurs($campagneBrhp);

        $rouvrirForm = $this->creerRouvrirForm($campagneBrhp);
        $envoyerForm = $this->ouvrirShdForm($campagneBrhp);
        $rechercheForm = $this->creerRechercheForm($campagneBrhp);
        $rechercheForm->handleRequest($request);

        $categories = [];
        $affectations = [];
        $corps = [];

        if ($rechercheForm->isSubmitted() && $rechercheForm->isValid()) {
            $categories = $rechercheForm->getData()['categories'];
            $affectations = $rechercheForm->getData()['affectations'];
            $corps = $rechercheForm->getData()['corps'];
        }

        $indicateurs = $crepManager->calculIndicateurs($campagneBrhp, [], [], null, null, $categories, $affectations, $corps);

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        $template = 'campagneBrhp/show.html.twig';

        return $this->render($template, array(
            'campagneBrhp' => $campagneBrhp,
            'indicateurs' => $indicateurs,
            'historiqueIndicateurs' => $historiqueIndicateurs,
            'rouvrir_form' => $rouvrirForm->createView(),
            'envoyer_form' => $envoyerForm->createView(),
            'recherche_form' => $rechercheForm->createView(),
            'agentsEvaluables' => $agentsEvaluables,
            'modelesCrep' => $modelesCrep,
        ));
    }

    /**
     * Crée le formulaire de réouverture de la CampagneBrhp.
     *
     * @param CampagneRlc $campagneBrhp
     *                                  L'entité CampagneBrhp
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerRouvrirForm(CampagneBrhp $campagneBrhp)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('campagne_brhp_rouvrir', array(
                'id' => $campagneBrhp->getId(),
        )))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Rouvre une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_BRHP')")
     */
    public function rouvrirAction(Request $request, CampagneBrhp $campagneBrhp, CampagneBrhpManager $campagneBrhpManager)
    {
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::ROUVRIR, $campagneBrhp);

        $form = $this->creerRouvrirForm($campagneBrhp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si c'est un environnement windows (local), on clôture la campagne et envoie les notifications directement
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $campagneBrhpManager->rouvrir($campagneBrhp);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui clôture la campagne et envoie des notifications.
                $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/rouvrir_campagne_brhp.sh '.$campagneBrhp->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
                exec($commande);
                // Afin d'éviter d'avoir une vue non à jour
                // on laisse 2 secondes pour que la cloture se fasse avant d'appeler la vue
                sleep(2);
            }

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne BRHP \"'.$campagneBrhp->getLibelle().'\" rouverte avec succès !');

            return $this->redirectToRoute('campagne_brhp_show', array('id' => $campagneBrhp->getId()));
        }

        return $this->redirectToRoute('campagne_brhp_show', array('id' => $campagneBrhp->getId()));
    }

    /**
     * Ouvrir la campagne Brhp aux N+1.
     *
     * @Security("has_role('ROLE_BRHP')")
     *
     * @param CampagneBrhp $campagneBrhp
     */
    public function ouvrirShdAction(Request $request, CampagneBrhp $campagneBrhp, CampagneBrhpManager $campagneBrhpManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::OUVRIR_SHD, $campagneBrhp);

        $form = $this->ouvrirShdForm($campagneBrhp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si c'est un environnement windows (local), on ouvre la campagne et envoie les notifications directement
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $campagneBrhpManager->ouvrirShd($campagneBrhp);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui ouvre la campagne et envoie des notifications.
                $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/ouvrir_campagne_shd.sh '.$campagneBrhp->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
                exec($commande);
                // Afin d'éviter d'avoir une vue non à jour
                // on laisse 2 secondes pour que la cloture se fasse avant d'appeler la vue
                sleep(2);
            }

            $this
            ->get('session')
            ->getFlashBag()
            ->set('notice', 'La campagne \"'.$campagneBrhp->getLibelle().'\" a bien été ouverte aux N+1 !')
            ;
        }

        return $this->redirectToRoute('campagne_brhp_index');
    }

    /**
     * Générer le formulaire d' envoi de l'ensemble des listes d'une campagne.
     *
     * @param CampagneBrhp $campagneBrhp L'entité campagne
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function ouvrirShdForm(CampagneBrhp $campagneBrhp)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('campagne_brhp_ouvrir_shd', array('id' => $campagneBrhp->getId())))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    private function createDeleteDocumentForms(CampagneBrhp $campagneBrhp)
    {
        $deleteDocumentForms = array();
        foreach ($campagneBrhp->getDocuments() as $document) {
            $deleteDocumentForms[] = $this
            ->createFormBuilder()
            ->setAction($this->generateUrl('campagne_brhp_delete_document', array('id' => $campagneBrhp->getId(), 'id_document' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()->createView();
        }

        return $deleteDocumentForms;
    }

    /**
     * @ParamConverter("document", options={"id" = "id_document"})
     * @Security("has_role('ROLE_BRHP')")
     */
    public function deleteDocumentAction(CampagneBrhp $campagneBrhp, Document $document)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::SUPPRIMER_DOCUMENT, $campagneBrhp);

        $em = $this->getDoctrine()->getManager();
        foreach ($campagneBrhp->getDocuments() as $doc) {
            if ($doc === $document) {
                $campagneBrhp->removeDocument($doc);
                $em->remove($document);
            }
        }

        $em->flush();

        return $this->redirectToRoute('campagne_brhp_edit', array('id' => $campagneBrhp->getId()));
    }

    /**
     * Exporte les formation en un fichier CSV.
     *
     * @Security("has_role('ROLE_BRHP') or has_role('ROLE_BRHP_CONSULT')")
     *
     * @param CampagneBrhp $campagneBrhp
     */
    public function exporterFormationsAction(CampagneBrhp $campagneBrhp, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::EXPORTER_FORMATIONS, $campagneBrhp);

        $zip = $crepManager->exporterFormations($campagneBrhp);

        $response = new Response(file_get_contents($zip));

        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Export_Formaions.zip');
        $response->headers->set('Content-Type', 'application/zip; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Set-Cookie', 'fileDownload=true; path=/');

        return $response;
    }

    /**
     * Exporter l'ensemble des CREPs finalisés.
     *
     * @param CampagneBrhp $campagneBrhp
     */
    public function exporterCrepsFinalisesAction(Request $request, CampagneBrhp $campagneBrhp, CrepManager $crepManager)
    {
        // Voter
        $this->denyAccessUnlessGranted(CampagneBrhpVoter::EXPORTER_CREPS_FINALISES, $campagneBrhp);

        // On récupère le rôle selectionné par l'utilisateur
        $role = $request->getSession()->get('selectedRole');

        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Agent');

        //l'avaluateur est soit le N+1 ou le N+2
        $evaluateur = $agentRepository->getAgentByEmail($this->getUser()->getEmail(), $campagneBrhp->getCampagnePnc());

        //On récupère l'ensemble des agents ayant un CREP finalisé pour un rôle (BRHP, N+1 ou N+2) donné
        $agentsAyantCrepFinalise = $agentRepository->getAgentsAyantCrepFinalise($campagneBrhp, $role, $evaluateur);

        return $crepManager->exporterCrepsFinalises($agentsAyantCrepFinalise);
    }

    /**
     * Crée le formulaire de recherche sur une CampagneBrhp.
     *
     * @param CampagneBrhp $campagneBrhp
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerRechercheForm(CampagneBrhp $campagneBrhp)
    {
        return $this->createForm(RechercheCampagneBrhpType::class, null, array(
                'campagneBrhp' => $campagneBrhp,
                'em' => $this->getDoctrine()->getManager(),
        ));
    }
    
    /**
     * Exporter l'ensemble de la population
     *
     * @param CampagneBrhp $campagneBrhp
     *
     * @Security("has_role('ROLE_BRHP') or has_role('ROLE_BRHP_CONSULT')")
     */
    public function exporterPopulationAction(Request $request, CampagneBrhp $campagneBrhp, CampagneBrhpManager $campagneBrhpManager)
    {
    	// Voter
    	$this->denyAccessUnlessGranted(CampagneBrhpVoter::EXPORTER_POPULATION, $campagneBrhp);
    
    	return $campagneBrhpManager->exporterPopulation($campagneBrhp);
    }
}
