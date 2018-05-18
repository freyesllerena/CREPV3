<?php

namespace AppBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Connexion;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Custom login listener.
 */
class LoginListener
{
    /** @var \Symfony\Component\Security\Core\AuthorizationChecker */
    private $authorizationChecker;
    /** @var \Doctrine\ORM\EntityManager */
    private $em;
    private $userManager;
    private $nbConnexionsAvantBlocage;

    /**
     * Constructor.
     *
     * @param AuthorizationChecker $authorizationChecker
     * @param Doctrine             $doctrine
     * @param UserManager          $userManager
     * @param Parametre_general    $nbConnexionsAvantBlocage
     */
    public function __construct(AuthorizationChecker $authorizationChecker, Doctrine $doctrine, UserManager $userManager, $nbConnexionsAvantBlocage)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->em = $doctrine->getManager();
        $this->userManager = $userManager;
        $this->nbConnexionsAvantBlocage = $nbConnexionsAvantBlocage;
    }

    /**
     * Methode qui s'execute sur une connexion OK.
     *
     * @param InteractiveLoginEvent $event
     */
    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        // On invalide le role sélectionné (au cas où une seconde session était active)
        $event->getRequest()->getSession()->remove('selectedRole');

        // Initialiser l'état du menu à "déployé"
        $event->getRequest()->getSession()->set('deployCollapseMenu', 1);

        // Recuperation du token
        $token = $event->getAuthenticationToken();

        // Recuperation de l'objet Utilisateur
        $user = $token->getUser();

        // Connexion via saisie email / mot de passe
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Remise a zero de ses nombre de tentatives KO
            $user->setNbConnexionKO(0);
        }

        // Connexion via cookie "remember_me"
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // TODO : ajouer un flag pour précisier que c'est une connexion via remember_me
        }

        // Log de la connexion en base de donnees
        $connexion = new Connexion($user);
        $this->em->persist($connexion);
        $this->em->flush();
    }

    /**
     * Methode qui s'execute sur une connexion KO.
     */
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        // Recuperation du token
        $token = $event->getAuthenticationToken();

        // Recuperation de l'identifiant de connexion (email)
        $userEmail = $token->getUsername();

        // Recuperation de l'objet Utilisateur via son email
        $user = $this->userManager->findUserByEmail($userEmail);

        // Si l'utilisateur n'existe pas en base de donnees on quitte la fonction
        if (null === $user) {
            return;
        }

        if (null === $user->getNbConnexionKO()) {
            $user->setNbConnexionKO(0);
        }

        // Incrementaion de ses tentatives de connexion KO
        $user->setNbConnexionKO($user->getNbConnexionKO() + 1);

        // Blocage eventuel de l'utilisateur
        if ($user->getNbConnexionKO() >= $this->nbConnexionsAvantBlocage) {
            $user->setLocked(true);
            // TODO : envoi d'une notification a l'admin
        }

        // Mise a jour de l'objet Utilisateur dans la base de donnees
        $this->userManager->updateUser($user);
    }

    public function onInitPasswordSuccess(FilterUserResponseEvent $event)
    {
        // On invalide la session (au cas où une seconde session était active)
        $event->getRequest()->getSession()->invalidate();

        $user = $event->getUser();

        // Log de la connexion en base de donnees
        $connexion = new Connexion($user);
        $this->em->persist($connexion);
        $this->em->flush();
    }
}
