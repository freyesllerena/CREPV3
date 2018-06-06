<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\UniteOrganisationnelle;
use AppBundle\Service\UniteOrganisationnelleManager;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UploadeDocument;
use AppBundle\Service\ImportCsv;
use Symfony\Component\Form\FormError;
use AppBundle\Repository\UniteOrganisationnelleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use AppBundle\Security\UniteOrganisationnelleVoter;
use AppBundle\Entity\Ministere;

/**
 * UniteOrganisationnelle controller.
 */
class UniteOrganisationnelleController extends Controller
{
    /**
     * Lists all agent entities.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function indexAction()
    {
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $ministere = $utilisateur->getMinistere();

        // formulaire de suppression de tout le référentiel des unités organisationnelles
        $deleteForm = $this->createFormBuilder()
        ->setAction($this->generateUrl('unite_organisationnelle_delete_all', array('id' => $ministere->getId())))
        ->setMethod('DELETE')
        ->getForm();

        return $this->render('uniteOrganisationnelle/index.html.twig', array(
                'ministere' => $ministere,
                'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Crée une nouvelle UniteOrganisationnelle.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function newAction(Request $request, UniteOrganisationnelleManager $uniteOrganisationnelleManager)
    {
        $uo = new UniteOrganisationnelle();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $uo->setMinistere($utilisateur->getMinistere());

        $form = $this->createForm('AppBundle\Form\UniteOrganisationnelleType', $uo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uniteOrganisationnelleManager->creer($uo);

            $flashbagMessage = 'Unite organisationnelle \"'.$uo->getLibelle().'\" créée !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('unite_organisationnelle_index');
        }

        $response = $this->render('uniteOrganisationnelle/new.html.twig', array(
            'uo' => $uo,
            'form' => $form->createView(),
        ));

        // Pour éviter que le navigateur mette en cache le formmulaire de création
        // Sinon si l'utilisateur clique sur le bouton précédent du navigateur il accède au formulaire renseigné
        $response->headers->addCacheControlDirective('private', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->add(['Expires' => '-1']);

        return $response;
    }

    /**
     * Affiche le formulaire de modification d'une UniteOrganisationnelle.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function editAction(Request $request, UniteOrganisationnelle $uo, UniteOrganisationnelleManager $uniteOrganisationnelleManager)
    {
        $this->denyAccessUnlessGranted(UniteOrganisationnelleVoter::MODIFIER, $uo);

        $editForm = $this->createForm('AppBundle\Form\UniteOrganisationnelleType', $uo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $uniteOrganisationnelleManager->sauvegarder($uo);

            $flashbagMessage = 'Unite organisationnelle \"'.$uo->getLibelle().'\" mise à jour avec succès !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('unite_organisationnelle_index');
        }

        return $this->render('uniteOrganisationnelle/edit.html.twig', array(
            '$uo' => $uo,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Affiche une UniteOrganisationnelle.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function showAction(Request $request, UniteOrganisationnelle $uo)
    {
        //Voter
        $this->denyAccessUnlessGranted(UniteOrganisationnelleVoter::VOIR, $uo);

        return $this->render('uniteOrganisationnelle/show.html.twig', array(
            'uo' => $uo,
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
            $resultatLecture = $importCsv->importerOrganisation($filePath, $ministere);
//             }catch (\Exception $e){
//                 $uploadForm->get('file')->addError(new FormError("Erreur lors du chargement du fichier, veuillez vérifier sa structure."));
//                 return $this->render('uniteOrganisationnelle/upload.html.twig', array(
//                     'form'  => $uploadForm->createView(),
//                 ));
//             }

            if (true !== $resultatLecture) {
                return $this->render('uniteOrganisationnelle/compteRenduErreurs.html.twig', array(
                    'resultatLecture' => $resultatLecture,
                ));
            }

            $this->get('session')->getFlashBag()->set('notice', 'Votre organisation a été chargée avec succès !');

            return $this->redirectToRoute('unite_organisationnelle_index');
        }

        return $this->render('uniteOrganisationnelle/upload.html.twig', array(
            'form' => $uploadForm->createView(),
        ));
    }

    /**
     * Supprime une UniteOrganisationnelle en positionnant le flag "supprime" à true.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function deleteAction(Request $request, UniteOrganisationnelle $uo)
    {
        $this->denyAccessUnlessGranted(UniteOrganisationnelleVoter::SUPPRIMER, $uo);

        $deleteForm = $this->createDeleteForm($uo);

        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $uo->setSupprime(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->get('session')->getFlashBag()->set('notice', 'Unité organisationnelle supprimée !');
        }

        return $this->redirectToRoute('unite_organisationnelle_index');
    }

    private function createDeleteForm(UniteOrganisationnelle $uo)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('unite_organisationnelle_delete', array('id' => $uo->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Récupère les Unites Organisationnelles et les retourne en JSON.
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

        /* @var $repository UniteOrganisationnelleRepository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:UniteOrganisationnelle');

        $utilisateur = $this->getUser();

        $ministere = $utilisateur->getMinistere();

        $uos = $repository->dataTableServerProcessing($ministere, $search, $start, $length, true, $columnOrder, $dirOrder);

        $output = array(
                'data' => array(),
                'recordsFiltered' => $repository->countUnitesOrganisationnelles($ministere, $search),
                'recordsTotal' => $repository->countUnitesOrganisationnelles($ministere),
        );

        /* @var $uo UniteOrganisationnelle */
        foreach ($uos as $uo) {
            $deleteForm = $this->createDeleteForm($uo)->createView();

            $output['data'][] = [
                    'code' => htmlspecialchars($uo->getCode()),
                    'libelle' => htmlspecialchars($uo->getLibelle()),
                    'actions' => $this->render('uniteOrganisationnelle/actionsUo.html.twig', ['uo' => $uo, 'deleteForm' => $deleteForm])->getContent(),
            ];
        }

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * supprime une formation.
     *
     * @Security("has_role('ROLE_ADMIN_MIN')")
     */
    public function deleteAllAction(Request $request, Ministere $ministere, UniteOrganisationnelleManager $uniteOrganisationnelleManager)
    {
        $this->denyAccessUnlessGranted(UniteOrganisationnelleVoter::SUPPRIMER_REFERENTIEL, $ministere);

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('unite_organisationnelle_delete_all', array('id' => $ministere->getId())))
        ->setMethod('DELETE')
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $uniteOrganisationnelleManager->supprimerReferentiel($ministere);

            $flashbagMessage = 'Réferentiel des unités organisationnelles supprimé !';

            $this->get('session')
            ->getFlashBag()
            ->set('notice', $flashbagMessage);

            return $this->redirectToRoute('unite_organisationnelle_index');
        }
    }
}
