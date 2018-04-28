<?php

namespace AppBundle\Security;

use AppBundle\Entity\Brhp;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;

class BrhpVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    // Liste des actions supportées
    const VIEW = 'view_brhp';
    const EDIT = 'edit_brhp';
    const DELETE = 'delete_brhp';

    public function __construct($decisionManager, EntityManager $em)
    {
        $this->em = $em;
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(self::EDIT, self::DELETE))) {
            return false;
        }

        // Si l'objet n'est pas de type Brhp, il n'est pas supporté
        if ($subject && !$subject instanceof Brhp) {
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

        /* @var $brhp Brhp  */
        $brhp = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($brhp, $utilisateur);
            case self::DELETE:
                return $this->canDelete($brhp, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans BrhpVoter : type d'accès ".$attribute.' non géré !');
    }

    private function canEdit(Brhp $brhp, Utilisateur $utilisateur)
    {
        /* @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->getRlcByEmail($utilisateur->getEmail());

        $perimetresBrhp = $brhp->getPerimetresBrhp();

        // Si l'utilisateur est du même ministere que le Brhp
        if ($utilisateur->getMinistere() === $brhp->getMinistere()) {
            foreach ($perimetresBrhp as $perimetreBrhp) {
                if (in_array($perimetreBrhp->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function canDelete(Brhp $brhp, Utilisateur $utilisateur)
    {
        /** @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->getRlcByEmail($utilisateur->getEmail());

        $perimetresBrhp = $brhp->getPerimetresBrhp();

        // Si l'utilisateur est du même ministere que le Brhp
        if ($utilisateur->getMinistere() === $brhp->getMinistere()) {
            foreach ($perimetresBrhp as $perimetreBrhp) {
                if (in_array($perimetreBrhp->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
