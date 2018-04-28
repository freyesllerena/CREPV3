<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *  Listener responsible to change the redirection at the end of the password resetting.
 */
class PasswordResettingListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     *  {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResettingSuccess',
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onPasswordChangeSuccess',
        );
    }

    public function onPasswordResettingSuccess(FormEvent $event)
    {
        $url = $this->router->generate('accueil');
        $request = $event->getRequest();
        $request->getSession()->getFlashBag()->set('notice', 'Votre mot de passe a été modifié avec succès !');

        $event->setResponse(new RedirectResponse($url));
    }

    public function onPasswordChangeSuccess(FormEvent $event)
    {
        $idUser = $event->getForm()->getData()->getId();
        $url = $this->router->generate('utilisateur_show', array('id' => $idUser));
        $request = $event->getRequest();
        $request->getSession()->getFlashBag()->set('notice', 'Votre mot de passe a été modifié avec succès !');

        $event->setResponse(new RedirectResponse($url));
    }
}
