<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use AppBundle\Service\ConstanteManager;

class SessionListener
{
    private $router;
    private $sessionTimeout;

    public function __construct(RouterInterface $router, ConstanteManager $constanteManager)
    {
        $this->router = $router;
        $this->sessionTimeout = $constanteManager->getSessionTimeout();
    }

    public function checkSession(GetResponseEvent $event)
    {
        if ($event->isMasterRequest()) {
            if ($event->getRequest()->isXmlHttpRequest()) {
                return;
            }

            $request = $event->getRequest();
            $session = $request->getSession();
            $session->start();
            $metaData = $session->getMetadataBag();
            $timeDifference = time() - $metaData->getLastUsed();
            $route = $event->getRequest()->get('_route');

            // On désactive le timeout sur la page login
            if ($timeDifference > $this->sessionTimeout && 'fos_user_security_check' != $route) {
                $session->invalidate();
            }
        }
    }
}
