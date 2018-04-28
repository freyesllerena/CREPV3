<?php

namespace AppBundle\Service;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Agent;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\EnumTypes\EnumStatutValidationAgent;
use AppBundle\EnumTypes\EnumErreurConstatee;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Repository\CampagneBrhpRepository;
use AppBundle\Repository\CampagneRlcRepository;
use AppBundle\Entity\Document;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Repository\AgentRepository;
use AppBundle\Entity\UtilisateurTmp;
use AppBundle\Repository\UtilisateurTmpRepository;
use AppBundle\Util\Util;

class AgentManager extends BaseManager
{
    protected $personneManager;

    protected $appMailer;

    protected $utilisateurManager;

    /* @var $crepManager CrepManager */
    protected $crepManager;

    protected $repScripts;

    public function init(PersonneManager $personneManager, AppMailer $appMailer, UtilisateurManager $utilisateurManager, CrepManager $crepManager, $repScripts)
    {
        $this->personneManager = $personneManager;
        $this->appMailer = $appMailer;
        $this->utilisateurManager = $utilisateurManager;
        $this->crepManager = $crepManager;
        $this->repScripts = $repScripts;
    }

    /*
     * Crée un agent et le rattache à la campagne BRHP
     *
     * Notifie le N+1 de l'agent créé
     *
     */
    public function creer(Agent $agent, CampagnePnc $campagnePnc, $campagneRlc = null, $campagneBrhp = null)
    {
        $agent->setCampagnePnc($campagnePnc);

        if ($campagneRlc) {
            $agent->setCampagneRlc($campagneRlc);
            $agent->setPerimetreRlc($campagneRlc->getPerimetreRlc());
        }

        if ($campagneBrhp) {
            $agent->setCampagneBrhp($campagneBrhp);
            $agent->setPerimetreBrhp($campagneBrhp->getPerimetreBrhp());
            $agent->setCampagneRlc($campagneBrhp->getCampagneRlc());
            $agent->setPerimetreRlc($campagneBrhp->getCampagneRlc()->getPerimetreRlc());
        }

        $agent->setAjouteManuellement(true);

        $shd = $agent->getShd();

        // Si l'agent est évaluable et qu'un N+1 lui est rattaché
        if ($agent->getEvaluable() && $shd) {
            $this->rattacherShd($agent, $shd);
        }

        $this->em->persist($agent);
        $this->em->flush();
    }

    /*
     * Mettre à jour un agent et l'utilisateur associé
     *
     */
    public function update(Agent $agent, Agent $ancienAgent)
    {
        // Récupérer l'utilisateur associé à l'agent
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->findOneByEmail($ancienAgent->getEmail());

        // Mettre à jour l'utilisateur associé à l'agent s'il possède un compte
        if ($utilisateur) {
            $this->utilisateurManager->updateFromAgent($utilisateur, $agent);
        }

        $nouveauShd = false;

        if ($agent->getShd() != $ancienAgent->getShd()) {
            $nouveauShd = true;
        }

        // 		// Mettre à jour les champs N+1 et N+2 du CREP associé à l'agent s'il en possède
        // 		if ($agent->getCrep()) {
        // 		    $this->crepManager->updateFromAgent($agent);
        // 		}

        // Associer l'agent à la campagne RLC

        /* @var $campagneRlcRepository CampagneRlcRepository */
        $campagneRlcRepository = $this->em->getRepository('AppBundle:CampagneRlc');

        $perimetreRlc = $agent->getPerimetreRlc();
        if ($perimetreRlc) {
            $campagneRlc = $campagneRlcRepository->getCampagneRlc($agent->getCampagnePnc(), $perimetreRlc);
            $agent->setCampagneRlc($campagneRlc);
        }

        /* @var $campagneBrhpRepository CampagneBrhpRepository */
        $campagneBrhpRepository = $this->em->getRepository('AppBundle:CampagneBrhp');

        if ($agent->getCampagnePnc() && $agent->getPerimetreBrhp()) {
            $camapagneBrhp = $campagneBrhpRepository->getCampagneBrhp($agent->getCampagnePnc(), $agent->getPerimetreBrhp());
            $agent->setCampagneBrhp($camapagneBrhp);
            $this->em->persist($agent);
            $this->em->flush();
        }

        return $this->rattacherShd($agent, $agent->getShd(), $nouveauShd);
    }

    //Détachement d'un agent de son périmètre Brhp
    public function detacherPerimetreBrhp(Agent $agent)
    {
        //Réinitialisation des liens entre l'agent et le périmètreBrhp
        $agent->setCampagneBrhp(null);
        $agent->setPerimetreBrhp(null);

        $this->em->persist($agent);
        $this->em->flush();
    }

    //Rattachement d'un agent à son périmètre Brhp
    public function rattacherPerimetreBrhp(Agent $agent, CampagneBrhp $campagneBrhp, Utilisateur $utilisateur)
    {
        //Réinitialisation des liens entre l'agent et le périmètreBrhp
        $agent->setCampagneBrhp($campagneBrhp);
        $agent->setPerimetreBrhp($campagneBrhp->getPerimetreBrhp());

        //Faire le rattachement Agent / N+1 si ce dernier est renseigné
        /* @var $roleUtilisateurSession Role*/
        $roleUtilisateurSession = $this->session->get('selectedRole');

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            /* @var $agentRepository AgentRepository */
            $agentRepository = $this->em->getRepository('AppBundle:Agent');

            /* @var $shd Agent */
            $shd = $agentRepository->getAgentByEmail($utilisateur->getEmail(), $agent->getCampagnePnc());

            $agent->setShd($shd);
        }

        $this->rattacherShd($agent, $agent->getShd());

        $this->em->persist($agent);
        $this->em->flush();
    }

    //Rattachement d'un agent à un périmètre RLC
    public function rattacherPerimetreRlc(Agent $agent, CampagneRlc $campagneRlc)
    {
        // 		$this->detacherPerimetreBrhp($agent);
        $agent->setPerimetreRlc($campagneRlc->getPerimetreRlc());
        $agent->setCampagneRlc($campagneRlc);

        $this->em->persist($agent);
        $this->em->flush();
    }

    public function validerRejeterAgents($agents)
    {
        $utilisateursAgentsACreer = [];
        $utilisateursAhsACreer = [];

        // Récupérer les agents dont le statut est rejeté affectation et les détacher de leur N+1
        /* @var $agent Agent */
        foreach ($agents as $agent) {
            switch ($agent->getValidationShd()/*$agent->getStatutValidation()*/) {
                case 0:
                    if (EnumErreurConstatee::MAUVAIS_SHD == $agent->getErreurSignalee()) {
                        $agent->setStatutValidation(EnumStatutValidationAgent::REJETE);
                        // Détacher l'agent de son N+1
                        $agent->setShd(null);
                        $agent->setStatutValidation(EnumStatutValidationAgent::EN_COURS);
                    } else {
                        $agent->setStatutValidation(EnumStatutValidationAgent::ERREUR_SIGNALEE);
                    }

                    $this->em->persist($agent);
                    break;

                case 1:
                    $agent->setStatutValidation(EnumStatutValidationAgent::VALIDE);
                    // On crée un crep et un compte utilisateur à l'agent s'il est évaluable et qu'il n'a pas encore de CREP
                    if ($agent->getEvaluable() && !$agent->getCrep()) {
                        // 	                    $crep = $this->crepManager->creer($agent);
                        // 	                    $this->em->persist($crep);
                        $utilisateursAgentsACreer[] = $agent;
                        // Si l'agent est évaluable et qu'il a un AH, on crée le compte du AH
                        if ($agent->getAh()) {
                            $utilisateursAhsACreer[] = $agent->getAh();
                        }
                    }
                    // Dès qu'un agent est accepté, on considère que la campagne est ouverte
                    // Cette notion reste transparente du point de vue des utilisateurs, elle est juste utilisée pour rediriger vers le tableau de bord à chaque fois
                    $agent->getCampagneBrhp()->setStatut(EnumStatutCampagne::OUVERTE);
                    break;

                    //Si c'est null ou autre, on le met à en attente de validation
                default:
                    $agent->setStatutValidation(EnumStatutValidationAgent::EN_COURS);
                    break;
            }
        }

        $this->em->flush();

        // appel du script de création de compte utilisateur
        // Si c'est un environnement windows (local)
        if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs($utilisateursAgentsACreer, 'ROLE_AGENT');
            $this->personneManager->ajoutePersonnesDansUtilisateurs($utilisateursAhsACreer, 'ROLE_AH');
        } else { // Si c'est un environnement linux, on lance un script en arrière plan
            /* @var $utilisateurTmpRepository UtilisateurTmpRepository */
            $utilisateurTmpRepository = $this->em->getRepository('AppBundle:UtilisateurTmp');

            foreach ($utilisateursAgentsACreer as $utilisateurAgentACreer) {
                $dejaEnFileattente = $utilisateurTmpRepository->findBy(['agent' => $utilisateurAgentACreer, 'role' => 'ROLE_AGENT']);

                if (!$dejaEnFileattente) {
                    $utilisateurTmp = new UtilisateurTmp();
                    $utilisateurTmp->setAgent($utilisateurAgentACreer)
                    ->setRole('ROLE_AGENT');
                    $this->em->persist($utilisateurTmp);
                }
            }

            $ahsAjoutes = [];
            foreach ($utilisateursAhsACreer as $utilisateurAhACreer) {
                $dejaEnFileattente = $utilisateurTmpRepository->findBy(['agent' => $utilisateurAhACreer, 'role' => 'ROLE_AH']);

                if (!$dejaEnFileattente && !isset($ahsAjoutes[$utilisateurAhACreer->getId()])) {
                    $utilisateurTmp = new UtilisateurTmp();
                    $utilisateurTmp->setAgent($utilisateurAhACreer)
                    ->setRole('ROLE_AH');
                    $this->em->persist($utilisateurTmp);
                    $ahsAjoutes[$utilisateurAhACreer->getId()] = $utilisateurAhACreer->getId();
                }
            }

            $this->em->flush();
        }
    }

    /*
     * Rattache un agent à un N+1
     */
    public function rattacherShd(Agent $agent, $shd, $nouveauShd = true)
    {
        if (!$shd) {
            return;
        }

        $campagneBrhp = $agent->getCampagneBrhp();

        //Si l'agent n'est rattaché à aucune CampagneBrhp, on ne fait pas de rattachement au N+1
        if (!$campagneBrhp) {
            return;
        }

        // Créer un compte utilisateur du SHD si nécessaire
        if (EnumStatutCampagne::OUVERTE == $campagneBrhp->getStatut()) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs([$shd], 'ROLE_SHD');
        }

        // Créer un compte utilisateur du AH si nécessaire
        if ($agent->getAh()
            && EnumStatutValidationAgent::VALIDE == $agent->getStatutValidation()
            && EnumStatutCampagne::OUVERTE == $campagneBrhp->getStatut()) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs([$agent->getAh()], 'ROLE_AH');
        }

        $agent->setShd($shd);

        $agent->setValidationShd(true);

        if ($nouveauShd) {
            $agent->setStatutValidation(EnumStatutValidationAgent::EN_COURS);
            $agent->setErreurSignalee(null);
            $agent->setCommentaireValidation(null);
        }

        // Si l'agent possède un CREP, on met à jour les informations du SHD dans le crep
        if ($agent->getCrep() && $nouveauShd) {
            $crep = $agent->getCrep();

            if (in_array($crep->getStatut(), [EnumStatutCrep::CREE, EnumStatutCrep::MODIFIE_SHD])) {
                // Tous les modèles de creps n'ont pas les mêmes champs forcément
                $crep->actualiserDonneesShd();
            }

            $this->em->persist($crep);
        }

        //notification du N+1
        if ($nouveauShd && EnumStatutCampagne::OUVERTE == $campagneBrhp->getStatut()) {
            $this->appMailer->notifierAjoutAgentDansListe($agent); //ancien agent après set shd et set email shd
        }

        $this->em->persist($agent);
        $this->em->flush();
    }

    /*
     * Detache un agent de son N+1
     */
    public function detacherShd(Agent $agent)
    {
        $agent->setShd(null);
        $agent->setStatutValidation(EnumStatutValidationAgent::EN_COURS);

        $agent->setErreurSignalee(null);
        $agent->setCommentaireValidation(null);

        //Si l'agent possède un CREP, on réinitialise le statut du CREP vers MODIFIE_SHD en gardant les informations préalablement saisies
        //afin d'apporter d'éventuelles ajustements et refaire le processus de signature
        $crep = $agent->getCrep();

        if ($crep
                && EnumStatutCrep::CREE != $crep->getStatut()
                && EnumStatutCrep::NOTIFIE_AGENT != $crep->getStatut()
                && EnumStatutCrep::REFUS_NOTIFICATION_AGENT != $crep->getStatut()
                && EnumStatutCrep::CAS_ABSENCE != $crep->getStatut()) {
            $crep->setStatut(EnumStatutCrep::MODIFIE_SHD);

            //Annulation de la signature du N+1
            $crep->setShdSignataire(null);
            $crep->setDateVisaShd(null);

            //Annulation des actions de l'agent
            $crep->setDateVisaAgent(null);
            $crep->setDateRefusVisa(null);
            $crep->setDateNotification(null);
            $crep->setDateRefusNotification(null);
            $crep->setDateRenvoiAgent(null);

            //Annulation des actions du N+2
            $crep->setAhSignataire(null);
            $crep->setDateVisaAh(null);
            $crep->setDateRenvoiAh(null);

            $this->em->persist($crep);
        }

        $this->em->persist($agent);
        $this->em->flush();
    }

    // Détachement d'un agent de son périmètre Rlc
    public function detacherPerimetreRlc(Agent $agent)
    {
        $agent->setCampagneRlc(null);
        $agent->setPerimetreRlc(null);
        $this->detacherPerimetreBrhp($agent);
    }

    public function ImporterCrepPapier(Agent $agent, Document $crepPapier, $statut, ModeleCrep $modeleCrep)
    {
        // Si l'agent a déjà un CREP, on lui ajoute uniquement le CREP papier
        if ($agent->getCrep()) {
            $crep = $agent->getCrep();
            $crep->setStatutCrepAvantImport($agent->getCrep()->getStatut()) 	// on sauvegarde le statut du crep avant l'import
            ->setCrepPapier($crepPapier)
            ->setStatut($statut);
        }
        // Si l'agnet n'avait pas de CREP, on lui en crée un sur la base du modèle selectionné
        else {
            $crep = $this->crepManager->creer($agent, $modeleCrep);
            $crep->setCrepPapier($crepPapier);
            $crep->setStatut($statut);
        }

        $this->em->persist($agent);
        $this->em->persist($crep);
        $this->em->flush();

        //Notifier l'agent, N+1, N+2 et le BRHP de l'import du crep papier de $agent
        $this->appMailer->notifierImportCrepPapier($agent);
    }

    public function detacherAgentsDunBrhp($uoEnMoins)
    {
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');
        $agentRepository->detacherAgentsDunBrhp($uoEnMoins);
    }

    public function rattacherAgentsAUnBrhp($uoEnPlus)
    {
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');
        $agentRepository->rattacherAgentsAUnBrhp($uoEnPlus);
    }

    public function exporterFichierAgents(CampagnePnc $campagnePnc)
    {
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        $donneesAgents = $agentRepository->exportDonneesAgents($campagnePnc);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Civilite', 'Nom de famille', 'Nom usuel', 'Nom marital', 'Prenom', 'Adresse mail',
                'Date de naissance', 'Categorie', 'Corps', 'Date entree dans le corps', 'Grade', 'Date entree dans le grade', 'Echelon',
                'Date entree dans echelon', 'Grade emploi', 'Date entree dans le grade emploi', 'Etablissement', 'Departement',
                'Affectation sigle', 'Affectation clair', 'Poste occupe', 'Date entree dans le poste occupe', 'Code poste 1',
                'Code poste 2', 'Capital DIF', 'Capital DIF mobilisable', 'Adresse mail SHD', 'Adresse mail AH', 'Agent evaluable',
                'Motif non evaluation', 'Code UO', ), ';');

        //Champs
        foreach ($donneesAgents as $donneeAgent) {
            fputcsv($handle, array(
                    $donneeAgent['matricule'],
                    Util::twig_title($donneeAgent['civilite']),
                    $donneeAgent['nomNaissance'],
                    $donneeAgent['nom'],
                    $donneeAgent['nomMarital'],
                    $donneeAgent['prenom'],
                    $donneeAgent['email'],
                    $donneeAgent['dateNaissance'] ? date('d/m/Y', strtotime($donneeAgent['dateNaissance'])) : '',
                    $donneeAgent['categorieAgent'],
                    $donneeAgent['corps'],
                    $donneeAgent['dateEntreeCorps'] ? date('d/m/Y', strtotime($donneeAgent['dateEntreeCorps'])) : '',
                    $donneeAgent['grade'],
                    $donneeAgent['dateEntreeGrade'] ? date('d/m/Y', strtotime($donneeAgent['dateEntreeGrade'])) : '',
                    $donneeAgent['echelon'],
                    $donneeAgent['dateEntreeEchelon'] ? date('d/m/Y', strtotime($donneeAgent['dateEntreeEchelon'])) : '',
                    $donneeAgent['gradeEmploi'],
                    $donneeAgent['dateEntreeGradeEmploi'] ? date('d/m/Y', strtotime($donneeAgent['dateEntreeGradeEmploi'])) : '',
                    $donneeAgent['etablissement'],
                    $donneeAgent['departement'],
                    $donneeAgent['affectation'],
                    $donneeAgent['affectationClairAgent'],
                    $donneeAgent['posteOccupe'],
                    $donneeAgent['dateEntreePosteOccupe'] ? date('d/m/Y', strtotime($donneeAgent['dateEntreePosteOccupe'])) : '',
                    $donneeAgent['codeSirh1'],
                    $donneeAgent['codeSirh2'],
                    $donneeAgent['capitalDif'],
                    $donneeAgent['capitalDifMobilisable'],
                    $donneeAgent['shd_email'],
                    $donneeAgent['ah_email'],
                    $donneeAgent['evaluable'] ? 'Oui' : 'Non',
                    $donneeAgent['motifNonEvaluation'],
                    $donneeAgent['codeUo'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
