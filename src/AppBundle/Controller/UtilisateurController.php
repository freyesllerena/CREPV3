<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Utilisateur;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\ChoixRoleType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Form\ChoixUtilisateurType;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Repository\UtilisateurRepository;
use AppBundle\Security\UtilisateurVoter;
use AppBundle\Service\AppMailer;
use AppBundle\Util\Util;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Service\UtilisateurManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Utilisateur controller.
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all Utilisateur entities.
     *
     * @Security("has_role('ROLE_ADMIN_MIN') or has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('utilisateur/index.html.twig');
    }

    /**
     * Creates a new Utilisateur entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, UtilisateurManager $utilisateurManager, EventDispatcherInterface $eventDispatcher)
    {
        $utilisateur = new Utilisateur();

        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        $event = new GetResponseUserEvent($utilisateur, $request);
        $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if ($form->isSubmitted() && $form->isValid()) {
            // SUCCESS event: form is valid, and before saving
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $utilisateurManager->creer($utilisateur);
            $this->get('session')->getFlashBag()->set('notice', 'Utilisateur \"'.$utilisateur->getEmail().'\" créé !');

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Utilisateur entity.
     */
    public function showAction(Request $request, Utilisateur $utilisateur)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::VOIR, $utilisateur);

        $em = $this->getDoctrine()->getManager();

        /*@var $dernieresConnexion Connexion */
        $dernieresConnexions = $em->getRepository('AppBundle:Connexion')->derniereConnexionUtilisateurs($utilisateur);

        return $this->render('utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'dernieresConnexions' => $dernieresConnexions,
        ));
    }

    /**
     * Displays a form to edit an existing Utilisateur entity.
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::MODIFIER, $utilisateur);

        $editForm = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            $this->get('session')->getFlashBag()->set('notice', 'Utilisateur \"'.$utilisateur->getEmail().'\" mis à jour avec succès !');

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Utilisateur entity.
     */
    public function disableAction(Request $request, Utilisateur $utilisateur)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::DESACTIVER, $utilisateur);

        $form = $this->createDisableForm($utilisateur->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($utilisateur->getId() != $this->getUser()->getId()) {
                $em = $this->getDoctrine()->getManager();
                $utilisateur->setEnabled(false);
                $em->flush();
                $this->get('session')->getFlashBag()->set('notice', 'Utilisateur \"'.$utilisateur->getEmail().'\" désactivé !');
            } else {
                $this->get('session')->getFlashBag()->set('warning', 'Vous ne pouvez pas désactiver votre propre compte utilisateur !');
            }
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * Unlock a Utilisateur entity.
     */
    public function unlockAction(Request $request, Utilisateur $utilisateur)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::DEBLOQUER, $utilisateur);

        $form = $this->createUnlockForm($utilisateur->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $utilisateur->setLocked(false);
            $utilisateur->setNbConnexionKO(0);

            $em->flush();
            $this->get('session')->getFlashBag()->set('notice', 'Utilisateur "'.$utilisateur->getEmail().'" debloqué !');
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    private function createDisableForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('utilisateur_disable', array('id' => $id)))
        ->setMethod('PUT')
        ->getForm();
    }

    /**
     * Deletes a Utilisateur entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($utilisateur);

                $em->flush();
                $this->get('session')->getFlashBag()->set('notice', 'Utilisateur "'.$utilisateur->getEmail().'\" supprimé !');
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->set('warning', "L'utilisateur \"".$utilisateur->getEmail()."\" ne peut pas être supprimé car il dispose d'un historique !");
            }
        }

        return $this->redirect($this->generateUrl('utilisateur_index'));
    }

    /**
     * Creates a form to unlock a Utilisateur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createUnlockForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('utilisateur_unlock', array('id' => $id)))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    private function createRenvoiForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('utilisateur_renvoi_mail_creation_compte', array('id' => $id)))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * Creates a form to delete a Utilisateur entity.
     *
     * @param Utilisateur $utilisateur The Utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Créer un Form pour activer un utilisateur et redéfinir son mot de passe
     * à utiliser uniquement quand un utilisateur créé ne reçoit pas ou perd le premier mail de confirmation de création de compte.
     */
    private function createActiverEtInitialiserPasswordForm()
    {
        $form = $this->createFormBuilder()
             ->add(
                 'password',
                 RepeatedType::class,
                 array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne sont pas identiques.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                  'constraints' => array(
                          new NotBlank(),
                          new Length(array('min' => 7)), ),
                )
             )
             ->getForm();

        return $form;
    }

    /**
     * Activer un utilisateur et redéfinir son mot de passe
     * !!!! à utiliser uniquement quand un utlisateur n'a pas reçu ou il a perdu le mail de confirmation de création de compte.
     */
    public function activerEtRedefinirPasswordAction(Request $request, Utilisateur $utilisateur)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::ACTIVER_REDEFINIR_MDP, $utilisateur);

        $form = $this->createActiverEtInitialiserPasswordForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // data is an array with "password" key
            $data = $form->getData();
            $userManager = $this->container->get('fos_user.user_manager');
            $utilisateur->setEnabled(true);
            $utilisateur->setConfirmationToken(null);
            $utilisateur->setPlainPassword($data['password']);
            $utilisateur->setNbConnexionKO(0);
            $utilisateur->addRole('ROLE_FORCEPASSWORDCHANGE');

            $userManager->updateUser($utilisateur);

            $message = "L'utilisateur '".$utilisateur->getEmail()."' est activé avec le mot de passe '".$data['password']."' avec succès !";
            $this->get('session')->getFlashBag()->set('notice', $message);

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/activerEtRedefinirPassword.html.twig', array(
                 'form' => $form->createView(),
                 'utilisateur' => $utilisateur,
         ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function choixRoleAction(Request $request, TokenStorageInterface $tokenStorage)
    {
        $form = $this->createForm(ChoixRoleType::class, null, ['tokenStorage' => $tokenStorage]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère le rôle sélectionné
            $role = $form->get('roles')->getData();

            // On retire tous les rôles de l'utilisateur authentifé actuellement sauf le rôle qu'il a choisi
            /* @var $loggedInUser Utilisateur */
            $loggedInUser = $this->getUser();

            $loggedInUser->removeAllRoles();
            $loggedInUser->addRole($role);
            $token = new UsernamePasswordToken($loggedInUser, null, 'main', $loggedInUser->getRoles());
            $tokenStorage->setToken($token);

            // On enregistre le role sélectionné dans la session
            $request->getSession()->set('selectedRole', $role);

            // On récupère l'url demandée par l'utilisateur
            $urlDemandee = $request->getSession()->get('redirect');

            $request->getSession()->set('redirect', $this->generateUrl('accueil'));

            if (empty($urlDemandee) || 0 == strlen($urlDemandee)) {
                $urlDemandee = $this->generateUrl('accueil');
            }

            // On redirige l'utilisateur vers l'url demandée
            return new RedirectResponse($urlDemandee);
        }

        return $this->render('utilisateur/choix_role.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function choixUtilisateurAction(Request $request, TokenStorageInterface $tokenStorage)
    {
        $form = $this->createForm(ChoixUtilisateurType::class, ['utilisateur' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère l'utilsateur sélectionné
            /* @var $switchUtilisateur Utilisateur */
            $switchUtilisateur = $form->get('utilisateur')->getData();

            $token = new UsernamePasswordToken($switchUtilisateur, null, 'main', $switchUtilisateur->getRoles());
            $tokenStorage->setToken($token);

            // On invalide le role sélectionné (au cas où une seconde session était active)
            $request->getSession()->remove('selectedRole');

            // On enregistre l'utilisateur sélectionné dans la session
            $request->getSession()->set('switchUser', $switchUtilisateur);

            // On enregistre les roles de l'utilisateur sélectionné dans la session
            $request->getSession()->set('switchUserRoles', $switchUtilisateur->getRoles());

            // On récupère l'url demandée par l'utilisateur
            $urlDemandee = $request->getSession()->get('redirect');

            return $this->redirect($urlDemandee);
        }

        return $this->render('utilisateur/choix_utilisateur.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Fonction appelée en ajax pour gérer les données du datatables côté serveur.
     *
     * @Security("has_role('ROLE_ADMIN_MIN') or has_role('ROLE_ADMIN')")
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

        /* @var $repository  UtilisateurRepository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Utilisateur');

        // Récupérer le role de l'utilisateur connecté
        $roleSelected = $this->get('session')->get('selectedRole');

        $ministere = null;
        if ('ROLE_ADMIN' == $roleSelected) {
            $ministere = null;
        } elseif ('ROLE_ADMIN_MIN' == $roleSelected) {
            $ministere = $this->getUser()->getMinistere();
        }

        //On récupère tous les utilisateurs (sans condition sur le ministère), si l'action est demandée par l'administrateur
        //Si l'action est demandée par un admin min, on récupère les utilisateurs de son ministère uniquement
        $utilisateurs = $repository->dataTableServerProcessing($search, $start, $length, true, $columnOrder, $dirOrder, $ministere);

        $output = array(
                'data' => array(),
                'recordsFiltered' => $repository->countUtilisateurs($search, $ministere),
                'recordsTotal' => $repository->countUtilisateurs(null, $ministere),
        );

        /* @var $utilisateur Utilisateur */
        foreach ($utilisateurs as $utilisateur) {
            $disableForm = $this->createDisableForm($utilisateur->getId())->createView();
            $unlockForm = $this->createUnlockForm($utilisateur->getId())->createView();
            $renvoiForm = $this->createRenvoiForm($utilisateur->getId())->createView();

            $output['data'][] = [
                    'id' => $utilisateur->getId(),
                    'civilite' => htmlspecialchars(Util::twig_title($utilisateur->getCivilite())),
                    'nom' => htmlspecialchars(Util::twig_upper($utilisateur->getNom())),
                    'prenom' => htmlspecialchars(Util::twig_title($utilisateur->getPrenom())),
                    'email' => htmlspecialchars(Util::twig_lower($utilisateur->getEmail())),
                    'ministere' => htmlspecialchars($utilisateur->getMinistere()->getLibelleCourt()),
                    'locked' => $this->render('utilisateur/lockedUtilisateur.html.twig', ['utilisateur' => $utilisateur])->getContent(),
                    'statut' => $this->render('utilisateur/statutUtilisateur.html.twig', ['utilisateur' => $utilisateur])->getContent(),
                    'derniereConnexion' => $utilisateur->getLastLogin() ? $utilisateur->getLastLogin()->format('Y-m-d H:i:s') : '',
                    'actions' => $this->render('utilisateur/actionsUtilisateur.html.twig', ['utilisateur' => $utilisateur, 'disableForm' => $disableForm, 'unlockForm' => $unlockForm, 'renvoiForm' => $renvoiForm])->getContent(),
            ];
        }

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Fonction appelée en ajax appelée pour rechercher un utilisateur.
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ajaxSearchAction(Request $request)
    {
        $search = $request->get('term');

        $em = $this->getDoctrine()->getManager();

        /* @var $utilisateurRepository UtilisateurRepository */
        $utilisateurRepository = $em->getRepository('AppBundle:Utilisateur');

        $utilisateurs = $utilisateurRepository->searchUtilisateur($search);

        $data = [];

        /* @var $utilisateur Utilisateur */
        foreach ($utilisateurs as $utilisateur) {
            $data[] = ['id' => $utilisateur['id'], 'text' => $utilisateur['email']];
        }

        $output = ['results' => $data];

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Fonction appelée pour renvoyer le mail de création de compte un utilisateur.
     */
    public function renvoiMailCreationCompteAction(Request $request, Utilisateur $utilisateur, AppMailer $appMailer)
    {
        //Voter
        $this->denyAccessUnlessGranted(UtilisateurVoter::RENVOYER_MAIL_CREATION_COMPTE, $utilisateur);

        $form = $this->createRenvoiForm($utilisateur->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $appMailer->sendConfirmationEmailMessage($utilisateur);

            $this->get('session')->getFlashBag()->set('notice', 'Email renvoyé !');
        }

        return $this->redirectToRoute('utilisateur_index');
    }
}
