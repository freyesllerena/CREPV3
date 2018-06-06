<?php

namespace AppBundle\Security;

use AppBundle\Entity\Rlc;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\CampagneRlc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CampagneRlcVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;
    protected $session;

    // Liste des actions supportées
    const MODIFIER = 'modifier_campagne_rlc';
    const VOIR = 'voir_campagne_rlc';
    const OUVRIR = 'ouvrir_campagne_rlc';
    const ROUVRIR = 'rouvrir_campagne_rlc';
    const SUPPRIMER_DOCUMENT = 'supprimer_document_campagne_rlc';

    const AJOUTER_AGENT = 'ajouter_agent_campagne_rlc';

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
            self::OUVRIR,
            self::ROUVRIR,
            self::SUPPRIMER_DOCUMENT,
            self::AJOUTER_AGENT,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type CampagneRlc, il n'est pas supporté
        if ($subject && !$subject instanceof CampagneRlc) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        /* @var $campagneRlc CampagneRlc  */
        $campagneRlc = $subject;

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        // Si l'utilisateur est ADMIN, l'accès est accordé
        if ($this->decisionManager->decide($token, array(
            'ROLE_ADMIN',
        ))) {
            return true;
        }

        // Si l'utilisateur n'est pas du même ministere que la CampagneRlc
        if ($utilisateur->getMinistere() != $campagneRlc->getMinistere()) {
            return false;
        }

        switch ($attribute) {
            case self::MODIFIER:
                return $this->peutModifier($campagneRlc, $utilisateur);
            case self::VOIR:
                return $this->peutVoir($campagneRlc, $utilisateur);
            case self::OUVRIR:
                return $this->peutOuvrir($campagneRlc, $utilisateur);
            case self::ROUVRIR:
                return $this->peutRouvrir($campagneRlc, $utilisateur);
            case self::SUPPRIMER_DOCUMENT:
                return $this->peutSupprimerDocument($campagneRlc, $utilisateur);
            case self::AJOUTER_AGENT:
                return $this->peutAjouterAgent($campagneRlc, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans CampagneRlcVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutRouvrir(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        /* @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        if ((EnumStatutCampagne::CLOTUREE === $campagneRlc->getStatut()
                // On ne peut rouvrir une campagne rlc que si la campagne pnc a été rouverte
                && EnumStatutCampagne::OUVERTE === $campagneRlc->getCampagnePnc()->getStatut()
                && $campagneRlc->getDateOuverture() // La campagne était ouverte avant la clôture
                && !empty($campagneRlc->getPerimetresBrhp()) // La campagne doit avoir des périmètres Brhp
                && 'ROLE_RLC' === $roleUtilisateurSession
                && $utilisateur->getMinistere() === $campagneRlc->getMinistere())
                && in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        return false;
    }

    private function peutModifier(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        /* @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        if (in_array($campagneRlc->getStatut(), array(
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE,
                EnumStatutCampagne::CLOTUREE, //Pour gérer le cas des CampagneRlc jamais ouvertes
            ))
            && in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutVoir(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        /** @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        if (in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutOuvrir(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        /** @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if (EnumStatutCampagne::CREEE == $campagneRlc->getStatut()
            && 0 != count($campagneRlc->getPerimetresBrhp()) // La campagne doit avoir des périmètres Brhp
            && in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        if (EnumStatutCampagne::CLOTUREE === $campagneRlc->getStatut()
            // On ne peut ouvrir une campagne rlc que si la campagne pnc a été rouverte
            && EnumStatutCampagne::OUVERTE === $campagneRlc->getCampagnePnc()->getStatut()
            && 0 != count($campagneRlc->getPerimetresBrhp()) // La campagne doit avoir des périmètres Brhp
            && !$campagneRlc->getDateOuverture() // La campagne n'a jamais été ouverte
            && 'ROLE_RLC' === $roleUtilisateurSession
            && in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimerDocument(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        /** @var $rlc Rlc */
        $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

        if (in_array($campagneRlc->getStatut(), array(
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE,
            ))
            && in_array($campagneRlc->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutAjouterAgent(CampagneRlc $campagneRlc, Utilisateur $utilisateur)
    {
        if (in_array($campagneRlc->getStatut(), [
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE, ])
                && $utilisateur->getMinistere() === $campagneRlc->getMinistere()) {
            return true;
        }

        return false;
    }
}
