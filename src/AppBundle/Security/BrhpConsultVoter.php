<?php

namespace AppBundle\Security;

use AppBundle\Entity\BrhpConsult;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;

class BrhpConsultVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    // Liste des actions supportées
    const VIEW = 'view_brhp_consult';
    const EDIT = 'edit_brhp_consult';
    const DELETE = 'delete_brhp_consult';

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

        // Si l'objet n'est pas de type BrhpConsult, il n'est pas supporté
        if ($subject && !$subject instanceof BrhpConsult) {
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

        /* @var $brhp BrhpConsult  */
        $brhpConsult = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($brhpConsult, $utilisateur);
            case self::DELETE:
                return $this->canDelete($brhpConsult, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans BrhpConsultVoter : type d'accès ".$attribute.' non géré !');
    }

    private function canEdit(BrhpConsult $brhpConsult, Utilisateur $utilisateur)
    {
        /* @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetresBrhp = $brhpConsult->getPerimetresBrhp();

        // Si l'utilisateur est du même ministere que le BrhpConsult
        if ($utilisateur->getMinistere() === $brhpConsult->getMinistere()) {
            foreach ($perimetresBrhp as $perimetreBrhp) {
                if (in_array($perimetreBrhp->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function canDelete(BrhpConsult $brhpConsult, Utilisateur $utilisateur)
    {
        /** @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        $perimetresBrhp = $brhpConsult->getPerimetresBrhp();

        // Si l'utilisateur est du même ministere que le BrhpConsult
        if ($utilisateur->getMinistere() === $brhpConsult->getMinistere()) {
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
