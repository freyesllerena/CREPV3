<?php

namespace AppBundle\Service;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;
use AppBundle\EnumTypes\EnumRole;
use AppBundle\EnumTypes\EnumStatutCrep;

class CrepConfidentialisationManager extends BaseManager
{
    public function confidentialisation(Crep $crep, Utilisateur $utilisateur)
    {
        /* @var $roleUtilisateurSession Role*/
        $roleUtilisateurSession = $this->session->get('selectedRole');

        // On confidentialise la totalité du formulaire de CREP au niveau de l'agent et du N+2, et ce, tant que le N+1 ne l'a pas signé
        if (EnumRole::ROLE_SHD != $roleUtilisateurSession) {
            if (EnumStatutCrep::CREE == $crep->getStatut() || EnumStatutCrep::MODIFIE_SHD == $crep->getStatut()) {
                $crep->confidentialisationChampsShd($crep);
            }
        }

        // On confidentialise la totalité du formulaire du CREP au niveau du N+2, tant que l'agent ne l'a pas viser ou refuser
        if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
            if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                && $utilisateur->getEmail() == $crep->getAh()->getEmail()) {
                $crep->confidentialisationChampsShd($crep);
                $crep->confidentialisationChampsAgent($crep);
            }
        }

        // On confidentialise que les champs d'observations de l'agent du formulaire du CREP au niveau du N+1, tant que l'agent ne l'a pas viser ou refuser
        if (EnumRole::ROLE_SHD === $roleUtilisateurSession) {
            if (EnumStatutCrep::SIGNE_SHD == $crep->getStatut()
                && $utilisateur->getEmail() == $crep->getShd()->getEmail()) {
                $crep->confidentialisationChampsAgent($crep);
            }
        }

        // On confidentialise le champ observation du N+2 du formulaire de CREP au niveau de l'agent et du N+1, et ce, tant que le N+2 ne l'a pas signé
        if (EnumRole::ROLE_AH != $roleUtilisateurSession) {
            if (EnumStatutCrep::VISE_AGENT == $crep->getStatut() || EnumStatutCrep::REFUS_VISA_AGENT == $crep->getStatut()) {
                $crep->confidentialisationChampsAh($crep);
            }
        }

        // On confidentialise le champ observation de l'agent du formulaire de CREP au niveau de du N+2, et ce, quand l'agent renvoie son CREP au N+1
        if (EnumRole::ROLE_AH === $roleUtilisateurSession) {
            if (EnumStatutCrep::MODIFIE_SHD == $crep->getStatut()
                && $utilisateur->getEmail() == $crep->getAh()->getEmail()) {
                $crep->confidentialisationChampsAgent($crep);
            }
        }

        // On confidentialise le champ observation du N+2 du formulaire de CREP au niveau de l'agent, et ce, quand le N+2 renvoie le CREP au N+1
        if (EnumStatutCrep::MODIFIE_SHD == $crep->getStatut()
            && $utilisateur->getEmail() == $crep->getAgent()->getEmail()) {
            $crep->confidentialisationChampsAh($crep);
        }

        // On confidentialise le champ observation avant notification de l'agent du formulaire de CREP au niveau de du N+1 et N+2, et ce, tant que l'agent ne l'a pas signé définitivement ou refusé
        if (EnumRole::ROLE_AGENT != $roleUtilisateurSession) {
            if (!in_array($crep->getStatut(), array(EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT))) {
                $crep->confidentialisationChampsAgentAvantNotification($crep);
            }
        }

        return $crep;
    }
}
