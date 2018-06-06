<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UtilisateurVoter extends Voter
{
    /**
     * @var AccessDecisionManager
     */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Session
     */
    protected $session;

    // Liste des actions supportées
    const CREER = 'creer_utilisateur';
    const VOIR = 'voir_utilisateur';
    const MODIFIER = 'modifier_utilisateur';
    const ACTIVER_REDEFINIR_MDP = 'activer_redefinir_mdp_utilisateur';
    const DESACTIVER = 'desactiver_utilisateur';
    const DEBLOQUER = 'debloquer_utilisateur';
    const RENVOYER_MAIL_CREATION_COMPTE = 'renvoyer_mail_creation_compte_utilisateur';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->decisionManager = $decisionManager;
        $this->em = $em;
        $this->session = $session;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
            self::CREER,
            self::VOIR,
            self::MODIFIER,
            self::ACTIVER_REDEFINIR_MDP,
            self::DESACTIVER,
            self::DEBLOQUER,
            self::RENVOYER_MAIL_CREATION_COMPTE,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type Utilisateur, il n'est pas supporté
        if ($subject && !($subject instanceof Utilisateur)) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateurCourant = $token->getUser();

        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if (!$utilisateurCourant instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        /* @var $utilisateur Utilisateur */
        $utilisateur = $subject;

        switch ($attribute) {
            case self::CREER:
                return $this->peutCreer($roleUtilisateurSession);
            case self::VOIR:
                return $this->peutVoir($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
            case self::MODIFIER:
                return $this->peutModifier($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
            case self::ACTIVER_REDEFINIR_MDP:
                return $this->peutActiverRedefinirMdp($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
            case self::DESACTIVER:
                return $this->peutDesactiver($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
            case self::DEBLOQUER:
                return $this->peutDebloquer($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
            case self::RENVOYER_MAIL_CREATION_COMPTE:
                return $this->peutRenvoyerMailCreationCmpte($utilisateur, $utilisateurCourant, $roleUtilisateurSession);
        }

        throw new \LogicException("Erreur de logique dans UtilisateurVoter : type d'accès ".$attribute.' non géré !');
    }

    // Seul l'ADMIN peut créer les comptes utilisateurs
    private function peutCreer($roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession) {
            return true;
        }

        return false;
    }

    // l'ADMIN et l'utilisateur lui même peuvent voir le compte utilisateur
    private function peutVoir(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession) {
            return true;
        }

        if ('ROLE_ADMIN_MIN' == $roleUtilisateurSession && $utilisateur->getMinistere() == $utilisateurCourant->getMinistere()) {
            return true;
        }

        if ($utilisateur === $utilisateurCourant) {
            return true;
        }

        return false;
    }

    // Seul l'ADMIN peut modifier les comptes utilisateurs
    private function peutModifier(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession) {
            return true;
        }

        return false;
    }

    // Seul l'ADMIN peut activer les comptes utilisateurs
    private function peutActiverRedefinirMdp(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession) {
            return true;
        }

        return false;
    }

    // Seul l'ADMIN peut désactiver les comptes utilisateurs actifs
    private function peutDesactiver(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession && $utilisateur->isAccountEnabled()) {
            return true;
        }

        return false;
    }

    // Seul l'ADMIN peut débloquer les comptes utilisateurs bloqués
    private function peutDebloquer(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession && $utilisateur->isLocked()) {
            return true;
        }

        if ('ROLE_ADMIN_MIN' == $roleUtilisateurSession
             && $utilisateur->getMinistere() == $utilisateurCourant->getMinistere()
             && $utilisateur->isLocked()) {
            return true;
        }

        return false;
    }

    private function peutRenvoyerMailCreationCmpte(Utilisateur $utilisateur, Utilisateur $utilisateurCourant, $roleUtilisateurSession)
    {
        if ('ROLE_ADMIN' == $roleUtilisateurSession && $utilisateur->getConfirmationToken()) {
            return true;
        }

        if ('ROLE_ADMIN_MIN' == $roleUtilisateurSession
            && $utilisateur->getMinistere() == $utilisateurCourant->getMinistere()
            && $utilisateur->getConfirmationToken()) {
            return true;
        }

        return false;
    }
}
