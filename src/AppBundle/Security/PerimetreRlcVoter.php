<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\PerimetreRlc;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class PerimetreRlcVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    // Liste des actions supportées
    const VIEW = 'view_perimetre_rlc';
    const EDIT = 'edit_perimetre_rlc';
    const DELETE = 'delete_perimetre_rlc';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))) {
            return false;
        }

        // Si l'objet n'est pas de type PerimetreRlc, il n'est pas supporté
        if ($subject && !$subject instanceof PerimetreRlc) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        // Si l'utilisateur est ADMIN, l'accès est accordé
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        /* @var $perimetreRlc PerimetreRlc  */
        $perimetreRlc = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($perimetreRlc, $utilisateur);
            case self::EDIT:
                return $this->canEdit($perimetreRlc, $utilisateur);
            case self::DELETE:
                return $this->canDelete($perimetreRlc, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans RLCVoter : type d'accès ".$attribute.' non géré !');
    }

    private function canView(PerimetreRlc $perimetreRlc, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que le PerimetreRlc
        if ($utilisateur->getMinistere() == $perimetreRlc->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function canEdit(PerimetreRlc $perimetreRlc, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que le PerimetreRlc
        if ($utilisateur->getMinistere() == $perimetreRlc->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function canDelete(PerimetreRlc $perimetreRlc, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que le PerimetreRlc
        if ($utilisateur->getMinistere() == $perimetreRlc->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
