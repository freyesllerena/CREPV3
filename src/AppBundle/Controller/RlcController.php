<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Rlc;
use AppBundle\Security\RlcVoter;
use AppBundle\Service\RlcManager;
use AppBundle\Entity\Utilisateur;

/**
 * Rlc controller.
 */
class RlcController extends Controller
{
    /**
     * Lists all Rlc entities.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function indexAction()
    {
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();
        $ministere = $utilisateur->getMinistere();
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $rlcs = $em->getRepository('AppBundle:Rlc')->findAll();
        } else {
            $rlcs = $this->get('app.rlc_manager')->getRlc($ministere);
        }

        $deleteForms = $this->createDeleteForms($rlcs);

        return $this->render('Rlc/index.html.twig', array(
            'personnes' => $rlcs,
            'deleteForms' => $deleteForms,
            'routePrefix' => 'rlc',
        ));
    }

    /**
     * Creates a new Rlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function newAction(Request $request)
    {
        $rlc = new Rlc();

        // Affectation du ministere de l'utilisateur
        $utilisateur = $this->getUser();
        $ministere = $utilisateur->getMinistere();
        $rlc->setMinistere($ministere);

        $perimetresRlc = $this->get('app.perimetre_rlc_manager')->getPerimetreRlc($ministere);

        $form = $this->createForm('AppBundle\Form\RlcType', $rlc, array('perimetresRlc' => $perimetresRlc));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $rlcManager RlcManager */
            $rlcManager = $this->get('app.rlc_manager');
            $rlcManager->creerRlc($rlc);

            $this->get('session')->getFlashBag()->set('notice', 'RLC \"'.$rlc->getNom().' '.$rlc->getPrenom().'\" créé !');

            return $this->redirectToRoute('rlc_index');
        }

        return $this->render('Rlc/new.html.twig', array(
            'rlc' => $rlc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Rlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function editAction(Request $request, Rlc $rlc)
    {
        //Voter
        $this->denyAccessUnlessGranted(RlcVoter::MODIFIER, $rlc);

        // Affectation du ministere de l'utilisateur
        $utilisateur = $this->getUser();
        $ministere = $utilisateur->getMinistere();
        $rlc->setMinistere($ministere);

        $perimetresRlc = $this->get('app.perimetre_rlc_manager')->getPerimetreRlc($ministere);

        $editForm = $this->createForm('AppBundle\Form\RlcType', $rlc, array('perimetresRlc' => $perimetresRlc));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rlc);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'RLC \"'.$rlc->getNom().' '.$rlc->getPrenom().'\" modifié !');

            return $this->redirectToRoute('rlc_index', array('id' => $rlc->getId()));
        }

        return $this->render('Rlc/edit.html.twig', array(
            'rlc' => $rlc,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Rlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function deleteAction(Request $request, Rlc $rlc)
    {
        //Voter
        $this->denyAccessUnlessGranted(RlcVoter::SUPPRIMER, $rlc);

        $form = $this->createDeleteForm($rlc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $rlcManager RlcManager */
            $rlcManager = $this->get('app.rlc_manager');
            $rlcManager->supprimerRlc($rlc);

            $this->get('session')->getFlashBag()->set('notice', 'RLC \"'.$rlc->getNom().' '.$rlc->getPrenom().'\" supprimé !');
        }

        return $this->redirectToRoute('rlc_index');
    }

    /**
     * Creates a form to delete a Rlc entity.
     *
     * @param Rlc $rlc The Rlc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rlc $rlc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rlc_delete', array('id' => $rlc->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Crée un tableau de formulaires de suppression de RLC.
     *
     * @param RLC $rLC The RLC entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForms($rlcs)
    {
        $deleteForms = array();

        foreach ($rlcs as $rlc) {
            $deleteForms[] = $this->createDeleteForm($rlc)->createView();
        }

        return $deleteForms;
    }

    /**
     * @Security("has_role('ROLE_PNC')")
     */
    public function showAction(Rlc $rlc)
    {
        $form = $this->createForm(
            'AppBundle\Form\RlcType',
            $rlc,
            array(
                'perimetresRlc' => $rlc->getPerimetresRlc(),
            )
        );

        return $this->render(
            'Rlc/show.html.twig',
            [
                'form' => $form->createView(),
                'rlc' => $rlc,
            ]
        );
    }
}
