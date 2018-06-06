<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Listener responsible to change the redirection at the end of the password change.
 */
class PasswordChangeListener implements EventSubscriberInterface
{
    private $tokenStorage;
    private $router;
    private $usermanager;

    public function __construct(UrlGeneratorInterface $router, TokenStorageInterface $tokenStorage, UserManager $usermanager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->usermanager = $usermanager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
                FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePasswordSuccess',
        );
    }

    /**
     *  Retirer le rôle "ROLE_FORCEPASSWORDCHANGE" de l'utilisateur (initialisé et activé par l'admin) après qu'il modifie son nouveau mot de passe.
     */
    public function onChangePasswordSuccess(FormEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user->hasRole('ROLE_FORCEPASSWORDCHANGE')) {
            $user->removeRole('ROLE_FORCEPASSWORDCHANGE');
            $this->usermanager->updateUser($user);

            $url = $this->router->generate('accueil');
            $event->setResponse(new RedirectResponse($url));
        }
    }
}
