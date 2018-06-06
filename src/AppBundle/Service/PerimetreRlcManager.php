<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ministere;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PerimetreRlcManager
{
    protected $tokenStorage;

    protected $session;

    protected $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->em = $entityManager;
    }

    /**
     * Permet de récumétre les périmètre d'un ministère.
     *
     * @param Ministere $ministere
     */
    public function getPerimetreRlc(Ministere $ministere)
    {
        return $this->em->getRepository('AppBundle:PerimetreRlc')->findByMinistere($ministere, ['libelle' => 'asc']);
    }

    public function getPerimetresRlc()
    {
        if ('ROLE_ADMIN' === $this->session->get('selectedRole')) {
            return $this->em->getRepository('AppBundle:PerimetreRlc')->findAll();
        } else {
            $ministere = $this->tokenStorage->getToken()->getUser()->getMinistere();

            return $this->em->getRepository('AppBundle:PerimetreRlc')->findByMinistere($ministere, ['libelle' => 'asc']);
        }
    }
}
