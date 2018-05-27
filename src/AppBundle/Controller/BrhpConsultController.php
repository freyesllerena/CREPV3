<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\BrhpConsult;
use AppBundle\Twig\AppExtension;
use AppBundle\Security\BrhpConsultVoter;
use AppBundle\Service\BaseManager;
use AppBundle\Service\BrhpConsultManager;

/**
 * BrhpConsult controller.
 */
class BrhpConsultController extends Controller
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

        /* @var $brhpConsultManager BrhpConsultManager */
        $brhpConsultManager = $this->get('app.brhp_consult_manager');
        $listeBrhpsConsult = $brhpConsultManager->getBrhpsConsult($perimetresRlc);

        $deleteForms = $this->createDeleteForms($listeBrhpsConsult);

        return $this->render('BrhpConsult/index.html.twig', array(
            'personnes' => $listeBrhpsConsult,
        	'deleteForms' => $deleteForms,
            'routePrefix' => 'brhp_consult',
            'perimetresRlc' => $perimetresRlc,
        ));
    }

    /**
     * Creates a new BRHP Consult.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function newAction(Request $request)
    {
        $brhpConsult = new BrhpConsult();

        // Affectation du ministère de l'utilisateur
        $utilisateur = $this->getUser();
        $ministere = $utilisateur->getMinistere();
        $brhpConsult->setMinistere($ministere);

        $em = $this->getDoctrine()->getManager();

        $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetreBrhps = $em->getRepository('AppBundle:PerimetreBrhp')->getPerimetresBrhpByRlc($rlc);

        $form = $this->createForm('AppBundle\Form\BrhpConsultType', $brhpConsult, array('perimetresBrhp' => $perimetreBrhps));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isUnique($rlc->getPerimetresRlc(), $form)) {
            /* @var $brhpConsultManager BrhpConsultManager */
            $brhpConsultManager = $this->get('app.brhp_consult_manager');

            $brhpConsultManager->creerBrhpConsult($brhpConsult);

            $this->get('session')->getFlashBag()->set('notice', 'BRHP en consulation \"'.AppExtension::identite($brhpConsult).'\" créé !');

            return $this->redirectToRoute('brhp_consult_index', array('id' => $brhpConsult->getId()));
        }

        return $this->render('BrhpConsult/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function isUnique($perimetresRlc, $form)
    {
        /* @var $brhpConsultManager BrhpConsultManager */
        $brhpConsultManager = $this->get('app.brhp_consult_manager');
        $listeBrhpsConsult = $brhpConsultManager->getBrhpsConsult($perimetresRlc);

        $nouveauBrhpConsult = $form->getData();

        foreach ($listeBrhpsConsult as $brhpConsult) {
            if ($brhpConsult->getEmail() == $nouveauBrhpConsult->getEmail()) {
                $form->get('email')->addError(new FormError('Ce BRHP consultation est déjà déclaré'));

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
    public function editAction(Request $request, BrhpConsult $brhpConsult)
    {
        // Voter
        $this->denyAccessUnlessGranted(BrhpConsultVoter::EDIT, $brhpConsult);

        $anciensPerimetres = $brhpConsult->getPerimetresBrhp()->toArray();

        $utilisateur = $this->getUser();

        // Affectation du ministere de l'utilisateur
        $ministere = $utilisateur->getMinistere();
        $brhpConsult->setMinistere($ministere);

        $em = $this->getDoctrine()->getManager();
        $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetreBrhps = $em->getRepository('AppBundle:PerimetreBrhp')->getPerimetresBrhpByRlc($rlc);

        $editForm = $this->createForm('AppBundle\Form\BrhpConsultType', $brhpConsult, array('perimetresBrhp' => $perimetreBrhps, 'typeAction' => 'edit'));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /* @var $brhpConsultManager BrhpConsultManager */
            $brhpConsultManager = $this->get('app.brhp_consult_manager');
            $brhpConsultManager->updateBrhpConsult($brhpConsult, $anciensPerimetres, $rlc->getPerimetresRlc());

            $this->get('session')->getFlashBag()->set('notice', 'BRHP consultation\"'.AppExtension::identite($brhpConsult).'\" modifié !');

            return $this->redirectToRoute('brhp_consult_index', array('id' => $brhpConsult->getId()));
        }

        return $this->render('BrhpConsult/edit.html.twig', array(
            'brhpConsult' => $brhpConsult,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a BRHP Consult entity.
     *
     * @Security("has_role('ROLE_RLC')")
     */
    public function deleteAction(Request $request, BrhpConsult $brhpConsult)
    {
        // Voter
        $this->denyAccessUnlessGranted(BrhpConsultVoter::DELETE, $brhpConsult);

        $form = $this->createDeleteForm($brhpConsult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $rlc = $em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            /* @var $brhpConsultManager BrhpConsultManager */
            $brhpConsultManager = $this->get('app.brhp_consult_manager');
            $brhpConsultManager->delete($brhpConsult, $rlc->getPerimetresRlc());

            $this->get('session')->getFlashBag()->set('notice', 'BRHP \"' . AppExtension::identite($brhpConsult) . '\" supprimé !');
        }

        return $this->redirectToRoute('brhp_consult_index');
    }

    /**
     * Creates a form to delete a BrhpConsult entity.
     *
     * @param BrhpConsult $brhpConsult The BrhpConsult entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BrhpConsult $brhpConsult)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('brhp_consult_delete', array('id' => $brhpConsult->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Crée un tableau de formulaires de suppression de BrhpConsult.
     *
     */
    private function createDeleteForms($listeBrhpsConsult)
    {
        $deleteForms = array();
        foreach ($listeBrhpsConsult as $brhpConsult) {
            $deleteForms[] = $this->createDeleteForm($brhpConsult)->createView();
        }

        return $deleteForms;
    }
}
