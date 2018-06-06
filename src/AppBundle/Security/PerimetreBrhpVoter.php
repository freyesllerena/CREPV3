<?php

namespace AppBundle\Security;

use AppBundle\Entity\Rlc;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\PerimetreBrhp;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Brhp;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PerimetreBrhpVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $session;

    // Liste des actions supportées
    const MODIFIER = 'modifier_perimetre_brhp';
    const VOIR = 'voir_perimetre_brhp';
    const SUPPRIMER = 'supprimer_perimetre_brhp';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->decisionManager = $decisionManager;
        $this->session = $session;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
              self::MODIFIER,
              self::VOIR,
              self::SUPPRIMER,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type PerimetreBrhp, il n'est pas supporté
        if ($subject && !$subject instanceof PerimetreBrhp) {
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

        /* @var $perimetreBrhp PerimetreBrhp  */
        $perimetreBrhp = $subject;

        switch ($attribute) {
            case self::MODIFIER:
                return $this->peutModifier($perimetreBrhp, $utilisateur);
            case self::VOIR:
                return $this->peutVoir($perimetreBrhp, $utilisateur);
            case self::SUPPRIMER:
                return $this->peutSupprimer($perimetreBrhp, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans PerimetreBrhpVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutModifier(PerimetreBrhp $perimetreBrhp, Utilisateur $utilisateur)
    {
        /* @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        // Si l'utilisateur est du même ministere que le celui du PerimetreBrhp
        if ($utilisateur->getMinistere() === $perimetreBrhp->getPerimetreRlc()->getMinistere()
            && $rlc->getPerimetresRlc()->contains($perimetreBrhp->getPerimetreRlc())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutVoir(PerimetreBrhp $perimetreBrhp, Utilisateur $utilisateur)
    {
        $roleUtilisateurSession = $this->session->get('selectedRole');

        // Si l'utilisateur est du même ministere que le celui du PerimetreBrhp
        if ($utilisateur->getMinistere() === $perimetreBrhp->getPerimetreRlc()->getMinistere()) {
            if ('ROLE_RLC' == $roleUtilisateurSession) {
                /* @var $rlc Rlc */
                $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

                if ($rlc->getPerimetresRlc()->contains($perimetreBrhp->getPerimetreRlc())) {
                    return true;
                }
            } elseif ('ROLE_BRHP' === $roleUtilisateurSession || 'ROLE_BRHP_CONSULT' === $roleUtilisateurSession) {
                /* @var $brhp Brhp */
                $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

                // Si le BRHP est responsable de $perimetreBrhp
                if ($brhp->getPerimetresBrhp()->contains($perimetreBrhp)) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(PerimetreBrhp $perimetreBrhp, Utilisateur $utilisateur)
    {
        /*@var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        // Si l'utilisateur est du même ministere que le celui du PerimetreBrhp
        if ($utilisateur->getMinistere() === $perimetreBrhp->getPerimetreRlc()->getMinistere()
            && $rlc->getPerimetresRlc()->contains($perimetreBrhp->getPerimetreRlc())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
