<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\UniteOrganisationnelle;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Ministere;
use AppBundle\Repository\UniteOrganisationnelleRepository;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;

class UniteOrganisationnelleVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    // Liste des actions supportées
    const VOIR = 'voir_unite_organisationnelle';
    const MODIFIER = 'modifier_unite_organisationnelle';
    const SUPPRIMER = 'supprimer_unite_organisationnelle';
    const SUPPRIMER_REFERENTIEL = 'supprimer_referentiel_unite_organisationnelle';

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
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type UniteOrganisationnelle ou Ministere, il n'est pas supporté
        if ($subject && !$subject instanceof UniteOrganisationnelle && !$subject instanceof Ministere) {
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
        if ($subject instanceof UniteOrganisationnelle) {
            /* @var $uo UniteOrganisationnelle  */
            $uo = $subject;

            switch ($attribute) {
                case self::VOIR:
                    return $this->peutVoir($uo, $utilisateur);
                case self::MODIFIER:
                    return $this->peutModifier($uo, $utilisateur);
                case self::SUPPRIMER:
                    return $this->peutSupprimer($uo, $utilisateur);
            }
        }

        // Si l'objet passé au voter est de type Ministere
        if ($subject instanceof Ministere) {
            $ministere = $subject;

            switch ($attribute) {
                case self::SUPPRIMER_REFERENTIEL:
                    return $this->peutSupprimerReferentiel($ministere, $utilisateur);
            }
        }

        throw new \LogicException("Erreur de logique dans UniteOrganisationnelleVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutVoir(UniteOrganisationnelle $uo, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que l'uo
        if ($utilisateur->getMinistere() == $uo->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutModifier(UniteOrganisationnelle $uo, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $uo->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(UniteOrganisationnelle $uo, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $uo->getMinistere()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimerReferentiel(Ministere $ministere, Utilisateur $utilisateur)
    {
        // Si l'utilisateur est du même ministere que la formation
        if ($utilisateur->getMinistere() == $ministere) {
            /* @var $uniteOrganisationnelleRepository UniteOrganisationnelleRepository */
            $uniteOrganisationnelleRepository = $this->em->getRepository('AppBundle:UniteOrganisationnelle');

            if ($uniteOrganisationnelleRepository->getNbUnitesOrganisationnelles($ministere) > 0) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
