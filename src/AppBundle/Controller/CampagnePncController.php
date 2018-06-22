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
use AppBundle\Form\RechercheCampagnePncType;
use AppBundle\Form\CampagnePncType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function newAction(Request $request, CampagnePncManager $campagnePncManager)
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
    public function showAction(CampagnePnc $campagnePnc, Request $request, CrepManager $crepManager, CampagnePncManager $campagnePncManager)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::VOIR, $campagnePnc);

        //On redirige vers la vue tableau de bord que si le fichier d'agents a été diffusé par l'admin ministériel
        if ($campagnePnc->getDiffusee() && !in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE,
        ))) {
            $response = $this->tableauDeBord($campagnePnc, $request, $crepManager, $campagnePncManager);
        } else {
            $response = $this->show($campagnePnc, $request);
        }

        return $response;
    }

    /**
     * Renvoie vers la vue show d'une campagne PNC avant ouverture.
     *
     * @param CampagnePnc $campagnePnc
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function show(CampagnePnc $campagnePnc, Request $request)
    {
        $deleteForm = $this->createDeleteForm($campagnePnc);
        $ouvrirForm = $this->creerOuvrirForm($campagnePnc);

        $em = $this->getDoctrine()->getManager();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');

        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($campagnePnc->getMinistere(), true);

        return $this->render('campagnePnc/show.html.twig', array(
            'campagnePnc' => $campagnePnc,
            'ouvrir_form' => $ouvrirForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'modelesCrep' => $modelesCrep,
        ));
    }

    /**
     * Renvoie vers la vue tableau de bord d'une campagne PNC après ouverture.
     *
     * @param CampagnePnc $campagnePnc
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function tableauDeBord(CampagnePnc $campagnePnc, Request $request, CrepManager $crepManager, CampagnePncManager $campagnePncManager)
    {
        $cloturerForm = $this->creerCloturerForm($campagnePnc);
        $rouvrirForm = $this->creerRouvrirForm($campagnePnc);
        $fermerForm = $this->creerFermerForm($campagnePnc);
        $rechercheForm = $this->creerRechercheForm($campagnePnc);
        $rechercheForm->handleRequest($request);

        $perimetresRlc = [];
        $perimetresBrhp = [];
        $categories = [];
        $affectations = [];
        $corps = [];

        if ($rechercheForm->isSubmitted() && $rechercheForm->isValid()) {
            $perimetresRlc = $rechercheForm->get('perimetresRlc')->getData();
            $perimetresBrhp = $rechercheForm->get('perimetresBrhp')->getData();
            $categories = $rechercheForm->getData()['categories'];
            $affectations = $rechercheForm->getData()['affectations'];
            $corps = $rechercheForm->getData()['corps'];
        }

        $em = $this->getDoctrine()->getManager();

        $perimetre = null;

        $indicateurs = $crepManager->calculIndicateurs($campagnePnc, $perimetresRlc, $perimetresBrhp, null, null, $categories, $affectations, $corps);

        $historiqueIndicateurs = $campagnePncManager->getHistoriqueIndicateurs($campagnePnc);

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');

        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($campagnePnc->getMinistere(), true);

        return $this->render('campagnePnc/tableauDeBord.html.twig', array(
            'campagnePnc' => $campagnePnc,
            'cloturer_form' => $cloturerForm->createView(),
            'rouvrir_form' => $rouvrirForm->createView(),
            'fermer_form' => $fermerForm->createView(),
            'recherche_form' => $rechercheForm->createView(),
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
    public function editAction(Request $request, CampagnePnc $campagnePnc, CampagnePncManager $campagnePncManager, ValidatorInterface $validator)
    {	
        $this->denyAccessUnlessGranted(CampagnePncVoter::MODIFIER, $campagnePnc);
        
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $collectionPerimetresRlc = new ArrayCollection();
        foreach ($campagnePnc->getPerimetresRlc() as $perimetreRlc) {
            $collectionPerimetresRlc->add($perimetreRlc);
        }

        $deleteForm = $this->createDeleteForm($campagnePnc);
        $editForm = $this->createForm(CampagnePncType::class, $campagnePnc, array(
            'utilisateur' => $utilisateur,
            'campagnePnc' => $campagnePnc,
            'validation_groups' => ['Default', 'modification'],
        ));

        $editForm->handleRequest($request);
        
        $nouveauxDocuments = $editForm->get('nouveauxDocuments')->getData();

        // Suppression des documents vides
        /* @var $nouveauDocument Document */
        if($nouveauxDocuments){
	        foreach ($nouveauxDocuments as $key => $nouveauDocument){
	        	if(!$nouveauDocument->getFile()){
	        		unset($nouveauxDocuments[$key]);
	        	}
	        }
        }
        
        $deleteForms = $this->createDeleteDocumentForms($campagnePnc);

        /* @var $campagnePncDuFormulaire CampagnePnc */
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
            // Ajout des nouveaux documents
            foreach ($nouveauxDocuments as $nouveauDocument) {
                $campagnePnc->addDocument($nouveauDocument);
            }

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
    public function ouvrirAction(CampagnePnc $campagnePnc, CampagnePncManager $campagnePncManager)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::OUVRIR, $campagnePnc);

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
    public function cloturerAction(Request $request, CampagnePnc $campagnePnc, CampagnePncManager $campagnePncManager)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::CLOTURER, $campagnePnc);

        $form = $this->creerCloturerForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function rouvrirAction(Request $request, CampagnePnc $campagnePnc, CampagnePncManager $campagnePncManager)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::ROUVRIR, $campagnePnc);

        $form = $this->creerRouvrirForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function fermerAction(Request $request, CampagnePnc $campagnePnc, CampagnePncManager $campagnePncManager)
    {
        $this->denyAccessUnlessGranted(CampagnePncVoter::FERMER, $campagnePnc);

        $form = $this->creerFermerForm($campagnePnc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * Crée le formulaire de recherche sur une CampagnePnc.
     *
     * @param CampagnePnc $campagnePnc
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerRechercheForm(CampagnePnc $campagnePnc)
    {
        return $this->createForm(RechercheCampagnePncType::class, null, array(
            'campagnePnc' => $campagnePnc,
            'em' => $this->getDoctrine()->getManager(),
        ));
    }
}
