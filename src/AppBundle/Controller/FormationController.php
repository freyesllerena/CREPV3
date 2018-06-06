<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UploadeDocument;
use AppBundle\Service\ImportCsv;
use Symfony\Component\Form\FormError;
use AppBundle\Repository\FormationRepository;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Ministere;
use AppBundle\Security\FormationVoter;
use AppBundle\Service\FormationManager;

/**
 * Formation controller.
 */
class FormationController extends Controller
{
    /**
     * Liste toutes les formation du ministère.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function indexAction()
    {
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $ministere = $utilisateur->getMinistere();

        // formulaire de suppression de tout le référentiel des formations
        $deleteForm = $this->createFormBuilder()
        ->setAction($this->generateUrl('formation_delete_all', array('id' => $utilisateur->getMinistere()->getId())))
        ->setMethod('DELETE')
        ->getForm();

        return $this->render('formation/index.html.twig', array(
            'ministere' => $ministere,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Crée une nouvelle Formation.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function newAction(Request $request, FormationManager $formationManager)
    {
        $formation = new Formation();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();
        $formation->setMinistere($utilisateur->getMinistere());

        $form = $this->createForm('AppBundle\Form\FormationType', $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationManager->creer($formation);

            $flashbagMessage = 'Formation \"'.$formation->getLibelle().'\" créée !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/new.html.twig', array(
            'formation' => $formation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche le formulaire de modification d'une formatoin.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function editAction(Request $request, Formation $formation, FormationManager $formationManager)
    {
        $this->denyAccessUnlessGranted(FormationVoter::MODIFIER, $formation);

        $editForm = $this->createForm('AppBundle\Form\FormationType', $formation);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $formationManager->sauvegarder($formation);

            $flashbagMessage = 'Formation \"'.$formation->getLibelle().'\" mise à jour avec succès !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/edit.html.twig', array(
            'formation' => $formation,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Affiche une formation.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function showAction(Request $request, Formation $formation)
    {
        //Voter
        $this->denyAccessUnlessGranted(FormationVoter::VOIR, $formation);

        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('formation_delete', array('id' => $formation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;

        return $this->render('formation/show.html.twig', array(
            'formation' => $formation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche le formulaire de chargement des Unites Organisationnelles.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function uploadAction(Request $request, ImportCsv $importCsv)
    {
        $uploadeDocument = new UploadeDocument();
        $uploadForm = $this->createForm('AppBundle\Form\UploadeDocumentType', $uploadeDocument, ['validation_groups' => ['Default', 'injection_referentiel']]);
        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $filePath = $uploadeDocument->getFile()->getPathname();
            $ministere = $this->getUser()->getMinistere();

            // on utilise le service pour l'import d'un fichier csv
//             try {
            $resultatLecture = $importCsv->importerReferentielFormation($filePath, $ministere);
//             }catch (\Exception $e){
//                 $uploadForm->get('file')->addError(new FormError("Erreur lors du chargement du fichier, veuillez vérifier sa structure."));
//                 return $this->render('uniteOrganisationnelle/upload.html.twig', array(
//                     'form'  => $uploadForm->createView(),
//                 ));
//             }

            if (true !== $resultatLecture) {
                return $this->render('formation/compteRenduErreurs.html.twig', array(
                    'resultatLecture' => $resultatLecture,
                ));
            }

            $this->get('session')->getFlashBag()->set('notice', 'Votre référentiel des formations a été chargé avec succès !');

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/upload.html.twig', array(
            'form' => $uploadForm->createView(),
        ));
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function serverProcessingAction(Request $request)
    {
        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $search = $request->get('search')['value'];

        $columnOrder = $request->get('order')[0]['column'];
        $dirOrder = $request->get('order')[0]['dir'];

        /* @var $utlisateur Utilisateur */
        $utlisateur = $this->getUser();

        $ministere = $utlisateur->getMinistere();

        /* @var $repository FormationRepository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Formation');

        $formations = $repository->dataTableServerProcessing($ministere, $search, $start, $length, true, $columnOrder, $dirOrder);

        $output = array(
                'data' => array(),
                'recordsFiltered' => $repository->countFormations($ministere, $search),
                'recordsTotal' => $repository->countFormations($ministere),
        );

        /* @var $formation Formation */
        foreach ($formations as $formation) {
            $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('formation_delete', array('id' => $formation->getId())))
            ->setMethod('DELETE')
            ->getForm();

            $output['data'][] = [
                    'id' => $formation->getId(),
                    'code' => htmlspecialchars($formation->getCode()),
                    'libelle' => htmlspecialchars($formation->getLibelle()),
                    'duree' => htmlspecialchars($formation->getDuree()),
                    'actions' => $this->render('formation/actionsFormation.html.twig', array('formation' => $formation, 'deleteForm' => $deleteForm->createView()))->getContent(),
            ];
        }

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * supprime une formation.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function deleteAction(Request $request, Formation $formation)
    {
        $this->denyAccessUnlessGranted(FormationVoter::SUPPRIMER, $formation);

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('formation_delete', array('id' => $formation->getId())))
            ->setMethod('DELETE')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($formation);

                $em->flush();
                $this->get('session')->getFlashBag()->set('notice', 'Formation supprimé !');
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->set('warning', 'Cette formation ne peut pas être supprimée car elle est référencée dans l\'application !');
            }
        }

        return $this->redirect($this->generateUrl('formation_index'));
    }

    /**
     * supprime une formation.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function deleteAllAction(Request $request, Ministere $ministere, FormationManager $formationManager)
    {
        $this->denyAccessUnlessGranted(FormationVoter::SUPPRIMER_REFERENTIEL, $ministere);

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('formation_delete_all', array('id' => $ministere->getId())))
        ->setMethod('DELETE')
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formationManager->supprimerReferentiel($ministere);

            $flashbagMessage = 'Réferentiel supprimé !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('formation_index');
        }
    }

    /**
     * Recherhe ajax.
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function ajaxSearchAction(Request $request, Ministere $ministere)
    {
        $this->denyAccessUnlessGranted(FormationVoter::VOIR_REFERENTIEL, $ministere);

        $search = $request->get('query');

        /* @var $repository FormationRepository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Formation');

        $formations = $repository->searchAjax($ministere, $search);

        $output = [
                'query' => $search,
                'suggestions' => $formations,
        ];

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }
}
