<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Crep;
use AppBundle\Security\RecoursVoter;
use AppBundle\Security\CrepVoter;
use Symfony\Component\Form\FormError;

/**
 * Recour controller.
 */
class RecoursController extends Controller
{
    /**
     * Lists all recour entities.
     */
    public function indexAction(Crep $crep)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::VOIR_RECOURS, $crep);

        $em = $this->getDoctrine()->getManager();

        $listeRecours = $em->getRepository('AppBundle:Recours')->findByCrep($crep);

        $deleteForms = $this->createDeleteForms($listeRecours);

        $supprimerCrepForm = $this->createSupprimerCrepForm($crep);

        return $this->render(
            'recours/index.html.twig',
            [
                'listeRecours' => $listeRecours,
                'crep' => $crep,
                'deleteForms' => $deleteForms,
                'supprimer_crep_form' => $supprimerCrepForm->createView(),
            ]
        );
    }

    private function createSupprimerCrepForm(Crep $crep)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('supprimer_crep', array('id' => $crep->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    private function createDeleteForms($listeRecours)
    {
        $deleteForms = [];

        foreach ($listeRecours as $recours) {
            $deleteForms[$recours->getId()] = $this->createDeleteForm($recours)->createView();
        }

        return $deleteForms;
    }

    /**
     * Creates a new recour entity.
     */
    public function newAction(Request $request, Crep $crep)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::DECLARER_RECOURS, $crep);

        $recours = new Recours();

        $roleSelected = $this->get('session')->get('selectedRole');

        $form = $this->createForm('AppBundle\Form\RecoursType', $recours, ['roleUtilisateur' => $roleSelected]);
        $form->handleRequest($request);

        // isSubmitted pour éviter d'afficher l'erreur au chargement du formulaire
        if (!$this->isUnique($recours, $crep) && $form->isSubmitted()) {
            $form->get('type')->addError(new FormError('Un recours du même type est déclaré sur ce CREP'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $crep->addRecours($recours);
            $em = $this->getDoctrine()->getManager();
            $em->persist($crep);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Recours déclaré avec succès !');

            return $this->redirectToRoute(
                'recours_index',
                    [
                        'id' => $crep->getId(),
                    ]
            );
        }

        return $this->render(
            'recours/new.html.twig',
            [
// 	            'recours' 	=> $recours,
                'form' => $form->createView(),
                'crep' => $crep,
            ]
        );
    }

    /**
     * Cette fonction vérifie l'existence d'un recours du même type sur un CREP avec une décision non traitée.
     *
     * @param Recours $newRecours
     * @param Crep    $crep
     *
     * @return bool
     */
    private function isUnique(Recours $newRecours, Crep $crep)
    {
        /* @var $recours Recours */
        foreach ($crep->getRecours() as $recours) {
            if ($newRecours->getType() == $recours->getType() && !$recours->getDecisionPriseEnCompte() && $recours->getId() != $newRecours->getId()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Displays a form to edit an existing recour entity.
     */
    public function editAction(Request $request, Recours $recours)
    {
        //Voter
        $this->denyAccessUnlessGranted(RecoursVoter::MODIFIER, $recours);

        $roleSelected = $this->get('session')->get('selectedRole');
        $deleteForm = $this->createDeleteForm($recours);
        $editForm = $this->createForm('AppBundle\Form\RecoursType', $recours, ['roleUtilisateur' => $roleSelected]);
        $editForm->handleRequest($request);

        if (!$this->isUnique($recours, $recours->getCrep())) {
            $editForm->get('type')->addError(new FormError('Un recours du même type est déclaré sur ce CREP'));
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recours_index', array('id' => $recours->getCrep()->getId()));
        }

        return $this->render('recours/edit.html.twig', array(
            'recours' => $recours,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'crep' => $recours->getCrep(),
        ));
    }

    /**
     * Deletes a recour entity.
     */
    public function deleteAction(Request $request, Recours $recours)
    {
        //Voter
        $this->denyAccessUnlessGranted(RecoursVoter::SUPPRIMER, $recours);

        $form = $this->createDeleteForm($recours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recours);
            $em->flush();
        }

        return $this->redirectToRoute(
            'recours_index',
                [
                    'id' => $recours->getCrep()->getId(),
                ]
        );
    }

    /**
     * Creates a form to delete a recour entity.
     *
     * @param Recours $recours The recour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recours $recours)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recours_delete', array('id' => $recours->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
