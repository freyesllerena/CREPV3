<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\UniteOrganisationnelle;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Recours;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\EnumTypes\EnumTypeRecours;

class RecoursVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    protected $session;

    /**
     * @var EntityManager
     */
    protected $em;

    // Liste des actions supportées
    const MODIFIER = 'modifier_recours';
    const SUPPRIMER = 'supprimer_recours';

    public function __construct($decisionManager, Session $session, EntityManager $em)
    {
        $this->decisionManager = $decisionManager;
        $this->session = $session;
        $this->em = $em;
    }

    protected function supports($attribute, $subject)
    {
        // TODO : ligne à suuprimer pour activer les fonctionnalités de recours
        // 		return false;

        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
                  self::MODIFIER,
                  self::SUPPRIMER,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type Recours il n'est pas supporté
        if ($subject && !$subject instanceof Recours) {
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

        // Si l'objet passé au voter est de type UniteOrganisationnelle
        if ($subject instanceof Recours) {
            /* @var $recours Recours  */
            $recours = $subject;

            switch ($attribute) {
                case self::MODIFIER:
                    return $this->peutModifier($recours, $utilisateur);
                case self::SUPPRIMER:
                    return $this->peutSupprimer($recours, $utilisateur);
            }
        }

        throw new \LogicException("Erreur de logique dans RecoursVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutModifier(Recours $recours, Utilisateur $utilisateur)
    {
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if (in_array(
            $recours->getCrep()->getAgent()->getCampagnePnc()->getStatut(),
                [
                        EnumStatutCampagne::OUVERTE,
                        EnumStatutCampagne::CLOTUREE,
                ]
        )) {
            if ('ROLE_BRHP' === $roleUtilisateurSession && EnumTypeRecours::RECOURS_HIERARCHIQUE == $recours->getType()) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                $perimetreBrhpAgent = $recours->getCrep()->getAgent()->getPerimetreBrhp();

                // Si le brhp est responsable du périmètre brhp de l'agent
                foreach ($perimetresBrhp as $perimetreBrhp) {
                    if ($perimetreBrhpAgent == $perimetreBrhp) {
                        if (false == $recours->getDecisionPriseEnCompte()) {
                            return true;
                        }
                    }
                }
            }

            if ('ROLE_RLC' === $roleUtilisateurSession
                && in_array($recours->getType(), [EnumTypeRecours::RECOURS_CAP, EnumTypeRecours::RECOURS_TRIBUNAL_ADMINISTRATIF])) {
                //On récupère le RLC de l'utilisateur
                /** @var $rlc Rlc */
                $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);
                $perimetresRlc = $rlc->getPerimetresRlc()->toArray();

                if (in_array($recours->getCrep()->getAgent()->getPerimetreRlc(), $perimetresRlc)) {
                    if (false == $recours->getDecisionPriseEnCompte()) {
                        return true;
                    }
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(Recours $recours, Utilisateur $utilisateur)
    {
        $roleUtilisateurSession = $this->session->get('selectedRole');
        if (in_array(
            $recours->getCrep()->getAgent()->getCampagnePnc()->getStatut(),
                [
                        EnumStatutCampagne::OUVERTE,
                        EnumStatutCampagne::CLOTUREE,
                ]
        )) {
            if ('ROLE_BRHP' === $roleUtilisateurSession && EnumTypeRecours::RECOURS_HIERARCHIQUE == $recours->getType()) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                $perimetreBrhpAgent = $recours->getCrep()->getAgent()->getPerimetreBrhp();

                // Si le brhp est responsable du périmètre brhp de l'agent
                foreach ($perimetresBrhp as $perimetreBrhp) {
                    if ($perimetreBrhpAgent == $perimetreBrhp) {
                        if (false == $recours->getDecisionPriseEnCompte()) {
                            return true;
                        }
                    }
                }
            }

            if ('ROLE_RLC' === $roleUtilisateurSession
                        && in_array($recours->getType(), [EnumTypeRecours::RECOURS_CAP, EnumTypeRecours::RECOURS_TRIBUNAL_ADMINISTRATIF])) {
                //On récupère le RLC de l'utilisateur
                /** @var $rlc Rlc */
                $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);
                $perimetresRlc = $rlc->getPerimetresRlc()->toArray();

                if (in_array($recours->getCrep()->getAgent()->getPerimetreRlc(), $perimetresRlc)) {
                    if (false == $recours->getDecisionPriseEnCompte()) {
                        return true;
                    }
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
