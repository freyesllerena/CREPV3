<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Ministere;
use AppBundle\Repository\FormationRepository;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class FormationVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    // Liste des actions supportées
    const VOIR = 'voir_formation';
    const MODIFIER = 'modifier_formation';
    const SUPPRIMER = 'supprimer_formation';
    const SUPPRIMER_REFERENTIEL = 'supprimer_referentiel_formations';
    const VOIR_REFERENTIEL = 'voir_referentiel_formations';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em)
    {
        $this->decisionManager = $decisionManager;
        $this->em = $em;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
                  self::VOIR,
                  self::MODIFIER,
                  self::SUPPRIMER,
                  self::SUPPRIMER_REFERENTIEL,
                  self::VOIR_REFERENTIEL,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type Formation ou Ministere, il n'est pas supporté
        if ($subject && !$subject instanceof Formation && !$subject instanceof Ministere) {
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

        // Si l'objet passé au voter est de type Formation
        if ($subject instanceof Formation) {
            /* @var $formation Formation  */
            $formation = $subject;

            switch ($attribute) {
                case self::VOIR:
                    return $this->peutVoir($formation, $utilisateur);
                case self::MODIFIER:
                    return $this->peutModifier($formation, $utilisateur);
                case self::SUPPRIMER:
                    return $this->peutSupprimer($formation, $utilisateur);
            }
        }

        // Si l'objet passé au voter est de type Ministere
        if ($subject instanceof Ministere) {
            $ministere = $subject;

            switch ($attribute) {
                case self::SUPPRIMER_REFERENTIEL:
                    return $this->peutSupprimerReferentiel($ministere, $utilisateur);
                case self::VOIR_REFERENTIEL:
                    return $this->peutVoirReferentiel($ministere, $utilisateur);
            }
        }

        throw new \LogicException("Erreur de logique dans FormationVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutVoir(Formation $formation, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $formation->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutModifier(Formation $formation, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $formation->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(Formation $formation, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $formation->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimerReferentiel(Ministere $ministere, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $ministere) {
            /* @var $formationRespository FormationRepository */
            $formationRespository = $this->em->getRepository('AppBundle:Formation');

            if ($formationRespository->getNbFormations($ministere) > 0) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutVoirReferentiel(Ministere $ministere, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $ministere) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
