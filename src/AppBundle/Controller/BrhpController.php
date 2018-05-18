<?php

namespace AppBundle\Controller;

use AppBundle\Security\BrhpVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\Brhp;
use AppBundle\Service\BrhpManager;

/**
 * Brhp controller.
 */
class BrhpController extends Controller
{
    /**
     * Lists all Brhp entities.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            $perimetresRlc = $em->getRepository('AppBundle:PerimetreRlc')->findAll();
        } else {
            /* @var $rlc Rlc */
            $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            $perimetresRlc = $rlc->getPerimetresRlc();
        }

        /* @var $brhpManager BrhpManager */
        $brhpManager = $this->get('app.brhp_manager');
        $listeBrhps = $brhpManager->getBrhps($perimetresRlc);

        $deleteForms = $this->createDeleteForms($listeBrhps);

        return $this->render('Brhp/index.html.twig', array(
            'personnes' => $listeBrhps,
            'deleteForms' => $deleteForms,
            'routePrefix' => 'brhp',
            'perimetresRlc' => $perimetresRlc,
        ));
    }

    /**
     * Creates a new RLC.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function newAction(Request $request)
    {
        $brhp = new Brhp();

        // Affectation du ministère de l'utilisateur
        $utilisateur = $this->getUser();
        $ministere = $utilisateur->getMinistere();
        $brhp->setMinistere($ministere);

        $em = $this->getDoctrine()->getManager();

        $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetreBrhps = $em->getRepository('AppBundle:PerimetreBrhp')->getPerimetresBrhpByRlc($rlc);

        $form = $this->createForm('AppBundle\Form\BrhpType', $brhp, array('perimetresBrhp' => $perimetreBrhps));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isUnique($rlc->getPerimetresRlc(), $form)) {
            /* @var $brhpManager BrhpManager */
            $brhpManager = $this->get('app.brhp_manager');
            $brhpManager->creerBrhp($brhp);

            $this->get('session')->getFlashBag()->set('notice', 'BRHP \"'.$brhp->getNom().' '.$brhp->getPrenom().'\" créé !');

            return $this->redirectToRoute('brhp_index', array('id' => $brhp->getId()));
        }

        return $this->render('Brhp/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function isUnique($perimetresRlc, $form)
    {
        /* @var $brhpManager BrhpManager */
        $brhpManager = $this->get('app.brhp_manager');
        $listeBrhps = $brhpManager->getBrhps($perimetresRlc);

        $nouveauBrhp = $form->getData();

        foreach ($listeBrhps as $brhp) {
            if ($brhp->getEmail() == $nouveauBrhp->getEmail()) {
                $form->get('email')->addError(new FormError('Ce BRHP est déjà déclaré'));

                return false;
            }
        }

        return true;
    }

    /**
     * Displays a form to edit an existing RLC entity.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function editAction(Request $request, Brhp $brhp)
    {
        // Voter
        $this->denyAccessUnlessGranted(BrhpVoter::EDIT, $brhp);

        $anciensPerimetres = $brhp->getPerimetresBrhp()->toArray();

        $utilisateur = $this->getUser();

        // Affectation du ministere de l'utilisateur
        $ministere = $utilisateur->getMinistere();
        $brhp->setMinistere($ministere);

        $em = $this->getDoctrine()->getManager();
        $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetreBrhps = $em->getRepository('AppBundle:PerimetreBrhp')->getPerimetresBrhpByRlc($rlc);

        $editForm = $this->createForm('AppBundle\Form\BrhpType', $brhp, array('perimetresBrhp' => $perimetreBrhps, 'typeAction' => 'editBrhp'));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /* @var $brhpManager BrhpManager */
            $brhpManager = $this->get('app.brhp_manager');
            $brhpManager->updateBrhp($brhp, $anciensPerimetres, $rlc->getPerimetresRlc());

            $this->get('session')->getFlashBag()->set('notice', 'BRHP \"'.$brhp->getNom().' '.$brhp->getPrenom().'\" modifié !');

            return $this->redirectToRoute('brhp_index', array('id' => $brhp->getId()));
        }

        return $this->render('Brhp/edit.html.twig', array(
            'brhp' => $brhp,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a BRHP entity.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function deleteAction(Request $request, Brhp $brhp)
    {
        // Voter
        $this->denyAccessUnlessGranted(BrhpVoter::DELETE, $brhp);

        $form = $this->createDeleteForm($brhp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            /* @var $brhpManager BrhpManager */
            $brhpManager = $this->get('app.brhp_manager');
            $brhpManager->delete($brhp, $rlc->getPerimetresRlc());

            $this->get('session')->getFlashBag()->set('notice', 'BRHP \"'.$brhp->getNom().' '.$brhp->getPrenom().'\" supprimé !');
        }

        return $this->redirectToRoute('brhp_index');
    }

    /**
     * Creates a form to delete a BRHP entity.
     *
     * @param BRHP $brhp The Brhp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Brhp $brhp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('brhp_delete', array('id' => $brhp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Crée un tableau de formulaires de suppression de Brhp.
     *
     * @param BRHP $brhp The Brhp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForms($listeBrhps)
    {
        $deleteForms = array();
        foreach ($listeBrhps as $brhp) {
            $deleteForms[] = $this->createDeleteForm($brhp)->createView();
        }

        return $deleteForms;
    }
}
