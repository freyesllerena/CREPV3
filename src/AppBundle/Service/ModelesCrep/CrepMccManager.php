<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Service\BaseManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Repository\FormationSuivieRepository;
use AppBundle\Repository\CrepRepository\CrepMccRepository\CrepMccFormationAdapatationPosteRepository;
use AppBundle\Entity\ModeleCrep;

class CrepMccManager extends BaseManager
{
    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMcc\CrepMcc';

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp);

        $result[] = $this->exportFormationsAdaptationPosteTravail($campagneBrhp);

        $result[] = $this->exportFormations($campagneBrhp, "AppBundle:Crep\CrepMcc\CrepMccFormationMetier");

        $result[] = $this->exportFormations($campagneBrhp, "AppBundle:Crep\CrepMcc\CrepMccFormationDevQualif");

        $result[] = $this->exportFormations($campagneBrhp, "AppBundle:Crep\CrepMcc\CrepMccFormationPrepaConcours");

        $result[] = $this->exportFormations($campagneBrhp, "AppBundle:Crep\CrepMcc\CrepMccFormationAutresActions");

        $zip->addFile($result[0], $sousDossier.'/Formations_suivies.csv');
        $zip->addFile($result[1], $sousDossier.'/Formations_adaptation_immediate_poste_de_travail_T1.csv');
        $zip->addFile($result[2], $sousDossier.'/Formations_evolution_des_metiers_T2.csv');
        $zip->addFile($result[3], $sousDossier.'/Formations_developpement_acquisition_nouvelles_competences_T3.csv');
        $zip->addFile($result[4], $sousDossier.'/Formations_prepartion_concours_examens.csv');
        $zip->addFile($result[5], $sousDossier.'/Formations_autres_actions.csv');

        return $zip;
    }

    private function exportFormationsSuivies(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationSuivieRepository */
        $formationRepository = $this->em->getRepository('AppBundle:FormationSuivie');

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Année', 'Formation suivie', 'Commentaires', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['f_annee'],
                    $formation['f_libelle'],
                    $formation['f_commentaires'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormationsAdaptationPosteTravail(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository CrepMccFormationAdapatationPosteRepository */
        $formationRepository = $this->em->getRepository("AppBundle:Crep\CrepMcc\CrepMccFormationAdapatationPoste");

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Intitulé de la formation', 'Origine de la demande', 'En lien avec les objectifs', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    AppExtension::origineDemandeFormationCrepMcc($formation['f_origine']),
                    AppExtension::ouiNon($formation['f_besoinAvere']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormations(CampagneBrhp $campagneBrhp, $repositoryName)
    {
        $formationRepository = $this->em->getRepository($repositoryName);

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Intitulé de la formation', 'Origine de la demande', 'En lien avec les objectifs', 'Recours au CPF', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    AppExtension::origineDemandeFormationCrepMcc($formation['f_origine']),
                    AppExtension::ouiNon($formation['f_besoinAvere']),
                    AppExtension::ouiNon($formation['f_cpf']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
