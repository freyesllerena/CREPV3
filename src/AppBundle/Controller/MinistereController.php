<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Ministere;
use AppBundle\Form\MinistereType;

/**
 * Ministere controller.
 */
class MinistereController extends Controller
{
    /**
     * Lists all Ministere entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        // Récupérer la liste des ministères
        $em = $this->getDoctrine()->getManager();
        $ministeres = $em->getRepository('AppBundle:Ministere')->findBy(array(), array('libelleCourt' => 'ASC'));

        // initialisation d'un tableau qui va accueillir les formulaires de suppression avec le jeton CSRF
        $deleteForms = array();

        // Remplissage du tableau de formulaires de suppression
        foreach ($ministeres as $ministere) {
            $deleteForms[] = $this->createDeleteForm($ministere->getId())->createView();
        }

        return $this->render('Ministere/index.html.twig', array(
            'ministeres' => $ministeres,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Finds and displays a Ministere entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction(Ministere $ministere)
    {
        return $this->render('Ministere/show.html.twig', array(
                'ministere' => $ministere,
        ));
    }

    /**
     * Creates a new Ministere entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $ministere = new Ministere();
        $form = $this->createCreateForm($ministere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ministere);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Ministère \"'.$ministere->getLibelleCourt().'\" créé !');

            return $this->redirect($this->generateUrl('ministere'));
        }

        return $this->render('Ministere/new.html.twig', array(
            'ministere' => $ministere,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Ministere entity.
     *
     * @param Ministere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ministere $entity)
    {
        $form = $this->createForm(MinistereType::class, $entity, array(
            'action' => $this->generateUrl('new_ministere'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to edit an existing Ministere entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Ministere $ministere)
    {
        $editForm = $this->createForm('AppBundle\Form\MinistereType', $ministere);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ministere);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Ministère \"'.$ministere->getLibelleCourt().'\" mis à jour avec succès !');

            return $this->redirectToRoute('ministere');
        }

        return $this->render('Ministere/edit.html.twig', array(
            'ministere' => $ministere,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Ministere entity.
     *
     * @param Ministere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ministere $entity)
    {
        $form = $this->createForm(MinistereType::class, $entity, array(
            'action' => $this->generateUrl('update_ministere', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Deletes a Ministere entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Ministere $ministere)
    {
        $form = $this->createDeleteForm($ministere->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($ministere);

                $em->flush();
                $this->get('session')->getFlashBag()->set('notice', 'Ministère "'.$ministere->getLibelleCourt().'\" supprimé !');
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->set('danger', 'Le ministère "'.$ministere->getLibelleCourt()."\" ne peut pas être supprimé car il dispose d'un historique !");
            }
        }

        return $this->redirect($this->generateUrl('ministere'));
    }

    /**
     * Creates a form to delete a Ministere entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_ministere', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
