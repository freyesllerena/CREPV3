<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Service\BaseManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Repository\CrepRepository\CrepMso3Repository\CrepMso3FormationT1Repository;

class CrepMso3Manager extends BaseManager
{
    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMso3\CrepMso3';

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp);

        $result[] = $this->exportFormationsT1($campagneBrhp);

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMso3\CrepMso3FormationT2");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMso3\CrepMso3FormationT3");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMso3\CrepMso3FormationPreparationConcours");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMso3\CrepMso3FormationAutre");

        $zip->addFile($result[0], $sousDossier.'/Formations_demandees_et_suivies_'.($campagneBrhp->getAnneeEvaluee() - 1).'_'.$campagneBrhp->getAnneeEvaluee().'.csv');
        $zip->addFile($result[1], $sousDossier.'/Formations_adaptation_immediate_au_poste_de_travail_T1.csv');
        $zip->addFile($result[2], $sousDossier.'/Formations_evolution_des_metiers_T2.csv');
        $zip->addFile($result[3], $sousDossier.'/Formations_developpement_acquisition_nouvelles_competences_T3.csv');
        $zip->addFile($result[4], $sousDossier.'/Formations_prepartion_concours_examens.csv');
        $zip->addFile($result[5], $sousDossier.'/Formations_autres_actions.csv');

        return $zip;
    }

    // Export des formations suivies N-1 et N-2
    private function exportFormationsSuivies(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations suivies N-1
        $formationN1Repository = $this->em->getRepository("AppBundle:Crep\CrepMso3\CrepMso3FormationN1");

        // Repository des formations suivies N-2
        $formationN2Repository = $this->em->getRepository("AppBundle:Crep\CrepMso3\CrepMso3FormationN2");

        $exportFormationsN1 = $formationN1Repository->exportFormations($campagneBrhp, $this->modeleCrep);

        $exportFormationsN2 = $formationN2Repository->exportFormations($campagneBrhp, $this->modeleCrep);

        // Fusionner les deux tableaux de formations
        $formationsSuivies = [];
        $formationsSuivies[$campagneBrhp->getAnneeEvaluee()] = $exportFormationsN1;
        $formationsSuivies[$campagneBrhp->getAnneeEvaluee() - 1] = $exportFormationsN2;

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Année', 'Libellé de la formation', 'Formation suivie', 'Commentaires', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        // Champs
        // $key = annee (N-1 ou N-2)
        // $value = tableau des formations demandées
        foreach ($formationsSuivies as $key => $formations) {
            foreach ($formations as $formation) {
                fputcsv($handle, array(
                        $formation['a_matricule'],
                        $formation['a_email'],
                        Util::twig_title($formation['a_civilite']),
                        $formation['a_nom'],
                        $formation['a_prenom'],
                        $formation['a_categorieAgent'],
                        $formation['a_corps'],
                        $formation['a_grade'],
                        $formation['a_affectation'],
                        $key,
                        $formation['f_libelle'],
                        AppExtension::ouiNon($formation['f_suivie']),
                        $formation['f_commentaires'],
                        $formation['c_dateNotification'],
                        $formation['c_dateRefusNotification'],
                ), ';');
            }
        }

        fclose($handle);

        return $filePath;
    }

    // Export des formations T1
    private function exportFormationsT1(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository CrepMso3FormationT1Repository */
        $formationRepository = $this->em->getRepository("AppBundle:Crep\CrepMso3\CrepMso3FormationT1");

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Intitulé de la formation', 'Demande de l\'agent', 'Avis favorable du responsable hiérarchique', 'Proposition du responsable hiérarchique', 'Échéance (année N, N +1)', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        //Champs
        foreach ($exportFormations as $formation) {
            fputcsv($handle, array(
                    $formation['a_matricule'],
                    $formation['a_email'],
                    Util::twig_title($formation['a_civilite']),
                    $formation['a_nom'],
                    $formation['a_prenom'],
                    $formation['a_categorieAgent'],
                    $formation['a_corps'],
                    $formation['a_grade'],
                    $formation['a_affectation'],
                    $formation['f_libelle'],
                    AppExtension::ouiNon($formation['f_demandeeAgent']),
                    AppExtension::ouiNon($formation['f_avisShd']),
                    AppExtension::ouiNon($formation['f_propositionAh']),
                    $formation['f_echeance'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    // Export des formations T2, T3, Préparations concours et autres actions
    private function exportFormationsDemandees(CampagneBrhp $campagneBrhp, $repositoryName)
    {
        $formationRepository = $this->em->getRepository($repositoryName);

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Intitulé de la formation', 'Demande de l\'agent', 'Avis favorable du responsable hiérarchique', 'Proposition du responsable hiérarchique', 'Recours au CPF', 'Échéance (année N, N +1)', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        //Champs
        foreach ($exportFormations as $formation) {
            fputcsv($handle, array(
                    $formation['a_matricule'],
                    $formation['a_email'],
                    Util::twig_title($formation['a_civilite']),
                    $formation['a_nom'],
                    $formation['a_prenom'],
                    $formation['a_categorieAgent'],
                    $formation['a_corps'],
                    $formation['a_grade'],
                    $formation['a_affectation'],
                    $formation['f_libelle'],
                    AppExtension::ouiNon($formation['f_demandeeAgent']),
                    AppExtension::ouiNon($formation['f_avisShd']),
                    AppExtension::ouiNon($formation['f_propositionAh']),
                    AppExtension::ouiNon($formation['f_cpf']),
                    $formation['f_echeance'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
