<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Service\BaseManager;
use AppBundle\Repository\FormationDemandeeAgentRepository;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Repository\FormationAcSuivieRepository;
use AppBundle\Entity\ModeleCrep;

class CrepAcManager extends BaseManager
{
    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepAc\CrepAc';

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp);

        $result[] = $this->exportFormationsDemandeesAgent($campagneBrhp);

        $zip->addFile($result[0], $sousDossier.'/Formations_suivies.csv');
        $zip->addFile($result[1], $sousDossier.'/Besoins_de_formation.csv');

        return $zip;
    }

    private function exportFormationsSuivies(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationAcSuivieRepository */
        $formationRepository = $this->em->getRepository("AppBundle:Crep\CrepAc\FormationAcSuivie");

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Année', 'Intitulé de la formation', 'Durée', 'Commentaires', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['f_duree'],
                    $formation['f_commentaires'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormationsDemandeesAgent(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationDemandeeAgentRepository */
        $formationRepository = $this->em->getRepository('AppBundle:FormationDemandeeAgent');

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Priorité', 'Intitulé de la formation', 'Type d\'actions de formation', 'DIF', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['f_priorite'],
                    $formation['f_libelle'],
                    AppExtension::selectTypologieFormationCrepMinefAbc($formation['f_typologie']),
                    AppExtension::ouiNon($formation['f_dif']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
