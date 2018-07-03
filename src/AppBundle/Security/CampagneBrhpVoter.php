<?php

namespace AppBundle\Security;

use AppBundle\Entity\Brhp;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Campagne;
use AppBundle\Repository\AgentRepository;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CampagneBrhpVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $token_storage;

    /* @var $session Session */
    protected $session;

    protected $campagneBrhpManager;

    // Liste des actions supportées
    const MODIFIER = 'modifier_campagne_brhp';
    const VOIR_BRHP = 'voir_brhp_campagne_brhp';
    const VOIR_AH = 'voir_ah_campagne_brhp';
    const VOIR_SHD = 'voir_shd_campagne_brhp';
    const VOIR_AGENT = 'voir_agent_campagne_brhp';
    const ROUVRIR = 'rouvrir_campagne_brhp';
    const OUVRIR_SHD = 'ouvrir_shd_campagne_brhp';
    const SUPPRIMER_DOCUMENT = 'supprimer_document_campagne_brhp';
    const VALIDER_AGENT = 'valider_agent_campagne_brhp';
    const AJOUTER_AGENT = 'ajouter_agent_campagne_brhp';
    const EXPORTER_FORMATIONS = 'exporter_formations_campagne_brhp';
    const EXPORTER_CREPS_FINALISES = 'exporter_creps_finalises_campagne_brhp';

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
            self::VOIR_BRHP,
            self::VOIR_AH,
            self::VOIR_SHD,
            self::VOIR_AGENT,
            self::ROUVRIR,
            self::OUVRIR_SHD,
            self::SUPPRIMER_DOCUMENT,
            self::VALIDER_AGENT,
            self::AJOUTER_AGENT,
            self::EXPORTER_FORMATIONS,
            self::EXPORTER_CREPS_FINALISES,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type CampagneBrhp, il n'est pas supporté
        if ($subject && !$subject instanceof CampagneBrhp) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        /* @var $campagneBrhp CampagneBrhp  */
        $campagneBrhp = $subject;

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

        // Si aucune CampagneBrhp ont refuse l'accès
        if (!$campagneBrhp || !$campagneBrhp instanceof CampagneBrhp) {
            return false;
        }

        if ($utilisateur->getMinistere()->getId() != $campagneBrhp->getMinistere()->getId()) {
            return false;
        }

        switch ($attribute) {
            case self::MODIFIER:
                return $this->peutModifier($campagneBrhp, $utilisateur);
            case self::VOIR_BRHP:
                return $this->peutBrhpVoir($campagneBrhp, $utilisateur);
            case self::VOIR_AH:
                return $this->peutAhVoir($campagneBrhp, $utilisateur);
            case self::VOIR_SHD:
                return $this->peutShdVoir($campagneBrhp, $utilisateur);
            case self::VOIR_AGENT:
                return $this->peutAgentVoir($campagneBrhp, $utilisateur);
            case self::ROUVRIR:
                return $this->peutRouvrir($campagneBrhp, $utilisateur);
            case self::OUVRIR_SHD:
                return $this->peutOuvrirShd($campagneBrhp, $utilisateur);
            case self::SUPPRIMER_DOCUMENT:
                return $this->peutSupprimerDocument($campagneBrhp, $utilisateur);
            case self::VALIDER_AGENT:
                return $this->peutValiderAgent($campagneBrhp, $utilisateur);
            case self::AJOUTER_AGENT:
                return $this->peutAjouterAgent($campagneBrhp, $utilisateur);
            case self::EXPORTER_FORMATIONS:
                return $this->peutExporterFormations($campagneBrhp, $utilisateur);
            case self::EXPORTER_CREPS_FINALISES:
                return $this->peutExporterCrepsFinalises($campagneBrhp, $utilisateur, $roleUtilisateurSession);
        }

        throw new \LogicException("Erreur de logique dans CampagneBrhpVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutRouvrir(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        /* @var $brhp Brhp */
        $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

        if ((EnumStatutCampagne::CLOTUREE === $campagneBrhp->getStatut()
                // On ne peut rouvrir une campagne brhp que si la campagne rlc a été rouverte
                && EnumStatutCampagne::OUVERTE === $campagneBrhp->getCampagneRlc()->getStatut()
                && 'ROLE_BRHP' === $roleUtilisateurSession
                && $campagneBrhp->getDateOuverture()) // La campagne était ouverte avant la clôture
                && in_array($campagneBrhp->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
            return true;
        }

        return false;
    }

    private function peutModifier(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            /** @var $brhp Brhp */
            $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

            if (in_array($campagneBrhp->getStatut(), array(
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE,
            ))
                && in_array($campagneBrhp->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                return true;
            }
        }

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            if ($this->peutShdVoir($campagneBrhp, $utilisateur)
                && in_array($campagneBrhp->getStatut(), array(
                    EnumStatutCampagne::INITIALISEE,
                    EnumStatutCampagne::CREEE,
                    EnumStatutCampagne::OUVERTE,
                    ))) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutBrhpVoir(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        if ('ROLE_BRHP' === $this->session->get('selectedRole')) {
            /** @var $brhp Brhp */
            $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP
            if ($brhp->getPerimetresBrhp()->contains($campagneBrhp->getPerimetreBrhp())) {
                return true;
            }
        }

        if ('ROLE_BRHP_CONSULT' === $this->session->get('selectedRole')) {
            /** @var $brhp Brhp */
            $brhpConsult = $this->em->getRepository('AppBundle:BrhpConsult')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP Consult
            if ($brhpConsult->getPerimetresBrhp()->contains($campagneBrhp->getPerimetreBrhp())) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutAhVoir(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        // FIXME : les ah sont selectionnés en se basant sur leur adresse email ce qui est une erreur
        // Il faudrait se baser sur leur compte utilisateur
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        if ($agentRepository->isAh($utilisateur->getEmail(), $campagneBrhp)) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutShdVoir(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        // FIXME : les ah sont selectionnés en se basant sur leur adresse email ce qui est une erreur
        // Il faudrait se baser sur leur compte utilisateur
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        if ($agentRepository->isShd($utilisateur, $campagneBrhp)) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutAgentVoir(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');
        $agent = $agentRepository->getAgentByEmail($utilisateur->getEmail(), $campagneBrhp);

        // Si l'utilisateur n'est pas présent dans la campagne Brhp
        if ($agent) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutOuvrirShd(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_BRHP' !== $roleUtilisateurSession && 'ROLE_ADMIN' !== $roleUtilisateurSession) {
            return false;
        }

        /** @var $brhp Brhp */
        $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

        //Si la population d'agents n'a pas encore été diffusée par l'AM, il n'est pas possible d'ouvrir la campagne aux N+1
        if ($campagneBrhp->getCampagnePnc()->getDiffusee()) {
            if (EnumStatutCampagne::CREEE == $campagneBrhp->getStatut()
                    && in_array($campagneBrhp->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())
                    && null == $campagneBrhp->getDateOuverture()) { //Pour les campagnes jamais ouvertes
                return true;
            }

            if (EnumStatutCampagne::CLOTUREE === $campagneBrhp->getStatut()
                    // On ne peut rouvrir une campagne brhp que si la campagne rlc a été rouverte
                    && EnumStatutCampagne::OUVERTE === $campagneBrhp->getCampagneRlc()->getStatut()
                    && !$campagneBrhp->getDateOuverture() // La campagne n'a jamais été ouverte
                    && in_array($campagneBrhp->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimerDocument(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /** @var $brhp Brhp */
        $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

        if (in_array($campagneBrhp->getStatut(), array(
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE,
            ))
            && in_array($campagneBrhp->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutValiderAgent(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_SHD' == $roleUtilisateurSession && EnumStatutCampagne::OUVERTE == $campagneBrhp->getStatut()) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutAjouterAgent(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_BRHP' == $roleUtilisateurSession
            && in_array($campagneBrhp->getStatut(), [
                    EnumStatutCampagne::CREEE,
                    EnumStatutCampagne::OUVERTE, ])) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutExporterFormations(CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_BRHP' == $roleUtilisateurSession
                && in_array($campagneBrhp->getStatut(), [
                        EnumStatutCampagne::OUVERTE,
                        EnumStatutCampagne::CLOTUREE,
                        EnumStatutCampagne::FERMEE,
                ])) {
            /** @var $brhp Brhp */
            $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP
            if ($brhp->getPerimetresBrhp()->contains($campagneBrhp->getPerimetreBrhp())) {
                return true;
            }
        }

        if ('ROLE_BRHP_CONSULT' == $roleUtilisateurSession
                && in_array($campagneBrhp->getStatut(), [
                        EnumStatutCampagne::OUVERTE,
                        EnumStatutCampagne::CLOTUREE,
                        EnumStatutCampagne::FERMEE,
                ])) {
            /** @var $brhp Brhp */
            $brhpConsult = $this->em->getRepository('AppBundle:BrhpConsult')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP Consult
            if ($brhpConsult->getPerimetresBrhp()->contains($campagneBrhp->getPerimetreBrhp())) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    // Exporter l'ensemble des CREPs finalisés
    private function peutExporterCrepsFinalises(CampagneBrhp $campagne, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        //l'avaluateur est soit le N+1 ou le N+2
        $evaluateur = $agentRepository->getAgentByEmail($utilisateur->getEmail(), $campagne->getCampagnePnc());

        $nbAgentsAyantCrepFinalise = $agentRepository->getNbAgentsAyantCrepFinalise($campagne, $roleUtilisateurSession, $evaluateur);

        //S'il n'y a pas de CREPs finalisés retourner false
        if ($nbAgentsAyantCrepFinalise > 0) {
            if ('ROLE_BRHP' == $roleUtilisateurSession) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP
                if ($brhp->getPerimetresBrhp()->contains($campagne->getPerimetreBrhp())) {
                    return true;
                }
            }

            if ('ROLE_BRHP_CONSULT' == $roleUtilisateurSession) {
                //On récupère le BRHP Consult de l'utilisateur
                /** @var $brhpConsult BrhpConsult */
                $brhpConsult = $this->em->getRepository('AppBundle:BrhpConsult')->findOneByUtilisateur($utilisateur);

                // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP Consult
                if ($brhpConsult->getPerimetresBrhp()->contains($campagne->getPerimetreBrhp())) {
                    return true;
                }
            }

            if ('ROLE_SHD' == $roleUtilisateurSession) {
                //TODO: A compléter ...
                return true;
            }

            if ('ROLE_AH' === $roleUtilisateurSession) {
                //TODO: A compléter ...
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
