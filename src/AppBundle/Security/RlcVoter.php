<?php

namespace AppBundle\Security;

use AppBundle\Entity\Rlc;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class RlcVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    // Liste des actions supportées
    const MODIFIER = 'modifier_rlc';
    const SUPPRIMER = 'supprimer_rlc';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
                  self::MODIFIER,
                  self::SUPPRIMER,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type Rlc, il n'est pas supporté
        if ($subject && !$subject instanceof Rlc) {
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

        /* @var $rlc Rlc  */
        $rlc = $subject;

        switch ($attribute) {
            case self::MODIFIER:
                return $this->peutModifier($rlc, $utilisateur);
            case self::SUPPRIMER:
                return $this->peutSupprimer($rlc, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans RlcVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutModifier(Rlc $rlc, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que le Rlc
        if ($utilisateur->getMinistere() == $rlc->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(Rlc $rlc, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que le Rlc
        if ($utilisateur->getMinistere() == $rlc->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
