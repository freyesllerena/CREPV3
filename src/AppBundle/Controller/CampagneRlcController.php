<?php

namespace AppBundle\Controller;

use AppBundle\Security\CampagneRlcVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CampagneRlc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Service\CampagneRlcManager;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;
use AppBundle\Service\CrepManager;

/**
 * CampagneRlc controller.
 */
class CampagneRlcController extends Controller
{
    /**
     * Lists all CampagneRlc entities.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $campagnesRlc = $em->getRepository('AppBundle:CampagneRlc')->findCampagnesRecentes($this->getUser());

        return $this->render('campagneRlc/index.html.twig', array(
            'campagnesRlc' => $campagnesRlc,
        ));
    }

    /**
     * Finds and displays a CampagneRlc entity.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function showAction(CampagneRlc $campagneRlc, Request $request)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneRlcVoter::VOIR, $campagneRlc);

        $em = $this->getDoctrine()->getManager();

        //On récupère l'id du périmètre donnée en parametre depuis le tableau de bord
        $perimetreId = $request->attributes->get('id_perimetre');
        $perimetreBrhp = null;
        if ($perimetreId > 0) {
            $perimetreBrhp = $em->getRepository('AppBundle:PerimetreBrhp')->find($perimetreId);

            //si le périmetre n'existe pas, on déclenche une erreur
            if (!$perimetreBrhp) {
                throw $this->createNotFoundException('Aucun périmètre trouvé !');
            }
        }

        $ouvrirForm = $this->creerOuvrirForm($campagneRlc);

        $rouvrirForm = $this->creerRouvrirForm($campagneRlc);

        /* @var $ministere Ministere */
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles de CREP actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        //On redirige vers la vue tableau de bord que si le fichier d'agents a été diffusé par l'admin ministériel
        if ($campagneRlc->getCampagnePnc()->getDiffusee()) {
            /*@var $crepManager CrepManager */
            $crepManager = $this->get('app.crep_manager');
            $indicateurs = $crepManager->calculIndicateurs($campagneRlc, $perimetreBrhp);

            /*@var $campagnePncManager CampagnePncManager */
            $campagneRlcManager = $this->get('app.campagne_rlc_manager');
            $historiqueIndicateurs = $campagneRlcManager->getHistoriqueIndicateurs($campagneRlc);

            $template = 'campagneRlc/tableauDeBord.html.twig';

            return $this->render($template, array(
                'campagneRlc' => $campagneRlc,
                'indicateurs' => $indicateurs,
                'historiqueIndicateurs' => $historiqueIndicateurs,
                'perimetre' => $perimetreBrhp,
                'ouvrir_form' => $ouvrirForm->createView(),
                'rouvrir_form' => $rouvrirForm->createView(),
                'modelesCrep' => $modelesCrep,
            ));
        }

        return $this->render('campagneRlc/show.html.twig', array(
                'campagneRlc' => $campagneRlc,
                'ouvrir_form' => $ouvrirForm->createView(),
                'rouvrir_form' => $rouvrirForm->createView(),
                'modelesCrep' => $modelesCrep,
        ));
    }

    /**
     * Displays a form to edit an existing CampagneRlc entity.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function editAction(Request $request, CampagneRlc $campagneRlc)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneRlcVoter::MODIFIER, $campagneRlc);

        $campagneRlc->getDocuments()->toArray(); // cette ligne est indspensable pour que le clone se fasse correctement
        $anciensDocuments = clone $campagneRlc->getDocuments();

        $perimetresBrhp = $campagneRlc->getPerimetreRlc()->getPerimetresBrhp();
        $ancienStatut = $campagneRlc->getStatut();
        $collectionPerimetresBrhp = new ArrayCollection();
        foreach ($campagneRlc->getPerimetresBrhp() as $perimetreBrhp) {
            $collectionPerimetresBrhp->add($perimetreBrhp);
        }

        $editForm = $this->createForm('AppBundle\Form\CampagneRlcType', $campagneRlc, array(
            'campagneRlc' => $campagneRlc,
            'perimetresBrhp' => $perimetresBrhp,
        ));

        $editForm->handleRequest($request);

        /* @var $campagneRlcManager CampagneRlcManager */
        $campagneRlcManager = $this->get('app.campagne_rlc_manager');
        $campagneRlc = $campagneRlcManager->verfierDocuments($campagneRlc);

        /* @var $campagneRlcDuFormulaire CampagneRlc */
        $campagneRlcDuFormulaire = $editForm->getData();

        // Bloquer la possibilité de suppression de périmètre Brhp
        if (EnumStatutCampagne::OUVERTE === $ancienStatut) {
            /** @var PerimetreBrhp $perimetreBrhp */
            foreach ($collectionPerimetresBrhp as $perimetreBrhp) {
                if (!$campagneRlcDuFormulaire->getPerimetresBrhp()->contains($perimetreBrhp)) {
                    $editForm->get('perimetresBrhp')->addError(new FormError(
                            'Le périmètre "'.$perimetreBrhp->getLibelle().'" ne peut pas être supprimé.'
                    ));
                }
            }
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Les anciens de documents ne figurent pas dans le formulaire,
            //il faut les rajouter à l'entité sinon ils sont écrasés
            foreach ($anciensDocuments as $ancienDocument) {
                $campagneRlc->addDocument($ancienDocument);
            }

            if (EnumStatutCampagne::INITIALISEE == $ancienStatut) {
                $campagneRlc->setStatut(EnumStatutCampagne::CREEE);
            }

            $nouveauxPerimetresBrhp = array_diff(
                    $campagneRlcDuFormulaire->getPerimetresBrhp()->getValues(),
                    $collectionPerimetresBrhp->getValues()
            );

            if (EnumStatutCampagne::OUVERTE === $ancienStatut && $nouveauxPerimetresBrhp) {
                $nouveauxPerimetresBrhp = array_values($nouveauxPerimetresBrhp);
                $collectionNouveauxPerimetresBrhp = new ArrayCollection($nouveauxPerimetresBrhp);
                $campagneRlcManager->ouvrirNouveauxPerimetres($campagneRlc, $collectionNouveauxPerimetresBrhp);
            }

            $campagneRlcManager->sauvegarder($campagneRlc);

            $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', 'Campagne RLC \"'.$campagneRlc->getLibelle().'\" mise à jour avec succès !')
            ;

            return $this->redirectToRoute('campagne_rlc_show', array('id' => $campagneRlc->getId()));
        }

        if ($editForm->isSubmitted() && !$editForm->isValid()) {
            // Les anciens de documents ne figurent pas dans le formulaire,
            //il faut les rajouter à l'entité sinon ils ne seront pas affichés
            foreach ($anciensDocuments as $ancienDocument) {
                $campagneRlc->addDocument($ancienDocument);
            }
        }

        $deleteForms = $this->createDeleteDocumentForms($campagneRlc);

        return $this->render('campagneRlc/edit.html.twig', array(
                'campagneRlc' => $campagneRlc,
                'form' => $editForm->createView(),
                'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Ouvrir une campagne Rlc.
     *
     * @param CampagneRlc $campagnePnc Campagne Rlc que l'on souhaite ouvrir
     * @Security("has_role('ROLE_RLC')")
     */
    public function ouvrirAction(CampagneRlc $campagneRlc)
    {
        //Voter
        $this->denyAccessUnlessGranted(CampagneRlcVoter::OUVRIR, $campagneRlc);

        /* @var $campagneRlcManager CampagneRlcManager */
        $campagneRlcManager = $this->get('app.campagne_rlc_manager');

        $campagneRlcManager->ouvrir($campagneRlc);

        $this
            ->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne RLC \"'.$campagneRlc->getLibelle().'\" ouverte !')
        ;

        return $this->redirectToRoute('campagne_rlc_index');
    }

    /**
     * Rouvre une campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     * @Security("has_role('ROLE_RLC')")
     */
    public function rouvrirAction(Request $request, CampagneRlc $campagneRlc)
    {
        $this->denyAccessUnlessGranted(CampagneRlcVoter::ROUVRIR, $campagneRlc);

        $form = $this->creerRouvrirForm($campagneRlc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $campagneRlcManager CampagneRlcManager */
            $campagneRlcManager = $this->get('app.campagne_rlc_manager');

            $campagneRlcManager->rouvrir($campagneRlc);

            $this->get('session')
            ->getFlashBag()
            ->set('notice', 'Campagne RLC \"'.$campagneRlc->getCampagnePnc()->getLibelle().'\" rouverte avec succès !');

            return $this->redirectToRoute('campagne_rlc_show', array('id' => $campagneRlc->getId()));
        }

        return $this->redirectToRoute('campagne_rlc_show', array('id' => $campagneRlc->getId()));
    }

    /**
     * Crée le formulaire de réouverture de la CampagneRlc.
     *
     * @param CampagneRlc $campagneRlc
     *                                 L'entité CampagneRlc
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerRouvrirForm(CampagneRlc $campagneRlc)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('campagne_rlc_rouvrir', array(
                'id' => $campagneRlc->getId(),
        )))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Génére le formulaire d'ouverture de campagne.
     *
     * @param CampagneRlc $campagneRlc L'entité campagne
     *
     * @return \Symfony\Component\Form\Form Le formulaire
     */
    private function creerOuvrirForm(CampagneRlc $campagneRlc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_rlc_ouvrir', array('id' => $campagneRlc->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }

    private function createDeleteDocumentForms(CampagneRlc $campagneRlc)
    {
        $deleteDocumentForms = array();

        foreach ($campagneRlc->getDocuments() as $document) {
            $deleteDocumentForms[] = $this
            ->createFormBuilder()
            ->setAction($this->generateUrl('campagne_rlc_delete_document', array('id' => $campagneRlc->getId(), 'id_document' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()->createView();
        }

        return $deleteDocumentForms;
    }

    /**
     * @ParamConverter("document", options={"id" = "id_document"})
     * @Security("has_role('ROLE_RLC')")
     */
    public function deleteDocumentAction(CampagneRlc $campagneRlc, Document $document)
    {
        // Voter
        $this->denyAccessUnlessGranted(CampagneRlcVoter::SUPPRIMER_DOCUMENT, $campagneRlc);

        // TODO : verifier avec le voter de CampagneRlc si l'utilisateur peut modifier la campagne
        $em = $this->getDoctrine()->getManager();
        foreach ($campagneRlc->getDocuments() as $doc) {
            if ($doc === $document) {
                $campagneRlc->removeDocument($doc);
                $em->remove($document);
            }
        }

        $em->flush();

        return $this->redirectToRoute('campagne_rlc_edit', array('id' => $campagneRlc->getId()));
    }
}
