<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Security\PerimetreRlcVoter;
use AppBundle\Entity\Utilisateur;
use AppBundle\Service\PerimetreRlcManager;

/**
 * PerimetreRlc controller.
 */
class PerimetreRlcController extends Controller
{
    /**
     * Lists all PerimetreRlc entities.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function indexAction(PerimetreRlcManager $perimetreRlcManager)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->getUser();

        $ministere = $utilisateur->getMinistere();

        $perimetreRlcs = $perimetreRlcManager->getPerimetresRlc();

        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            $perimetreRlcs = $em->getRepository('AppBundle:PerimetreRlc')->findAll();
        } else {
            $perimetreRlcs = $em->getRepository('AppBundle:PerimetreRlc')->findByMinistere($ministere);
        }

        $deleteForms = $this->createDeleteForms($perimetreRlcs);

        return $this->render('perimetreRlc/index.html.twig', array(
            'perimetreRlcs' => $perimetreRlcs,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new PerimetreRlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function newAction(Request $request)
    {
        $perimetreRlc = new PerimetreRlc();

        $ministere = $this->getUser()->getMinistere();
        $perimetreRlc->setMinistere($ministere);

        $form = $this->createForm('AppBundle\Form\PerimetreRlcType', $perimetreRlc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($perimetreRlc);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Périmètre RLC créé avec succès !');

            return $this->redirectToRoute('perimetre_rlc_index', array('id' => $perimetreRlc->getId()));
        }

        return $this->render('perimetreRlc/new.html.twig', array(
            'perimetreRlc' => $perimetreRlc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PerimetreRlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function showAction(PerimetreRlc $perimetreRlc)
    {
        $this->denyAccessUnlessGranted(PerimetreRlcVoter::VIEW, $perimetreRlc);

        $form = $this->createForm('AppBundle\Form\PerimetreRlcType', $perimetreRlc);
        $deleteForm = $this->createDeleteForm($perimetreRlc);

        return $this->render(
            'perimetreRlc/show.html.twig',

            array(
                'form' => $form->createView(),
                'perimetreRlc' => $perimetreRlc,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing PerimetreRlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function editAction(Request $request, PerimetreRlc $perimetreRlc)
    {
        $this->denyAccessUnlessGranted(PerimetreRlcVoter::EDIT, $perimetreRlc);

        $deleteForm = $this->createDeleteForm($perimetreRlc);
        $editForm = $this->createForm('AppBundle\Form\PerimetreRlcType', $perimetreRlc);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($perimetreRlc);
            $em->flush();

            return $this->redirectToRoute('perimetre_rlc_index', array('id' => $perimetreRlc->getId()));
        }

        return $this->render('perimetreRlc/edit.html.twig', array(
            'perimetreRlc' => $perimetreRlc,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PerimetreRlc entity.
     *
     * @Security("has_role('ROLE_PNC')")
     */
    public function deleteAction(Request $request, PerimetreRlc $perimetreRlc)
    {
        $this->denyAccessUnlessGranted(PerimetreRlcVoter::DELETE, $perimetreRlc);

        $form = $this->createDeleteForm($perimetreRlc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($perimetreRlc);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notice', 'Périmètre RLC supprimé !');
            } catch (\Exception $e) {
                $this
                    ->get('session')
                    ->getFlashBag()
                    ->set('danger', "Suppression impossible. Ce périmètre est utilisé par l'application !")
                ;
            }
        }

        return $this->redirectToRoute('perimetre_rlc_index');
    }

    /**
     * Creates a form to delete a PerimetreRlc entity.
     *
     * @param PerimetreRlc $perimetreRlc The PerimetreRlc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PerimetreRlc $perimetreRlc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('perimetre_rlc_delete', array('id' => $perimetreRlc->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createDeleteForms($perimetreRlcs)
    {
        $deleteForms = array();

        foreach ($perimetreRlcs as $perimetreRlc) {
            $deleteForms[] = $this->createDeleteForm($perimetreRlc)->createView();
        }

        return $deleteForms;
    }
}
