<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PerimetreRlc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Security\CampagnePncVoter;
use AppBundle\Service\CampagnePncManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Service\CrepManager;

/**
 * CampagnePnc controller.
 */
class CampagnePncController extends Controller
{
    /**
     * Lists all CampagnePnc entities.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser();

        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            $campagnesPnc = $em->getRepository('AppBundle:CampagnePnc')->findAll();
        } else {
            $campagnesPnc = $em->getRepository('AppBundle:CampagnePnc')->findCampagnesRecentes($utilisateur);
        }

        $deleteForms = null;

        if ($campagnesPnc) {
            $deleteForms = $this->createDeleteForms($campagnesPnc);
        }

        return $this->render('campagnePnc/index.html.twig', array(
            'campagnePncs' => $campagnesPnc,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new CampagnePnc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function newAction(Request $request)
    {
        $campagnePnc = new CampagnePnc();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();
        $campagnePnc->setMinistere($utilisateur->getMinistere());
        $campagnePnc->setStatut(EnumStatutCampagne::CREEE);

        $form = $this->createForm('AppBundle\Form\CampagnePncType', $campagnePnc, array(
            'utilisateur' => $utilisateur,
            'campagnePnc' => $campagnePnc,
            'validation_groups' => ['Default', 'creation'],
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $campagnePncManager CampagnePncManager */
            $campagnePncManager = $this->get('app.campagne_pnc_manager');

            $campagnePnc = $campagnePncManager->verfierDocuments($campagnePnc);

            $flashbagMessage = 'Campagne PNC \"'.$campagnePnc->getLibelle().'\" créée !';

            $campagnePncManager->sauvegarder($campagnePnc);

            $this->get('session')
                ->getFlashBag()
                ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('campagne_pnc_show', array(
                'id' => $campagnePnc->getId(),
            ));
        }

        return $this->render('campagnePnc/new.html.twig', array(
            'campagnePnc' => $campagnePnc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CampagnePnc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function showAction(CampagnePnc $campagnePnc, Request $request)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR, $campagnePnc);
        $em = $this->getDoctrine()->getManager();

        //On récupère l'id du périmètre donnée en parametre depuis le tableau de bord
        $perimetreId = $request->attributes->get('id_perimetre');
        $perimetre = null;
        if ($perimetreId > 0) {
            $perimetre = $em->getRepository('AppBundle:PerimetreRlc')->find($perimetreId);

            //si le périmetre n'existe pas, on déclenche une erreur
            if (!$perimetre) {
                throw $this->createNotFoundException(
                'Aucun périmètre trouvé !'
                );
            }
        }

        $cloturerForm = $this->creerCloturerForm($campagnePnc);
        $rouvrirForm = $this->creerRouvrirForm($campagnePnc);
        $fermerForm = $this->creerFermerForm($campagnePnc);
        $deleteForm = $this->createDeleteForm($campagnePnc);
        $ouvrirForm = $this->creerOuvrirForm($campagnePnc);

        $nbAgents = $this->getDoctrine()->getRepository('AppBundle:Agent')->countAgentsByCampagne($campagnePnc);

        /*@var $crepManager CrepManager */
        $crepManager = $this->get('app.crep_manager');
        $indicateurs = $crepManager->calculIndicateurs($campagnePnc, $perimetre);

        /*@var $campagnePncManager CampagnePncManager */
        $campagnePncManager = $this->get('app.campagne_pnc_manager');
        $historiqueIndicateurs = $campagnePncManager->getHistoriqueIndicateurs($campagnePnc);

        //On redirige vers la vue tableau de bord que si le fichier d'agents a été diffusé par l'admin ministériel
        if ($campagnePnc->getDiffusee() && !in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE,
           ))) {
            $template = 'campagnePnc/tableauDeBord.html.twig';
        } else {
            $template = 'campagnePnc/show.html.twig';
        }

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        return $this->render($template, array(
            'campagnePnc' => $campagnePnc,
            'ouvrir_form' => $ouvrirForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'cloturer_form' => $cloturerForm->createView(),
            'rouvrir_form' => $rouvrirForm->createView(),
            'fermer_form' => $fermerForm->createView(),
            'nbAgents' => $nbAgents,
            'indicateurs' => $indicateurs,
            'historiqueIndicateurs' => $historiqueIndicateurs,
            'perimetre' => $perimetre,
            'modelesCrep' => $modelesCrep,
        ));
    }

    /**
     * Displays a form to edit an existing CampagnePnc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function editAction(Request $request, CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::MODIFIER, $campagnePnc);

        $anciensDocuments = clone $campagnePnc->getDocuments();
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();
        //$campagnePnc->setMinistere($utilisateur->getMinistere());

        $collectionPerimetresRlc = new ArrayCollection();
        foreach ($campagnePnc->getPerimetresRlc() as $perimetreRlc) {
            $collectionPerimetresRlc->add($perimetreRlc);
        }

        $deleteForm = $this->createDeleteForm($campagnePnc);
        $editForm = $this->createForm('AppBundle\Form\CampagnePncType', $campagnePnc, array(
            'utilisateur' => $utilisateur,
            'campagnePnc' => $campagnePnc,
            'validation_groups' => ['Default', 'modification'],
        ));

        $editForm->handleRequest($request);

        $deleteForms = $this->createDeleteDocumentForms($campagnePnc);

        /** @var CampagnePnc $campagnePncDuFormulaire */
        $campagnePncDuFormulaire = $editForm->getData();

        if (EnumStatutCampagne::OUVERTE === $campagnePnc->getStatut()) {
            /** @var PerimetreRlc $perimetreRlc */
            foreach ($collectionPerimetresRlc as $perimetreRlc) {
                if (!$campagnePncDuFormulaire->getPerimetresRlc()->contains($perimetreRlc)) {
                    $editForm->get('perimetresRlc')->addError(new FormError(
                        'Le périmètre "'.$perimetreRlc->getLibelle().'" ne peut pas être supprimé.'
                    ));
                }
            }
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Les anciens de documents ne figurent pas dans le formulaire,
            //il faut les rajouter à l'entité sinon ils sont écrasés
            foreach ($anciensDocuments as $ancienDocument) {
                $campagnePnc->addDocument($ancienDocument);
            }

            /* @var $campagnePncManager CampagnePncManager */
            $campagnePncManager = $this->get('app.campagne_pnc_manager');

            $campagnePnc = $campagnePncManager->verfierDocuments($campagnePnc);

            $nouveauxPerimetresRlc = array_diff(
               $campagnePncDuFormulaire->getPerimetresRlc()->getValues(),
               $collectionPerimetresRlc->getValues()
            );

            if (EnumStatutCampagne::OUVERTE === $campagnePnc->getStatut() && $nouveauxPerimetresRlc) {
                $nouveauxPerimetresRlc = array_values($nouveauxPerimetresRlc);
                $collectionNouveauxPerimetresRlc = new ArrayCollection($nouveauxPerimetresRlc);
                $campagnePncManager->ouvrirNouveauxPerimetres($campagnePnc, $collectionNouveauxPerimetresRlc);
            }

            $campagnePncManager->sauvegarder($campagnePnc);

            $this
                ->get('session')
                ->getFlashBag()
                ->set(
                    'notice',
                    'Campagne PNC \"'.$campagnePnc->getLibelle().'\" mise à jour avec succès !'
            );

            return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
        }

        return $this->render('campagnePnc/edit.html.twig', array(
            'campagnePnc' => $campagnePnc,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Deletes a CampagnePnc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function deleteAction(Request $request, CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::SUPPRIMER, $campagnePnc);

        $form = $this->createDeleteForm($campagnePnc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($campagnePnc);
            $em->flush();
        }

        return $this->redirectToRoute('campagne_pnc_index');
    }

    /**
     * Ouvre une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_PNC')")
     */
    public function ouvrirAction(CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::OUVRIR, $campagnePnc);

        /* @var $campagnePncManager CampagnePncManager */
        $campagnePncManager = $this->get('app.campagne_pnc_manager');

        // Si c'est un environnement windows (local), on ouvre la campagne et envoie les notifications directement
        if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            $campagnePncManager->ouvrir($campagnePnc);
        } else { // Si c'est un environnement linux, on lance un script en arrière plan qui ouvre la campagne et envoie des notifications.
            $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/ouvrir_campagne_pnc.sh '.$campagnePnc->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
            exec($commande);
            // Afin d'éviter d'avoir une vue non à jour
            // on laisse 2 secondes pour que la cloture se fasse avant d'appeler la vue
            sleep(2);
        }

        $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne PNC \"'.$campagnePnc->getLibelle().'\" ouverte !');

        return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * Cloture une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_PNC')")
     */
    public function cloturerAction(Request $request, CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::CLOTURER, $campagnePnc);

        $form = $this->creerCloturerForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $campagnePncManager CampagnePncManager */
            $campagnePncManager = $this->get('app.campagne_pnc_manager');

            // Si c'est un environnement windows (local), on clôture la campagne et envoie les notifications directement
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $campagnePncManager->cloturer($campagnePnc);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui clôture la campagne et envoie des notifications.
                $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/cloturer_campagne_pnc.sh '.$campagnePnc->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
                exec($commande);
                // Afin d'éviter d'avoir une vue non à jour
                // on laisse deux secondes pour que la cloture se fasse avant d'appeler la vue
                sleep(2);
            }

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne PNC \"'.$campagnePnc->getLibelle().'\" cloturée avec succès !');

            return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
        }

        return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * Rouvre une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_PNC')")
     */
    public function rouvrirAction(Request $request, CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::ROUVRIR, $campagnePnc);

        $form = $this->creerRouvrirForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $campagnePncManager CampagnePncManager */
            $campagnePncManager = $this->get('app.campagne_pnc_manager');

            // Si c'est un environnement windows (local), on rouvre la campagne et envoie les notifications directement
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $campagnePncManager->rouvrir($campagnePnc);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui rouvre la campagne et envoie des notifications.
                $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/rouvrir_campagne_pnc.sh '.$campagnePnc->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
                exec($commande);
                // Afin d'éviter d'avoir une vue non à jour
                // on laisse 2 secondes pour que la cloture se fasse avant d'appeler la vue
                sleep(2);
            }

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne PNC \"'.$campagnePnc->getLibelle().'\" rouverte avec succès !');

            return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
        }

        return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * Fermer une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_PNC')")
     */
    public function fermerAction(Request $request, CampagnePnc $campagnePnc)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::FERMER, $campagnePnc);

        $form = $this->creerFermerForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $campagnePncManager CampagnePncManager */
            $campagnePncManager = $this->get('app.campagne_pnc_manager');

            // Si c'est un environnement windows (local), on ferme la campagne et envoie les notifications directement
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $campagnePncManager->fermer($campagnePnc);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui ferme la campagne et envoie des notifications.
                $commande = 'nohup '.$this->getParameter('app.rep_scripts').'/fermer_campagne_pnc.sh '.$campagnePnc->getId().' '.$this->getUser()->getId().' >/dev/null 2>&1  &';
                exec($commande);
                // Afin d'éviter d'avoir une vue non à jour
                // on laisse une seconde pour que la cloture se fasse avant d'appeler la vue
                sleep(2);
            }

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne PNC \"'.$campagnePnc->getLibelle().'\" fermée avec succès !');

            return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
        }

        return $this->redirectToRoute('campagne_pnc_show', array('id' => $campagnePnc->getId()));
    }

    /**
     * Creates a form to delete a CampagnePnc entity.
     *
     * @param CampagnePnc $campagnePnc
     *                                 The CampagnePnc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_pnc_delete', array(
            'id' => $campagnePnc->getId(),
        )))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Crée un tableau de formulaires de suppression des campagnes PNC.
     *
     * @param
     *            Collection CampagnePnc $campagnesPncs Les campagnes PNCs
     *
     * @return array
     */
    private function createDeleteForms($campagnesPncs)
    {
        $deleteForms = [];

        foreach ($campagnesPncs as $campagnesPnc) {
            $deleteForms[] = $this->createDeleteForm($campagnesPnc)->createView();
        }

        return $deleteForms;
    }

    /**
     * Génére le formulaire d'ouverture de campagne.
     *
     * @param CampagnePnc $campagnePnc
     *                                 L'entité campagne
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerOuvrirForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_pnc_ouvrir', array(
            'id' => $campagnePnc->getId(),
        )))
            ->setMethod('PUT')
            ->getForm();
    }

    private function createDeleteDocumentForms(CampagnePnc $campagnePnc)
    {
        $deleteDocumentForms = array();

        foreach ($campagnePnc->getDocuments() as $document) {
            $deleteDocumentForms[] = $this
            ->createFormBuilder()
            ->setAction($this->generateUrl('campagne_pnc_delete_document', array('id' => $campagnePnc->getId(), 'id_document' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()->createView();
        }

        return $deleteDocumentForms;
    }

//     /**
//      * Methode qui retourne le document d'une campagnePnc
//      * @param CampagnePnc $campagnePnc
//      * @param integer $index_document
//      */
//     public function getDocumentAction(CampagnePnc $campagnePnc, $index_document)
//     {
//     	//Voter
//     	$this->denyAccessUnlessGranted(CampagnePncVoter::CONSULTER_DOCUMENT, $campagnePnc);

//     	$document = $campagnePnc->getDocuments()->get($index_document) ? $campagnePnc->getDocuments()->get($index_document) : null;

//     	if($document){
//     		return $this->redirect($this->generateUrl('get_file', array(
//     				'id' => $document->getId(),
//     				'checksum' => $document->getChecksum(),
//     		)));
//     	}
//     	throw $this->createNotFoundException('Le document n° '.$index_document. ' n\'existe pas dans la campagne n° '.$campagnePnc->getId());

//     }

    /**
     * @ParamConverter("document", options={"id" = "id_document"})
     * @Security("has_role('ROLE_PNC')")
     */
    public function deleteDocumentAction(CampagnePnc $campagnePnc, Document $document)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagnePncVoter::SUPPRIMER_DOCUMENT, $campagnePnc);

        $em = $this->getDoctrine()->getManager();
        foreach ($campagnePnc->getDocuments() as $doc) {
            if ($doc === $document) {
                $campagnePnc->removeDocument($doc);
                $em->remove($document);
            }
        }

        $em->flush();

        return $this->redirectToRoute('campagne_pnc_edit', array('id' => $campagnePnc->getId()));
    }

    /**
     * Crée le formulaire de cloture de la CampagnePnc.
     *
     * @param CampagnePnc $campagnePnc
     *                                 L'entité CampagnePnc
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerCloturerForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('campagne_pnc_cloturer', array(
            'id' => $campagnePnc->getId(),
        )))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Crée le formulaire de réouverture de la CampagnePnc.
     *
     * @param CampagnePnc $campagnePnc
     *                                 L'entité CampagnePnc
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerRouvrirForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('campagne_pnc_rouvrir', array(
            'id' => $campagnePnc->getId(),
        )))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Crée le formulaire de fermeture de la CampagnePnc.
     *
     * @param CampagnePnc $campagnePnc
     *                                 L'entité CampagnePnc
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerFermerForm(CampagnePnc $campagnePnc)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('campagne_pnc_fermer', array(
            'id' => $campagnePnc->getId(),
        )))
        ->setMethod('PUT')
        ->getForm();
    }
}
