<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
// use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\Crep;
use AppBundle\EnumTypes\EnumStatutCrep;
use Doctrine\ORM\EntityManager;
// use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Util\Util;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\Crep\CrepMinefAbc\CrepMinefAbc;
//use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Crep\CrepMcc\CrepMcc;
use AppBundle\Entity\Crep\CrepMinefContract\CrepMinefContract;
use AppBundle\Entity\Recours;
use AppBundle\Entity\Rlc;

use AppBundle\EnumTypes\EnumTypeResultatRecours;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class CrepVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $session;

    // Liste des actions supportées
    const EDIT = 'edit_crep';
    const VOIR = 'voir_crep';
    const MODIFIER_SHD = 'modifier_shd_crep';
    const SIGNER_SHD = 'signer_shd_crep';
    const COMPLETER_AGENT = 'completer_agent_crep';
    const VISER_AGENT = 'viser_agent_crep';
    const COMPLETER_AH = 'completer_ah_crep';
    const SIGNER_AH = 'signer_ah_crep';
    const NOTIFIER_AGENT = 'notifier_agent_crep';
    const REFUSER_VISA_AGENT = 'refuser_visa_agent_crep';
    const REFUSER_NOTIFICATION_AGENT = 'refuser_notification_agent_crep';
    const EXPORTER_PDF = 'exporter_pdf_crep';
    const RENVOYER_AGENT_SHD = 'renvoyer_agent_shd_crep';
    const RENVOYER_AH_SHD = 'renvoyer_ah_shd_crep';
    const RAPPELER_AGENT_SHD = 'rappeler_agent_shd_crep';
    const RAPPELER_AGENT_AH = 'rappeler_agent_ah_crep';
    const REINITIALISER = 'reinitialiser_crep';
    const VOIR_RECOURS = 'voir_recours';
    const DECLARER_RECOURS = 'declarer_recours';
    const SUPPRIMER = 'supprimer_crep';
    const REFAIRE_CREP = 'refaire_crep';
    const LAISSER_CREP_EN_ETAT = 'laisser_crep_en_etat';

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
                    self::EDIT,
                    self::VOIR,
                    self::MODIFIER_SHD,
                    self::SIGNER_SHD,
                    self::COMPLETER_AGENT,
                    self::VISER_AGENT,
                    self::COMPLETER_AH,
                    self::SIGNER_AH,
                    self::NOTIFIER_AGENT,
                    self::REFUSER_VISA_AGENT,
                    self::REFUSER_NOTIFICATION_AGENT,
                    self::EXPORTER_PDF,
                    self::RENVOYER_AGENT_SHD,
                    self::RENVOYER_AH_SHD,
                    self::RAPPELER_AGENT_SHD,
                    self::RAPPELER_AGENT_AH,
                    self::REINITIALISER,
                    self::VOIR_RECOURS, // TODO : ligne à décommenter pour activer les fonctionnalités de recours
                    //self::SUPPRIMER, // TODO: ligne à décommenter après définition du rôle habilité à supprimer un CREP
                    self::REFAIRE_CREP,
                    self::DECLARER_RECOURS, // TODO : ligne à décommenter pour activer les fonctionnalités de recours
                    self::LAISSER_CREP_EN_ETAT,
                ))) {
            return false;
        }

        if (!$subject) {
            return false;
        }

        // Si l'objet n'est pas de type Crep, il n'est pas supporté
        if (!$subject instanceof Crep) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        /* @var $roleUtilisateurSession Role */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        // Si l'utilisateur est ADMIN, l'accès est accordé
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        /* @var $crep Crep  */
        $crep = $subject;

        if (!$crep) {
            return false;
        }

        // Si l'utilisateur n'est pas du même ministere que l'agent (ayant le Crep)
        if ($utilisateur->getMinistere()->getId() != $crep->getAgent()->getCampagnePnc()->getMinistere()->getId()) {
            return false;
        }

        if (!in_array($attribute, array(self::VOIR, self::EXPORTER_PDF))
            && $crep->getAgent()->getCampagneBrhp()
            && in_array($crep->getAgent()->getCampagneBrhp()->getStatut(), array(EnumStatutCampagne::CLOTUREE, EnumStatutCampagne::FERMEE))) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->peutEditer($crep, $utilisateur, $roleUtilisateurSession);
            case self::VOIR:
                return $this->peutVoir($crep, $utilisateur, $roleUtilisateurSession);
            case self::MODIFIER_SHD:
                return $this->peutModifierShd($crep, $utilisateur, $roleUtilisateurSession);
            case self::SIGNER_SHD:
                return $this->peutSignerShd($crep, $utilisateur, $roleUtilisateurSession);
            case self::COMPLETER_AGENT:
                return $this->peutCompleterAgent($crep, $utilisateur);
            case self::VISER_AGENT:
                return $this->peutViserAgent($crep, $utilisateur);
            case self::COMPLETER_AH:
                return $this->peutCompleterAh($crep, $utilisateur, $roleUtilisateurSession);
            case self::SIGNER_AH:
                return $this->peutSignerAh($crep, $utilisateur, $roleUtilisateurSession);
            case self::NOTIFIER_AGENT:
                return $this->peutSignerDefinitivementAgent($crep, $utilisateur);
            case self::REFUSER_VISA_AGENT:
                return $this->peutRefuserVisaAgent($crep, $utilisateur, $roleUtilisateurSession);
            case self::REFUSER_NOTIFICATION_AGENT:
                return $this->peutRefuserNotificationAgent($crep, $utilisateur, $roleUtilisateurSession);
            case self::EXPORTER_PDF:
                return $this->peutExporterPdf($crep, $utilisateur, $roleUtilisateurSession);
            case self::RENVOYER_AGENT_SHD:
                return $this->peutRenvoyerAgentShd($crep, $utilisateur, $roleUtilisateurSession);
            case self::RENVOYER_AH_SHD:
                return $this->peutRenvoyerAhShd($crep, $utilisateur, $roleUtilisateurSession);
            case self::RAPPELER_AGENT_SHD:
                return $this->peutRappelerAgentShd($crep, $utilisateur, $roleUtilisateurSession);
            case self::RAPPELER_AGENT_AH:
                return $this->peutRappelerAgentAh($crep, $utilisateur, $roleUtilisateurSession);
            case self::REINITIALISER:
                return $this->peutReinitialiserCrep($crep, $utilisateur, $roleUtilisateurSession);
            case self::VOIR_RECOURS:
                return $this->peutVoirRecours($crep, $utilisateur, $roleUtilisateurSession);
            case self::DECLARER_RECOURS:
                return $this->peutDeclarerRecours($crep, $utilisateur, $roleUtilisateurSession);
            case self::SUPPRIMER:
                return $this->peutSupprimerCrep($crep, $utilisateur, $roleUtilisateurSession);
            case self::REFAIRE_CREP:
                return $this->peutRefaireCrep($crep, $utilisateur, $roleUtilisateurSession);
            case self::LAISSER_CREP_EN_ETAT:
                return $this->peutLaisserCrepEnEtat($crep, $utilisateur, $roleUtilisateurSession);
        }

        throw new \LogicException("Erreur de logique dans CrepVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutEditer(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_AGENT' === $roleUtilisateurSession) {
            return $this->peutCompleterAgent($crep, $utilisateur);
        }

        if ('ROLE_SHD' === $roleUtilisateurSession) {
            return $this->peutModifierShd($crep, $utilisateur, $roleUtilisateurSession);
        }

        if ('ROLE_AH' === $roleUtilisateurSession) {
            return $this->peutCompleterAh($crep, $utilisateur, $roleUtilisateurSession);
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutVoir(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_AGENT' === $roleUtilisateurSession) {
            if ($utilisateur === $crep->getAgent()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_SHD' === $roleUtilisateurSession) {
            if ($crep->getShd() && $utilisateur === $crep->getShd()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_AH' === $roleUtilisateurSession) {
            if ($crep->getAh() && $utilisateur === $crep->getAh()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_BRHP' === $roleUtilisateurSession) {
            /** @var $brhp Brhp */
            $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

            // Si le CREP est finalisé
            if (in_array($crep->getStatut(), [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT])) {
                // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP
                if ($brhp->getPerimetresBrhp()->contains($crep->getAgent()->getCampagneBrhp()->getPerimetreBrhp())) {
                    return true;
                }
            }
        }

        if ('ROLE_BRHP_CONSULT' === $roleUtilisateurSession) {
            /** @var $brhpConsult BrhpConsult */
            $brhpConsult = $this->em->getRepository('AppBundle:BrhpConsult')->findOneByUtilisateur($utilisateur);

            // Si le CREP est finalisé
            if (in_array($crep->getStatut(), [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT])) {
                // Si le périmètre de la campagne fait partie de la liste des périmètre gérés par le BRHP Consult
                if ($brhpConsult->getPerimetresBrhp()->contains($crep->getAgent()->getCampagneBrhp()->getPerimetreBrhp())) {
                    return true;
                }
            }
        }

        if ('ROLE_RLC' === $roleUtilisateurSession) {
            /** @var $rlc Rlc */
            $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            // Si l'agent est dans un des périmètres gérés par le RLC
            if ($rlc && in_array($crep->getAgent()->getPerimetreRlc(), $rlc->getPerimetresRlc()->toArray())) {
                // Si le CREP est finalisé
                if (in_array($crep->getStatut(), [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT])) {
                    return true;
                }
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutModifierShd(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_SHD' === $roleUtilisateurSession) {
            if (EnumStatutCrep::CREE == $crep->getStatut() && $crep->getShd()->getUtilisateur() == $utilisateur) {
                return true;
            }

            if (EnumStatutCrep::MODIFIE_SHD == $crep->getStatut() && $crep->getShd()->getUtilisateur() == $utilisateur) {
                return true;
            }
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSignerShd(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte la signature du N+1 n'est pas autorisée
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            //Si l'utilisateur possède le rôle N+1 :
            if ('ROLE_SHD' === $roleUtilisateurSession) {
                //Si l'agent possède un N+2 ou est déclaré comme étant "Sans N+2", le N+1 peut signer le CREP
                if ($crep->getAh() || $crep->getAgent()->getSansAh()) {
                    if (EnumStatutCrep::MODIFIE_SHD == $crep->getStatut() && $crep->getShd()->getUtilisateur() == $utilisateur) {
                        return true;
                    }
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutCompleterAgent(Crep $crep, Utilisateur $utilisateur)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut() && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }

            //Si le modèle est de type CrepMinefAbc, l'agent peut compléter son CREP avant sa signature definitive
            if ($crep instanceof CrepMinefAbc && EnumStatutCrep::SIGNE_AH == $crep->getStatut() && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }

            //Si le modèle est de type CrepMcc, l'agent peut compléter son CREP avant sa signature definitive
            if ($crep instanceof CrepMcc && EnumStatutCrep::SIGNE_AH == $crep->getStatut() && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;

            }

            //Si le modèle est de type CrepMinefContract, l'agent peut compléter son CREP avant sa signature definitive
            if ($crep instanceof CrepMinefContract && EnumStatutCrep::SIGNE_AH == $crep->getStatut() && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }

        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutViserAgent(Crep $crep, Utilisateur $utilisateur)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                && $crep->getAh()
                && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutCompleterAh(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_AH' === $roleUtilisateurSession) {
                if (EnumStatutCrep::VISE_AGENT === $crep->getStatut() && $crep->getAh() && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }

                if (EnumStatutCrep::REFUS_VISA_AGENT === $crep->getStatut() && $crep->getAh() && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSignerAh(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_AH' === $roleUtilisateurSession) {
                if ((EnumStatutCrep::VISE_AGENT === $crep->getStatut()) && $crep->getAh() && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }

                if ((EnumStatutCrep::REFUS_VISA_AGENT === $crep->getStatut()) && $crep->getAh() && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSignerDefinitivementAgent(Crep $crep, Utilisateur $utilisateur)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            //Si l'agent possède un N+2 et que ce dernier a signé et transmis le CREP à l'agent, ce dernier peut notifier (signer définitivement) son CREP
            if (EnumStatutCrep::SIGNE_AH == $crep->getStatut() && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }

            if (in_array(
                $crep->getStatut(),
                                            [
                                                EnumStatutCrep::SIGNE_SHD, //Si l'agent est déclaré comme étant "Sans N+2" et que le N+1 a signé et transmis le CREP à l'agent, ce dernier peut directement le notifier (signer définitivement)
                                                EnumStatutCrep::VISE_AGENT, //Si l'agent est déclaré comme étant "Sans N+2" après avoir visé son CREP, il  peut directement le notifier (signer définitivement)
                                                EnumStatutCrep::REFUS_VISA_AGENT, //Si l'agent est déclaré comme étant "sans N+2" après que le N+1 ait acté le refus de visa de l'agent, ce dernier peut directement le notifier (signer définitivement)
                                            ]
            )
                && $crep->getAgent()->getSansAh()
                && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                return true;
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutRefuserVisaAgent(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_SHD' === $roleUtilisateurSession
                && EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                && $crep->getAh()
                && $crep->getShd()->getUtilisateur() == $utilisateur) {
                $nbJoursOuvres = $crep->getAgent()->getCampagnePnc()->getMinistere()->getDelaiVisa();

                //On passe une copie de la date de visa du CREP pour que cette dernière ne soit pas modifiée dans la fonction calculeDate(...)
                $dateAffichageBoutonRejet = Util::calculeDate($crep->getDateVisaShd(), $nbJoursOuvres);

                if ($dateCourante >= $dateAffichageBoutonRejet) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutRefuserNotificationAgent(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_SHD' === $roleUtilisateurSession) {
                $nbJoursOuvres = $crep->getAgent()->getCampagnePnc()->getMinistere()->getDelaiSignatureDefinitive();

                //Si l'agent possède un N+2 et que ce dernier a signé et transmis le CREP à l'agent, le N+1 peut mentionner le refus de signer définitivement le CREP par l'agent
                if (EnumStatutCrep::SIGNE_AH == $crep->getStatut() && $crep->getShd()->getUtilisateur() == $utilisateur) {
                    $dateAffichageBoutonRefusDeSignatureDefinitive = Util::calculeDate($crep->getDateVisaAh(), $nbJoursOuvres);

                    if ($dateCourante >= $dateAffichageBoutonRefusDeSignatureDefinitive) {
                        return true;
                    }
                }

                //Si l'agent est déclaré comme étant "Sans N+2" et que le N+1 a signé et transmis le CREP à l'agent, il peut directement mentionner le refus de signer définitivement le CREP par l'agent
                if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                    && $crep->getAgent()->getSansAh()
                    && $crep->getShd()->getUtilisateur() == $utilisateur) {
                    $dateAffichageBoutonRefusDeSignatureDefinitive = Util::calculeDate($crep->getDateVisaShd(), $nbJoursOuvres);
                    if ($dateCourante >= $dateAffichageBoutonRefusDeSignatureDefinitive) {
                        return true;
                    }
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutExporterPdf(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ('ROLE_AGENT' === $roleUtilisateurSession) {
            if ($utilisateur === $crep->getAgent()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_SHD' === $roleUtilisateurSession) {
            if ($utilisateur === $crep->getShd()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_AH' === $roleUtilisateurSession) {
            if ($utilisateur === $crep->getAh()->getUtilisateur()) {
                return true;
            }
        }

        if ('ROLE_BRHP' === $roleUtilisateurSession) {
            /** @var $brhp Brhp */
            $brhp = $this->em->getRepository('AppBundle:Brhp')->findOneByUtilisateur($utilisateur);

            if (EnumStatutCrep::NOTIFIE_AGENT == $crep->getStatut() && in_array($crep->getAgent()->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                return true;
            }

            if (EnumStatutCrep::REFUS_NOTIFICATION_AGENT == $crep->getStatut() && in_array($crep->getAgent()->getPerimetreBrhp(), $brhp->getPerimetresBrhp()->toArray())) {
                return true;
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    // Renvoi du CREP de l'agent vers son N+1
    private function peutRenvoyerAgentShd(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_AGENT' === $roleUtilisateurSession) {
                if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                    && $crep->getAgent()->getUtilisateur() == $utilisateur) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    // Renvoi du CREP du N+2 vers le N+1
    private function peutRenvoyerAhShd(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_AH' === $roleUtilisateurSession) {
                if (EnumStatutCrep::VISE_AGENT === $crep->getStatut()
                    && $crep->getAh()
                    && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }

                if (EnumStatutCrep::REFUS_VISA_AGENT === $crep->getStatut()
                    && $crep->getAh()
                    && $crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    // Rappel du CREP par le N+1 (le CREP était côté agent pour le visa)
    private function peutRappelerAgentShd(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_SHD' === $roleUtilisateurSession) {
                if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                    && $crep->getShd()
                    && $crep->getShd()->getUtilisateur()->getId() == $utilisateur->getId()
                	&& null === $crep->getDateConsultationAgent()) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    // Rappel du CREP par le N+2 (le CREP était côté agent pour la signature finale)
    private function peutRappelerAgentAh(Crep $crep, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        $dateCourante = new \DateTime();

        //Si la date de début des entretiens n'est pas atteinte, aucune action n'est possible sur le CREP, mise à part : la consultation et l'export du formulaire
        if ($dateCourante >= $crep->getAgent()->getCampagnePnc()->getDateDebutEntretien()) {
            if ('ROLE_AH' === $roleUtilisateurSession) {
                if (EnumStatutCrep::SIGNE_AH == $crep->getStatut()
                    && $crep->getAh()
                    && $crep->getAh()->getUtilisateur()->getId() == $utilisateur->getId()) {
                    return true;
                }
            }
        }
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutReinitialiserCrep($crep, $utilisateur, $roleUtilisateurSession)
    {
        // On peut réinitialiser un CREP si et seulement si :
        // L'utilisateur connecté est le SHD de l'agent.
        // et que la campagne est ouverte
        if ('ROLE_SHD' === $roleUtilisateurSession
                && $utilisateur === $crep->getAgent()->getShd()->getUtilisateur()
                && EnumStatutCampagne::OUVERTE == $crep->getAgent()->getCampagnePnc()->getStatut()) {
            if (!$crep->getCrepPapier() &&  // L'agent n'a pas de CREP papier
                    $crep->getAgent()->getCrep() && 			// L'agent possède un CREP applicatif
                    in_array($crep->getAgent()->getCrep()->getStatut(), [EnumStatutCrep::CREE, // Le SHD a la main sur le CREP
                            EnumStatutCrep::MODIFIE_SHD,
                    ])) {
                return true;
            }
        }

        return false;
    }

    private function peutVoirRecours($crep, $utilisateur, $roleUtilisateurSession)
    {
        // Si aucun recour
//     	if($crep->getRecours()->isEmpty()){
//     		return false;
//     	}

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            // On ne peut visualiser que les recours sur les crep finalisés
            if (in_array(
                $crep->getStatut(),
                [
                                                EnumStatutCrep::NOTIFIE_AGENT,
                                                EnumStatutCrep::REFUS_NOTIFICATION_AGENT,
                                              ]
                            )
                ) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                $perimetreBrhpAgent = $crep->getAgent()->getPerimetreBrhp();

                // Si le brhp est responsable du périmètre brhp de l'agent
                foreach ($perimetresBrhp as $perimetreBrhp) {
                    if ($perimetreBrhpAgent == $perimetreBrhp) {
                        return true;
                    }
                }
            }
        }

        // TODO: décommenter la partie RLC
        /*
    	if ($roleUtilisateurSession == "ROLE_RLC") {
    		// On ne peut visualiser que les recours sur les crep finalisés
    		if ( in_array($crep->getStatut(), [
    				EnumStatutCrep::NOTIFIE_AGENT,
    				EnumStatutCrep::REFUS_NOTIFICATION_AGENT,
    				]
    			)
    		){
    			//On récupère le RLC de l'utilisateur
    			$rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);
    			$perimetresRlc = $rlc->getPerimetresRlc()->toArray();

    			if (in_array($crep->getAgent()->getPerimetreRlc(), $perimetresRlc )) {
    				return true;
    			}

    		}
    	}
    	*/

        /*
        if(!$crep->getRecours()->isEmpty()){
            if ($roleUtilisateurSession == "ROLE_AGENT") {
                if ($crep->getAgent()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }

            if ($roleUtilisateurSession == "ROLE_SHD") {
                if ($crep->getShd()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }

            if ($roleUtilisateurSession == "ROLE_AH") {
                if ($crep->getAh()->getUtilisateur() === $utilisateur) {
                    return true;
                }
            }
        }
        */
        return false;
    }

    private function peutDeclarerRecours($crep, $utilisateur, $roleUtilisateurSession)
    {
        // On déclare des recours sur une campagne ouverte ou cloturée
        if ($crep->getAgent()->getCampagneBrhp()
                && in_array(
                    $crep->getAgent()->getCampagneBrhp()->getStatut(),
                        [
                            EnumStatutCampagne::OUVERTE,
                            EnumStatutCampagne::CLOTUREE,
                        ]
                )
                // On ne peut déclarer en recours que sur les crep finalisés (signés définitivement, refus de signature)
                && in_array(
                    $crep->getStatut(),
                        [
                                EnumStatutCrep::NOTIFIE_AGENT,
                                EnumStatutCrep::REFUS_NOTIFICATION_AGENT,
                        ]
        )) {
            // Le BRHP est habilité à déclarer un recours
            if ('ROLE_BRHP' == $roleUtilisateurSession) {
                //On récupère le BRHP de l'utilisateur
                /** @var $brhp BRHP */
                $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

                $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

                $perimetreBrhpAgent = $crep->getAgent()->getPerimetreBrhp();

                // Si le brhp est responsable du périmètre brhp de l'agent
                foreach ($perimetresBrhp as $perimetreBrhp) {
                    if ($perimetreBrhpAgent == $perimetreBrhp) {
                        return true;
                    }
                }
            }

            // TODO: décommenter la partie RLC.
            /*
            // Le RLC est habilité à déclarer un recours
            if ($roleUtilisateurSession == "ROLE_RLC") {
                //On récupère le RLC de l'utilisateur
                $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);
                $perimetresRlc = $rlc->getPerimetresRlc()->toArray();

                if (in_array($crep->getAgent()->getPerimetreRlc(), $perimetresRlc )) {
                    return true;
                }
            }*/
        }

        return false;
    }

    private function peutSupprimerCrep($crep, $utilisateur, $roleUtilisateurSession)
    {
        // La suppression d'un CREP se fait uniquement par le RLC, si la camapgne est ouverte ou clôturée
        if ('ROLE_RLC' === $roleUtilisateurSession
            && in_array(
                $crep->getAgent()->getCampagnePnc()->getStatut(),
                    [EnumStatutCampagne::OUVERTE, EnumStatutCampagne::CLOTUREE]
            )) {
            $rlc = $this->em->getRepository('AppBundle:RLC')->findOneByUtilisateur($utilisateur);
            $perimetresRlc = $rlc->getPerimetresRlc()->toArray();

            if (in_array($crep->getAgent()->getPerimetreRlc(), $perimetresRlc)) {
                /* @var $recours Recours */
                foreach ($crep->getRecours() as $recours) {
                    // On peut supprimer un crep finalisé, s'il y a au moins un recours avec une décision non prise en compte
                    if (null !== $recours->getDecision() && !$recours->getDecisionPriseEnCompte()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function peutRefaireCrep($crep, $utilisateur, $roleUtilisateurSession)
    {
        // Le BRHP est le seul utilisateur habilité à refaire un CREP sur une campagne ouverte ou clôturée
        if ('ROLE_BRHP' === $roleUtilisateurSession
                && in_array(
                    $crep->getAgent()->getCampagnePnc()->getStatut(),
                        [EnumStatutCampagne::OUVERTE, EnumStatutCampagne::CLOTUREE]
            )) {
            //On récupère le BRHP de l'utilisateur
            /** @var $brhp BRHP */
            $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

            $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

            $perimetreBrhpAgent = $crep->getAgent()->getPerimetreBrhp();

            // Si le brhp est responsable du périmètre brhp de l'agent
            foreach ($perimetresBrhp as $perimetreBrhp) {
                if ($perimetreBrhpAgent == $perimetreBrhp) {
                    /* @var $recours Recours  */
                    foreach ($crep->getRecours() as $recours) {
                        // On peut refaire un crep finalisé, s'il y a au moins un recours avec une décision non prise en compte
                        if (EnumTypeResultatRecours::MODIFICATION == $recours->getDecision() && !$recours->getDecisionPriseEnCompte()) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    private function peutLaisserCrepEnEtat($crep, $utilisateur, $roleUtilisateurSession)
    {
        // Le BRHP est le seul utilisateur habilité à acter à laisser un CREP en l'état sur une campagne ouverte ou clôturée
        if ('ROLE_BRHP' === $roleUtilisateurSession
                && in_array(
                    $crep->getAgent()->getCampagnePnc()->getStatut(),
                        [EnumStatutCampagne::OUVERTE, EnumStatutCampagne::CLOTUREE]
                )) {
            //On récupère le BRHP de l'utilisateur
            /** @var $brhp BRHP */
            $brhp = $this->em->getRepository('AppBundle:BRHP')->findOneByUtilisateur($utilisateur);

            $perimetresBrhp = $brhp->getPerimetresBrhp()->toArray();

            $perimetreBrhpAgent = $crep->getAgent()->getPerimetreBrhp();

            // Si le brhp est responsable du périmètre brhp de l'agent
            foreach ($perimetresBrhp as $perimetreBrhp) {
                if ($perimetreBrhpAgent == $perimetreBrhp) {
                    /* @var $recours Recours  */
                    foreach ($crep->getRecours() as $recours) {
                        if (EnumTypeResultatRecours::PAS_DE_MODIFICATION == $recours->getDecision() && !$recours->getDecisionPriseEnCompte()) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
