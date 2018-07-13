<?php

namespace AppBundle\Service;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Crep;
use AppBundle\EnumTypes\EnumRole;
use AppBundle\EnumTypes\EnumStatutCrep;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Class CrepConfidentialisationManager
 * @package AppBundle\Service
 *
 *       ---------------------------------------------------------------------------------------
 *       STATUT CREP             SHD                AGENT                    AH
 *       ---------------------------------------------------------------------------------------
 *       CREE                 ChampsAgent          ChampsAh           ChampsShd
 *       MODIFIE_SHD          ChampsAh             ChampsShd          ChampsAgent
 *       ---------------------------------------------------------------------------------------
 *       SIGNE_SHD            ChampsAgent          ChampsAh           ChampsAgent
 *                            ChampsAh
 *       ---------------------------------------------------------------------------------------
 *       VISE_AGENT           ChampsAh             ChampsAh           ChampsAgentAvantNotif
 *       REFUS_VISA_AGENT
 *       ---------------------------------------------------------------------------------------
 *       SIGNE_AH         ChampsAgentAvantNotif                      ChampsAgentAvantNotif
 *       ---------------------------------------------------------------------------------------
 *
 */
class CrepConfidentialisationManager
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function confidentialisation(Crep $crep, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role*/
        $roleUtilisateurSession = $this->session->get('selectedRole');

        // Crep au status CREE/MODIFIE_SHD
        if (EnumStatutCrep::CREE == $crep->getStatut() || EnumStatutCrep::MODIFIE_SHD == $crep->getStatut()) {
            if (EnumRole::ROLE_SHD === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgent($crep);
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AGENT === $roleUtilisateurSession) {
                $crep->confidentialisationChampsShd($crep);
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgent($crep);
                $crep->confidentialisationChampsShd($crep);
            }
        }

        // Crep au status SIGNE_SHD
        if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()) {
            if (EnumRole::ROLE_SHD === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgent($crep);
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AGENT === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgent($crep);
            }
        }

        // Crep au status VISE_AGENT/REFUS_VISA_AGENT
        if (EnumStatutCrep::VISE_AGENT == $crep->getStatut()) {
            if (EnumRole::ROLE_SHD === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AGENT === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAh($crep);
            }

            if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgentAvantNotification($crep);
            }
        }

        // Crep au status SIGNE_AH
        if (EnumStatutCrep::SIGNE_AH == $crep->getStatut()) {
            if (EnumRole::ROLE_SHD === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgentAvantNotification($crep);
            }

            if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
                $crep->confidentialisationChampsAgentAvantNotification($crep);
            }
        }

        return $crep;
    }
}
