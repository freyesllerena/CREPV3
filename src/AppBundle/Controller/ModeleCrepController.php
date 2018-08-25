<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ModeleCrep;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Agent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Repository\ModeleCrepRepository;
use AppBundle\Service\CrepManager;
use AppBundle\Security\AgentVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\ModeleCrepType;

/**
 * Modelecrep controller.
 */
class ModeleCrepController extends Controller
{
    /**
     * Lists all modeleCrep entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modeleCreps = $em->getRepository('AppBundle:ModeleCrep')->findAll();

        $deleteForms = $this->createDeleteForms($modeleCreps);

        return $this->render('modeleCrep/index.html.twig', array(
            'modeleCreps' => $modeleCreps,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Finds and displays a modeleCrep entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction(ModeleCrep $modeleCrep)
    {
        $enableDisableForm = $this->createEnableDisableForm($modeleCrep);

        return $this->render('modeleCrep/show.html.twig', array(
            'modeleCrep' => $modeleCrep,
            'enable_disable_form' => $enableDisableForm->createView(),
        ));
    }

    /**
     * Creates a new Ministere entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $modeleCrep = new ModeleCrep();
        $form = $this->createForm(ModeleCrepType::class, $modeleCrep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modeleCrep);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Modèle de CREP \"'.$modeleCrep->getLibelle().'\" créé !');

            return $this->redirect($this->generateUrl('modelecrep_index'));
        }

        return $this->render('modeleCrep/new.html.twig', array(
                'modeleCrep' => $modeleCrep,
                'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing modeleCrep entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, ModeleCrep $modeleCrep)
    {
        $editForm = $this->createForm('AppBundle\Form\ModeleCrepType', $modeleCrep);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modelecrep_index');
        }

        return $this->render('modeleCrep/edit.html.twig', array(
            'modeleCrep' => $modeleCrep,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Enable or Disable a modeleCrep entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function enableDisableAction(Request $request, ModeleCrep $modeleCrep)
    {
        $form = $this->createEnableDisableForm($modeleCrep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modeleCrep->setActif(!$modeleCrep->getActif());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute('modelecrep_index');
    }

    /**
     * Creates a form to disable or enable a modeleCrep entity.
     *
     * @param ModeleCrep $modeleCrep The modeleCrep entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEnableDisableForm(ModeleCrep $modeleCrep)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modelecrep_enable_disable', array('id' => $modeleCrep->getId())))
            ->setMethod('PUT')
            ->getForm()
        ;
    }

    /**
     * @Security("has_role('ROLE_SHD')")
     */
    public function choixCrepAction(Request $request, Agent $agent, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(AgentVoter::CHOISIR_CREP, $agent);

        $em = $this->getDoctrine()->getManager();
        $ministere = $this->getUser()->getMinistere();

        /* @var $modeleCrepRepository  ModeleCrepRepository */
        $modeleCrepRepository = $em->getRepository('AppBundle:ModeleCrep');
        // Récupérer les modèles actifs du ministère
        $modelesCrep = $modeleCrepRepository->getModelesCrep($ministere, true);

        // Si aucun modèle n'est trouvé pour le ministère, on affiche un message d'erreur
        if (empty($modelesCrep)) {
            $this
            ->get('session')
            ->getFlashBag()
            ->set('danger', 'Initialisation impossible, aucun modèle de CREP n\'est défini sur votre ministère !');

            return $this->redirectToRoute('campagne_shd_show', ['id' => $agent->getCampagneBrhp()->getId()]);
        }

        $choixForm = $this->createChoixCrepForm($modelesCrep, $agent);

        $choixForm->handleRequest($request);

        if ($choixForm->isSubmitted() && $choixForm->isValid()) {
            // Récupérer le libelle choisi dans le formulaire
            $libelleModeleChoisi = $choixForm->getData()['choixCrep'];

            // Récupérer le modèle associé au libellé choisi
            $modeleCrepChoisi = $modeleCrepRepository->getModeleCrepByLibelle($libelleModeleChoisi, $ministere);

            // Initialiser un CREP à l'agent
            $crep = $crepManager->creer($agent, $modeleCrepChoisi);
            $em->persist($crep);
            $em->flush();
            return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
        }

        return $this->render('modeleCrep/choix.html.twig', array(
                'agent' => $agent,
                'form' => $choixForm->createView(),
                'modelesCrep' => $modelesCrep,
        ));
    }

    private function createChoixCrepForm($modelesCrep, Agent $agent)
    {
        $formChoices = array();

        /* @var $modeleCrep ModeleCrep */
        foreach ($modelesCrep as $modeleCrep) {
            $formChoices[$modeleCrep->getLibelle()] = $modeleCrep->getLibelle();
        }

        return $this->createFormBuilder($modelesCrep)
        ->add(
            'choixCrep',
            ChoiceType::class,
                [
                        'choices' => $formChoices,
                        'expanded' => true,
                        'multiple' => false,
                        'required' => true,
                        'data' => $modelesCrep[0]->getLibelle(),
                ]
        )
                ->setAction($this->generateUrl('crep_modele_choix', ['id' => $agent->getId()]))
                ->setMethod('POST')
                ->getForm();
    }

    /**
     * Supprime une entrée dans la table modèle de CREP.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, ModeleCrep $modeleCrep)
    {
        $form = $this->createDeleteForm($modeleCrep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($modeleCrep);
                $em->flush();
                $this->get('session')->getFlashBag()->set('notice', 'Modèle de CREP supprimé !');
            } catch (\Exception $e) {
                $em = $this->getDoctrine()->resetManager();
                $modeleCrep->setActif(false);
                $em->flush();
                $this
                ->get('session')
                ->getFlashBag()
                ->set('danger', 'Suppression impossible. Le modèle de CREP a été désactivé !')
                ;
            }
        }

        return $this->redirectToRoute('modelecrep_index');
    }

    /**
     * Crée un formulaire de suppression d'un modèle de CREP.
     *
     * @param ModeleCrep $modeleCrep
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ModeleCrep $modeleCrep)
    {
        return $this->createFormBuilder()->setAction($this->generateUrl('modelecrep_delete', array(
                'id' => $modeleCrep->getId(),
        )))->setMethod('DELETE')->getForm();
    }

    private function createDeleteForms($modelesCrep)
    {
        $deleteForms = array();

        foreach ($modelesCrep as $modeleCrep) {
            $deleteForms[] = $this->createDeleteForm($modeleCrep)->createView();
        }

        return $deleteForms;
    }
}
