<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Service\BaseManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT1Repository;

class CrepMcc02Manager extends BaseManager
{
    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02';

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp, "AppBundle:Crep\CrepMcc02\CrepMcc02FormationSuivi");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMcc02\CrepMcc02FormationT1");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMcc02\CrepMcc02FormationT2");

        $result[] = $this->exportFormationsDemandees($campagneBrhp, "AppBundle:Crep\CrepMcc02\CrepMcc02FormationT3");



        $zip->addFile($result[0], $sousDossier.'/Besoins_formation_'.($campagneBrhp->getAnneeEvaluee() - 1).'_'.$campagneBrhp->getAnneeEvaluee().'.csv');

        return $zip;
    }

    // Export des formations suivies N-1 et N-2
    private function exportFormationsSuivies(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations suivies N-1 et N-2
        $formationN12NRepository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationSuivi");

        $exportFormationsN1N2 = $formationN12NRepository->exportFormations($campagneBrhp, $this->modeleCrep);


        // Fusionner les deux tableaux de formations
        $formationsSuivies = [];
        $formationsSuivies[$campagneBrhp->getAnneeEvaluee()] = $exportFormationsN1N2;

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
