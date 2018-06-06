<?php

namespace AppBundle\Controller;

use AppBundle\Security\CampagnePncVoter;
use AppBundle\Service\CampagnePncManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\UploadeDocument;
use AppBundle\Service\ImportCsv;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Service\DocumentManager;
use AppBundle\Service\AgentManager;

/**
 * CampagneAdminMin controller.
 */
class CampagneAdminMinController extends Controller
{
    /**
     * Lists all CampagnePnc entities.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser();

        $campagnesPnc = $em->getRepository('AppBundle:CampagnePnc')->findCampagnesRecentesAdminMin($utilisateur);

        return $this->render('campagneAdminMin/index.html.twig', array(
            'campagnePncs' => $campagnesPnc,
        ));
    }

    /**
     * Finds and displays a CampagnePnc entity.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function showAction(CampagnePnc $campagnePnc, Request $request)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR, $campagnePnc);

        $repository = $this->getDoctrine()->getRepository('AppBundle:Agent');
        $nbAgents = $repository->countAgentsByCampagne($campagnePnc);

        if (0 == $nbAgents) {
            return $this->redirectToRoute('campagne_admin_min_charger_population', ['id' => $campagnePnc->getId()]);
        }

        $supprimerPopulationForm = $this->creerSupprimerPopulationForm($campagnePnc);
        $diffuserPopulationForm = $this->creerDiffuserPopulationForm($campagnePnc);

        $template = 'campagneAdminMin/show.html.twig';

        return $this->render($template, array(
            'campagnePnc' => $campagnePnc,
            'supprimerPopulationForm' => $supprimerPopulationForm->createView(),
            'diffuserPopulationForm' => $diffuserPopulationForm->createView(),
            'nbAgents' => $nbAgents,
        ));
    }

    /**
     * Charge le fichier de population.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function chargerPopulationAction(CampagnePnc $campagnePnc, Request $request, ImportCsv $importCsv)
    {
        $uploadeDocument = new UploadeDocument();
        $uploadForm = $this->createForm('AppBundle\Form\UploadeDocumentType', $uploadeDocument, ['validation_groups' => ['Default', 'injection_referentiel']]);
        $uploadForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            //try {

            $em->persist($uploadeDocument);
            $campagnePnc->setDocPopulation($uploadeDocument);
            // le flush est indispensable pour pouvoir ouvrir le fichier uploadé
            $em->flush();

            // on utilise le service pour l'import d'un fichier csv//
            $resultatLecture = $importCsv->importerPopulation($campagnePnc);

            if (true !== $resultatLecture) {
                $campagnePnc->setDocPopulation(null);
                $em->remove($uploadeDocument);
                $em->flush();

                return $this->render('campagneAdminMin/compteRenduErreurs.html.twig', array(
                        'resultatLecture' => $resultatLecture,
                    ));
            }

            $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', 'Votre fichier est en cours de chargement, vous serez notifié par mail à la fin du chargement !')
                ;

            return $this->redirectToRoute('campagne_admin_min_index');
        }

        $template = 'campagneAdminMin/upload.html.twig';

        $maquette = $this->getMaquetteByMinistere($this->getUser());

        return $this->render($template, array(
            'campagnePnc' => $campagnePnc,
            'form' => $uploadForm->createView(),
            'maquette' => $maquette,
        ));
    }

    private function getMaquetteByMinistere(Utilisateur $utilisateur)
    {
        switch ($utilisateur->getMinistere()->getId()) {
            case 3: // Pour le MCC
                $maquette = 'Maquettes/PopulationGlobale/PopulationGlobaleMcc.csv';
                break;
            default: // Pour les autres ministères
                $maquette = 'Maquettes/PopulationGlobale/PopulationGlobale.csv';
                break;
        }

        return $maquette;
    }

    /**
     * Supprimer l'ensemble de la population d'une campagne.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     *
     * @param CampagnePnc $campagnePnc
     */
    public function supprimerPopulationAction(Request $request, CampagnePnc $campagnePnc, DocumentManager $documentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::SUPPRIMER_POPULATION, $campagnePnc);

        $form = $this->creerSupprimerPopulationForm($campagnePnc);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // supprimer les agents de la campagne
            $em->getRepository('AppBundle:Agent')->deleteAgentByCampagnePnc($campagnePnc);

            /* @var $document Document */
            $document = $campagnePnc->getDocPopulation();

            if ($document) {
                $documentManager->deleteDocuments(array($document));
            }

            $campagnePnc->setDocPopulation(null);

            $em->persist($campagnePnc);
            $em->flush();

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Votre population a été supprimée avec succès !')
            ;

            return $this->redirectToRoute('campagne_admin_min_show', array('id' => $campagnePnc->getId()));
        }

        $this->get('session')
        ->getFlashBag()
        ->set('notice', 'Echec de la suppression de la population !')
        ;

        // si le formulaire n'est pas valide : Renvoyer vers le show de la liste
        return $this->redirectToRoute('campagne_admin_min_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * Génére le formulaire de difusion de la population de la campagne.
     *
     * @param CampagnePnc $campagnePnc
     *                                 L'entité campagne
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerDiffuserPopulationForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_admin_min_diffuser_population', array(
            'id' => $campagnePnc->getId(),
        )))
            ->setMethod('PUT')
            ->getForm();
    }

    /**
     * Générer le formulaire de suppression de la population.
     *
     * @param CampagnePnc $campagnePnc L'entité campagne
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerSupprimerPopulationForm(CampagnePnc $campagnePnc)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('campagne_admin_min_supprimer_population', array('id' => $campagnePnc->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Diffuser l'ensemble de la population d'une campagne.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     *
     * @param CampagnePnc $campagnePnc
     */
    public function diffuserPopulationAction(CampagnePnc $campagnePnc, Request $request, CampagnePncManager $campagnePncManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::DIFFUSER_POPULATION, $campagnePnc);

        $form = $this->creerDiffuserPopulationForm($campagnePnc);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $campagnePncManager->diffuser($campagnePnc);

            $this->get('session')->getFlashBag()->set('notice', 'Votre population a été diffusée avec succès !');

            return $this->redirectToRoute('campagne_admin_min_show', array('id' => $campagnePnc->getId()));
        }

        $this->get('session')->getFlashBag()->set('notice', 'Echec de diffusion de la population !');

        // si le formulaire n'est pas valide : Renvoyer vers le show de la liste
        return $this->redirectToRoute('campagne_admin_min_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * retourne le fichier de population d'une campagne.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     *
     * @param CampagnePnc $campagnePnc
     */
    public function getFichierPopulationAction(CampagnePnc $campagnePnc, Request $request)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::CONSULTER_FICHIER_POPULATION, $campagnePnc);

        $document = $campagnePnc->getDocPopulation();

        $response = new Response(file_get_contents($document->getAbsolutePath()));

        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getNom());
        $response->headers->set('Content-Type', 'application/excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Set-Cookie', 'fileDownload=true; path=/');

        return $response;
    }

    /**
     * Extrait les données Agents d'une campagne PNC au même format que le fichier de population globale.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     *
     * @param CampagnePnc $campagnePnc
     */
    public function getFichierAgentsDepuisAgentAction(CampagnePnc $campagnePnc, Request $request, AgentManager $agentManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::EXTRAIRE_DONNEES_AGENTS, $campagnePnc);

        $fichier = $agentManager->exporterFichierAgents($campagnePnc);

        $response = new Response(file_get_contents($fichier));

        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Extraction_donnees_agents.csv');
        $response->headers->set('Content-Type', 'application/excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Set-Cookie', 'fileDownload=true; path=/');

        return $response;
    }
}
