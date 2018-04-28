<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class SessionListener
{
    private $router;
    private $sessionTimeout;

    public function __construct(Router $router, $sessionTimeout)
    {
        $this->router = $router;
        $this->sessionTimeout = $sessionTimeout;
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
