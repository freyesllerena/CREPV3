<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use FOS\UserBundle\Model\User;
use AppBundle\Util\Menu;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * La calsse MenuListener dispose d'une methode qui s'execute sur un evenement kernel.request pour rafraichir le menu stocke en session.
 */
class MenuListener
{
    private $tokenStorage;
    private $authChecker;
    private $libelleActif;
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authChecker, UrlGeneratorInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authChecker = $authChecker;
        $this->libelleActif = 'Accueil';
        $this->router = $router;
    }

    /**
     * Methode qui s'execute des qu'une page est appelee
     * Elle rafraichit le menu stocke en session.
     *
     * @param GetResponseEvent $event
     */
    public function refreshMenu(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        if (null !== $this->tokenStorage->getToken()) {
            // Recuperation de l'objet Utilisateur
            $user = $this->tokenStorage->getToken()->getUser();

            if (null !== $user && $user instanceof User) {
                // recuperation des roles de l'utilisateur
                //$roles = $user->getRoles();

                // Recuperation du menu en fonction l'utilisateur
                $menu = Menu::getMenu($user, $this->authChecker, $this->router);

                // Activation de l'item correspondant a la route appelee
                $menu = Menu::setActiveMenu($event->getRequest()->attributes->get('_route'), $menu);

                //$menu = Menu::setActiveMenuByLibelle($this->libelleActif, $menu);

                // Enregistrement du menu dans la session
                $event->getRequest()->getSession()->set('menu', $menu);

                // Construction du fil d'Ariane en fonction du menu
                $breadCrumb = Menu::getPathMenu($menu);

                // Enregistrement du fil d'Ariane dans la session
                $event->getRequest()->getSession()->set('breadCrumb', $breadCrumb);
            }
        }
    }
}
