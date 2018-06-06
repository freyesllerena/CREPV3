<?php

namespace AppBundle\Service;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class BaseManager
{
    /* @var $em EntityManager */
    protected $em;
    protected $logger;
    protected $authorizationChecker;
    protected $securityTokenStorage;
    protected $validator;
    protected $session;
    protected $router;
    protected $appMailer;
    protected $kernelRootDir;

    public function __construct(Doctrine $doctrine, AuthorizationChecker $authorizationChecker, $securityTokenStorage, Logger $logger, TraceableValidator $validator, SessionInterface $session, RouterInterface $router, AppMailer $appMailer, $kernelRootDir)
    {
        $this->em = $doctrine->getManager();
        $this->logger = $logger;
        $this->authorizationChecker = $authorizationChecker;
        $this->securityTokenStorage = $securityTokenStorage;
        $this->validator = $validator;
        $this->session = $session;
        $this->router = $router;
        $this->appMailer = $appMailer;
        $this->kernelRootDir = $kernelRootDir;
    }
}
