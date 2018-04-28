<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RequestListener
{
    private $securityContext;
    private $securityAuthorizationChecker;
    private $router;

    public function __construct(TokenStorage $securityContext, AuthorizationChecker $securityAuthorizationChecker, Router $router)
    {
        $this->securityContext = $securityContext;
        $this->securityAuthorizationChecker = $securityAuthorizationChecker;
        $this->router = $router;
    }

    public function checkRole(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($event->getRequest()->isXmlHttpRequest()) {
            // Enregistrement de la session dans la cas d'un appel AJAX
            // Ceci permet aux requetes AJAX de s'executer en parallèle
            // Sans cela, la requête n° devra attendre la réponse de la requête n°1
            // et ainsi de suite
            $request = $event->getRequest();
            $session = $request->getSession();
            $session->save();

            return;
        }

        $route = $event->getRequest()->get('_route');

        if ('_' == substr($route, 0, 1)) {
            return;
        }

        if (!$this->securityAuthorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }

        if (null !== $this->securityContext->getToken()
                && !in_array($route, [
                        'utilisateur_choix_role',
                        'utilisateur_choix_utilisateur',
                        'utilisateur_ajax_search',
                ])) {
            // Recuperation de l'objet Utilisateur
            /* @var $utilisateur Utilisateur */
            $utilisateur = $this->securityContext->getToken()->getUser();

            $session = $event->getRequest()->getSession();

            if ('fos_user_change_password' != $route) {
                // Forcer l'utilisateur à changer son nouveau mot de passe qui lui a été attribué par l'admin
                if ($utilisateur->hasRole('ROLE_FORCEPASSWORDCHANGE')) {
                    $response = new RedirectResponse($this->router->generate('fos_user_change_password'));
                    $event->setResponse($response);

                    return;
                }
            }

            /* @var $rc RequestContext */
            $context = $this->router->getContext();
            $urlDemandee = $context->getBaseUrl().$context->getPathInfo();

            // On récupère le rôle que l'utilisateur avait choisi et qui a été enregistré dans la session
            $selectedRole = $session->get('selectedRole');

            // Si l'utilisateur n'a pas selectionné son rôle utilisateur
            if (!$selectedRole && 'fos_user_change_password' != $route) {
                // Si l'utilisateur est admin
                if ($utilisateur->hasRole('ROLE_ADMIN')) {
                    // enregisrement de l'url demandée dans la session
                    $session->set('redirect', $urlDemandee);

                    $swithUser = $session->get('switchUser');
                    $swithUserRoles = $session->get('switchUserRoles');

                    if (!$swithUser) {
                        // redirection vers la page de selection d'utilisateur
                        $urlCible = $this->router->generate('utilisateur_choix_utilisateur');
                        $event->setResponse(new RedirectResponse($urlCible));
                    } elseif (in_array('ROLE_ADMIN', $swithUserRoles)) {
                        $session->set('selectedRole', 'ROLE_ADMIN');
                    }
                }
                // Sinon si l'utilisateur dispose de plusieurs rôles
                elseif (count($utilisateur->getRoles()) > 2) {
                    $session->set('redirect', $urlDemandee);

                    // redirection vers la page de selection de rôle
                    $urlCible = $this->router->generate('utilisateur_choix_role');
                    $event->setResponse(new RedirectResponse($urlCible));
                } else {
                    // l'utilisateur ne dispose pas de plusieurs roles
                    // On lui attribue le ROLE par defaut (autre que ROLE_USER)
                    $roles = $utilisateur->getRoles();

                    $role = $roles[0];
                    if ('ROLE_USER' == $role) {
                        $role = $roles[1];
                    }
                    $session->set('selectedRole', $role);
                }
            }
        }
    }
}
