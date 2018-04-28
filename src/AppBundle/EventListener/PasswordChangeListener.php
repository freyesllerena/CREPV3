<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Listener responsible to change the redirection at the end of the password change.
 */
class PasswordChangeListener implements EventSubscriberInterface
{
    private $security_context;
    private $router;
    private $usermanager;

    public function __construct(UrlGeneratorInterface $router, TokenStorage $security_context, UserManager $usermanager)
    {
        $this->security_context = $security_context;
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
        $user = $this->security_context->getToken()->getUser();
        if ($user->hasRole('ROLE_FORCEPASSWORDCHANGE')) {
            $user->removeRole('ROLE_FORCEPASSWORDCHANGE');
            $this->usermanager->updateUser($user);

            $url = $this->router->generate('accueil');
            $event->setResponse(new RedirectResponse($url));
        }
    }
}
