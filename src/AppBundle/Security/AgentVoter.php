<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\Agent;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Brhp;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\Rlc;
use AppBundle\EnumTypes\EnumStatutCrep;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AgentVoter extends Voter
{
    /**
     * @var AccessDecisionManager
     */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Session
     */
    protected $session;

    protected $agent;

    protected $campagneBrhp;

    protected $campagneRlc;

    protected $campagnePnc;

    // Liste des actions supportées
    //const AJOUTER = 'ajouter_agent';
    const MODIFIER = 'modifier_agent';
    const VOIR = 'voir_agent';
    const DETACHER_PERIMETRE_BRHP = 'detacher_perimetre_agent';
    const RATTACHER_PERIMETRE_BRHP = 'rattacher_perimetre_agent';
    const RATTACHER_SHD = 'rattacher_shd_agent';
    const DETACHER_SHD = 'detacher_shd_agent';

    const DETACHER_PERIMETRE_RLC = 'detacher_perimetre_rlc';
    const RATTACHER_PERIMETRE_RLC = 'rattacher_perimetre_rlc';

    const IMPORTER_CREP_PAPIER = 'importer_crep_papier';
    const SUPPRIMER_CREP_PAPIER = 'supprimer_crep_papier';
    const VOIR_CREP_PAPIER = 'voir_crep_papier';

    const CHOISIR_CREP = 'choisir_crep';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->decisionManager = $decisionManager;
        $this->em = $em;
        $this->session = $session;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
            self::MODIFIER,
            self::VOIR,
            self::DETACHER_PERIMETRE_BRHP,
            self::RATTACHER_PERIMETRE_BRHP,
            self::RATTACHER_SHD,
            self::DETACHER_SHD,
            self::DETACHER_PERIMETRE_RLC,
            self::RATTACHER_PERIMETRE_RLC,
            self::IMPORTER_CREP_PAPIER,
            self::SUPPRIMER_CREP_PAPIER,
            self::CHOISIR_CREP,
            self::VOIR_CREP_PAPIER,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type Agent, il n'est pas supporté
        if ($subject
            && self::RATTACHER_PERIMETRE_BRHP != $attribute
            && self::RATTACHER_PERIMETRE_RLC != $attribute
            && self::RATTACHER_SHD != $attribute
            && !($subject instanceof Agent)) {
            return false;
        }

        // Si le voter est appelé par RATTACHER_PERIMETRE_BRHP
        if ($subject && in_array($attribute, [self::RATTACHER_PERIMETRE_BRHP, self::RATTACHER_SHD])) {
            //Si l'objet passé en 1er parmètre n'est pas de type Agent
            if (!$subject['agent'] || !$subject['agent'] instanceof Agent) {
                return false;
            }
            //Si l'objet passé en 2e parmètre n'est pas de type CampagneBrhp
            if (!$subject['campagneBrhp'] || !$subject['campagneBrhp'] instanceof CampagneBrhp) {
                return false;
            }
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        /* @var $roleUtilisateurSession string */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        /* @var $agent Agent  */
        if ($subject instanceof Agent) {
            $agent = $subject;
        } else {
            if (in_array($attribute, [self::RATTACHER_PERIMETRE_BRHP, self::RATTACHER_SHD])) {
                $campagneBrhp = $subject['campagneBrhp'];
                $agent = $subject['agent'];
            }
        }

        // Si l'utilisateur n'est pas ADMIN et n'est pas du même ministere que l'agent
//         if (!$utilisateur->hasRole('ROLE_ADMIN') && $utilisateur->getMinistere()->getId() != $agent->getCampagnePnc()->getMinistere()->getId()) {
//             return false;
//         }

        switch ($attribute) {
            case self::MODIFIER:
                return $this->peutModifier($agent, $utilisateur, $roleUtilisateurSession);
            case self::VOIR:
                return $this->peutVoir($agent, $utilisateur, $roleUtilisateurSession);
            case self::DETACHER_PERIMETRE_BRHP:
                return $this->peutDetacherPerimetreBrhp($agent, $utilisateur, $roleUtilisateurSession);
            case self::RATTACHER_PERIMETRE_BRHP:
                return $this->peutRattacherPerimetreBrhp($agent, $campagneBrhp, $utilisateur, $roleUtilisateurSession);
            case self::RATTACHER_SHD:
                return $this->peutRattacherShd($agent, $campagneBrhp, $utilisateur, $roleUtilisateurSession);
            case self::DETACHER_SHD:
                return $this->peutDetacherShd($agent, $utilisateur, $roleUtilisateurSession);
            case self::DETACHER_PERIMETRE_RLC:
                return $this->peutDetacherPerimetreRlc($agent, $utilisateur, $roleUtilisateurSession);
            case self::RATTACHER_PERIMETRE_RLC:
                return $this->peutRattacherPerimetreRlc($agent, $utilisateur, $roleUtilisateurSession);
            case self::IMPORTER_CREP_PAPIER:
                return $this->peutImporterCrepPapier($agent, $utilisateur, $roleUtilisateurSession);
            case self::SUPPRIMER_CREP_PAPIER:
                return $this->peutSupprimerCrepPapier($agent, $utilisateur, $roleUtilisateurSession);
            case self::CHOISIR_CREP:
                return $this->peutChoisirCrep($agent, $utilisateur, $roleUtilisateurSession);
            case self::VOIR_CREP_PAPIER:
                return $this->peutVoirCrepPapier($agent, $utilisateur, $roleUtilisateurSession);
        }

        throw new \LogicException("Erreur de logique dans AgentVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutVoirCrepPapier($agent, $utilisateur, $roleUtilisateurSession)
    {
        if ($agent->getCrep() && $agent->getCrep()->getCrepPapier()) {
            if ('ROLE_AGENT' === $roleUtilisateurSession) {
                if ($utilisateur === $agent->getUtilisateur()) {
                    return true;
                }
            }

            if ('ROLE_SHD' === $roleUtilisateurSession) {
                if ($utilisateur === $agent->getShd()->getUtilisateur()) {
                    return true;
                }
            }

            if ('ROLE_AH' === $roleUtilisateurSession) {
                if ($utilisateur === $agent->getAh()->getUtilisateur()) {
                    return true;
                }
            }

            // Si l'utilisateur a un role BRHP, on fait une condition sur les périmètres uniquement.
            // Il n'est pas nécessaire de vérifier le statut, car un crep papier ne peut avoir que 3 statuts de toutes manières
            // (notifié agent, refus de notification de l'agent)

            if ('ROLE_BRHP' === $roleUtilisateurSession || 'ROLE_BRHP_CONSULT' === $roleUtilisateurSession) {
                /** @var $brhp Brhp */
                $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

                if (in_array($agent->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                    return true;
                }
            }
        }

        return false;
    }

    private function peutChoisirCrep(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            if (!$agent->getCrep()) {
                return true;
            }
        }

        if ('ROLE_SHD' === $roleUtilisateurSession) {
            // On peut choisir un CREP si l'agent n'a pas de crep papier ou sur l'appli, et que l'action est demandée par son N+1
            if (!$agent->getCrep() && $utilisateur === $agent->getShd()->getUtilisateur()) {
                return true;
            }
        }

        return false;
    }

    private function peutImporterCrepPapier(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($agent->getCampagneBrhp() && $dateCourante >= $agent->getCampagneBrhp()->getDateDebutEntretien()) {
            if (EnumStatutCampagne::OUVERTE != $agent->getCampagneBrhp()->getStatut()) {
                return false;
            }

            if ($agent->getCrep() && $agent->getCrep()->getCrepPapier()) {
                return false;
            }

            if ($agent->getCrep() && in_array($agent->getCrep()->getStatut(), [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT])) {
                return false;
            }

            if ('ROLE_SHD' === $roleUtilisateurSession) {
                if ($agent->getShd() && $utilisateur === $agent->getShd()->getUtilisateur()) {
                    return true;
                }
            }

            if ('ROLE_AH' === $roleUtilisateurSession) {
                if ($agent->getAh() && $utilisateur === $agent->getAh()->getUtilisateur()) {
                    return true;
                }
            }

            if ('ROLE_BRHP' === $roleUtilisateurSession) {
                /** @var $brhp Brhp */
                $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);
                if (in_array($agent->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutModifier(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            return true;
        }

        if ('ROLE_PNC' == $roleUtilisateurSession
            && !in_array(
                $agent->getCampagnePnc()->getStatut(),
                        array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE)
            )) {
            return true;
        }

        if ('ROLE_RLC' == $roleUtilisateurSession) {
            if (!$agent->getPerimetreRlc()) {
                return false;
            }

            if (!$agent->getPerimetreBrhp()) {
                return true;
            }

            if ($agent->getCampagneRlc() && !in_array($agent->getCampagneRlc()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                //On récupère le RLC de l'utilisateur
                /** @var $rlc RLC */
                $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);

                $perimetresRlcByRlc = $rlc->getPerimetresRlc();

                if (in_array($agent->getCampagneRlc()->getPerimetreRlc(), $perimetresRlcByRlc->toArray(), true)) {
                    return true;
                }
            }
        }

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            if ($agent->getPerimetreBrhp()
                && !in_array($agent->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                $perimetresBrhpIds = array();

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                foreach ($perimetresBrhp as $perimetreBrhp) {
                    $perimetresBrhpIds[] = $perimetreBrhp->getId();
                }

                if (in_array($agent->getPerimetreBrhp()->getId(), $perimetresBrhpIds)) {
                    return true;
                }

//                 if (in_array($agent->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {

//                         return true;
//                 }
            }
        }

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            if ($agent->getPerimetreBrhp()
                && !in_array($agent->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                //On récupère l'agent de l'utilisateur (N+1)
                /** @var $shd Agent */
                $shd = $this->em->getRepository('AppBundle:Agent')->getAgentByUser($utilisateur, $agent->getCampagnePnc());

                //On vérifie si l'utilisateur est bien le N+1 de l'agent à modifier
                if ($agent->getShd() == $shd) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutVoir(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            return true;
        }

        //Si l'agent n'a pas de périmètre (sans périmètre) tous le monde peut le voir
        if (null === $agent->getPerimetreBrhp()) {
            return true;
        }

        // Si l'utilisateur est ROLE_ADMIN_MIN et du même ministère que l'agent, on autorise l'accès
        if ('ROLE_ADMIN_MIN' == $roleUtilisateurSession) {
            return true;
        }

        // Si l'utilisateur est ROLE_PNC et du même ministère que l'agent, on autorise l'accès
        if ('ROLE_PNC' == $roleUtilisateurSession) {
            return true;
        }

        if ('ROLE_RLC' == $roleUtilisateurSession) {
            //On récupère le RLC de l'utilisateur
            /** @var $rlc RLC */
            $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);

            $perimetresBrhpByRlc = $this->em->getRepository('AppBundle:PerimetreBrhp')->getPerimetresBrhpByRlc($rlc);

            if (in_array($agent->getPerimetreBrhp(), $perimetresBrhpByRlc)) {
                return true;
            }
        }

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            //On récupère le BRHP de l'utilisateur
            /** @var $brhp BRHP */
            $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP
            if ($brhp->getPerimetresBrhp()->contains($agent->getCampagneBrhp()->getPerimetreBrhp())) {
                return true;
            }
        }

        if ('ROLE_BRHP_CONSULT' == $roleUtilisateurSession) {
            //On récupère le BRHP_CONSULT de l'utilisateur
            /** @var $brhpConsult BrhpConsult */
            $brhpConsult = $this->em->getRepository('AppBundle:BrhpConsult')->findOneByUtilisateur($utilisateur);

            // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP Consult
            if ($brhpConsult->getPerimetresBrhp()->contains($agent->getCampagneBrhp()->getPerimetreBrhp())) {
                return true;
            }
        }

        if ('ROLE_AH' == $roleUtilisateurSession) {
            // Si l'utilisateur est le N+2 de l'agent
            if ($utilisateur = $agent->getAh()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            //Si l'agent possède un N+1
            if ($agent->getShd()) {
                //Si l'agent possède un CREP, on vérifie l'identité du N+1 en passant par le CREP
                if ($agent->getCrep()) {
                    if ($utilisateur == $agent->getCrep()->getShd()->getUtilisateur()) {
                        return true;
                    }
                } else {
                    if ($utilisateur == $agent->getShd()->getUtilisateur()) {
                        return true;
                    }
                }
            }
            //Si l'agent est orphelin de N+1
            else {
                //On récupère l'agent de l'utilisateur (N+1)
                /** @var $shd Agent */
                $shd = $this->em->getRepository('AppBundle:Agent')->getAgentByUser($utilisateur, $agent->getCampagnePnc());

                if ($shd) {
                    return true;
                }
            }
        }

        if ('ROLE_AGENT' == $roleUtilisateurSession) {
            if ($utilisateur === $agent->getUtilisateur()) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutDetacherPerimetreBrhp(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            if ($agent->getPerimetreBrhp()) {
                return true;
            }
        }

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            //Si l'agent possède un périmètre => il est potentiellement détachable
            if ($agent->getPerimetreBrhp()
                && !in_array($agent->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                // un BRHP ne doit pouvoir détacher que les agents qui font partie de ses périmètres
                $perimetresBrhpIds = array();

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                foreach ($perimetresBrhp as $perimetreBrhp) {
                    $perimetresBrhpIds[] = $perimetreBrhp->getId();
                }

                if (in_array($agent->getPerimetreBrhp()->getId(), $perimetresBrhpIds)) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutRattacherPerimetreBrhp(Agent $agent, CampagneBrhp $campagneBrhp, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (!in_array($campagneBrhp->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
            if ('ROLE_BRHP' == $roleUtilisateurSession) {
                //Si l'agent est orphelin de périmètre RLC, il peut être rattaché à un périmètre BRHP
                if (!$agent->getPerimetreRlc()) {
                    return true;
                }
                //Si l'agent a un périmètre Rlc et est orphelin de périmètre Brhp
                if (!$agent->getPerimetreBrhp() && $agent->getPerimetreRlc() == $campagneBrhp->getPerimetreBrhp()->getPerimetreRlc()) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutRattacherShd(Agent $agent, CampagneBrhp $campagneShdPourRattachement, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_SHD' == $roleUtilisateurSession) {
            // conditions sur le statut de la campagne
            if (!in_array($campagneShdPourRattachement->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                // conditions sur le N+1
                if (!$agent->getShd()) {
                    // Si l'agent n'a pas de camapgneRLC
                    if (!$agent->getCampagneRlc()) {
                        return true;
                    }

                    // Si l'agent a une camapgneBRHP identique à la campagne de rattachement
                    if ($agent->getCampagneBrhp() == $campagneShdPourRattachement) {
                        return true;
                    }

                    // Si l'agent appartient à la même campagneRLC que la campagne de rattachement
                    if (!$agent->getCampagneBrhp() && $agent->getCampagneRlc()->getId() == $campagneShdPourRattachement->getCampagneRlc()->getId()) {
                        return true;
                    }
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutDetacherShd(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            if ($agent->getShd()) {
                return true;
            }
        }

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            if ($agent->getPerimetreBrhp()
                   && !in_array($agent->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                //On récupère l'agent de l'utilisateur (N+1)
                /** @var $shd Agent */
                $shd = $this->em->getRepository('AppBundle:Agent')->getAgentByUser($utilisateur, $agent->getCampagnePnc());

                if ($agent->getShd() == $shd) {
                    $crep = $agent->getCrep();

                    // Si l'agent n'a pas de CREP il est détachable
                    if (!$crep) {
                        return true;
                    }

                    // Si l'agent a un crep qui n'est pas à un état final, il est détachable
                    if (EnumStatutCrep::NOTIFIE_AGENT != $crep->getStatut()
                    && EnumStatutCrep::REFUS_NOTIFICATION_AGENT != $crep->getStatut()) {
                        return true;
                    }
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutDetacherPerimetreRlc(Agent $agent, $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN') && $agent->getPerimetreRlc()) {
            return true;
        }

        if ('ROLE_RLC' == $roleUtilisateurSession) {
            //Si l'agent possède un périmètre => il est potentiellement détachable
            if ($agent->getPerimetreRlc()
                    && !in_array($agent->getCampagneRlc()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
                /* @var $rlc Rlc */
                $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

                if ($rlc && in_array($agent->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
                    return true;
                }
            }
        }

        return false;
    }

    private function peutRattacherPerimetreRlc($agent, $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_RLC' == $roleUtilisateurSession && !$agent->getPerimetreRlc()) {
            $campagnePnc = $agent->getCampagnePnc();

            /* @var $rlc Rlc */
            $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            $rlc->getPerimetresRlc();

            // On fait l'intersection des périmètres de la campagne et des périmètres du RLC
            // Il faut que le RLC gère au moins un périmètre des ceux de la campagne
            if ($rlc && !empty(array_intersect($campagnePnc->getPerimetresRlc()->toArray(), $rlc->getPerimetresRlc()->toArray()))) {
                return true;
            }
        }

        return false;
    }

    //Suppression d'un CREP importé en version papier
    private function peutSupprimerCrepPapier(Agent $agent, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        if ($agent->getCampagneBrhp() && !in_array($agent->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
            //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
            if ($agent->getCampagneBrhp() && $dateCourante >= $agent->getCampagneBrhp()->getDateDebutEntretien()) {
                if ('ROLE_BRHP' === $roleUtilisateurSession && $agent->getCrep() && $agent->getCrep()->getCrepPapier()) {
                    /** @var $brhp Brhp */
                    $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);
                    if (in_array($agent->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                        return true;
                    }
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
