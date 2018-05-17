<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT2Repository;
use AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT3Repository;
use AppBundle\Repository\FormationSuivieRepository;
use AppBundle\Service\BaseManager;
use AppBundle\Entity\CampagneBrhp;
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
        $result[] = $this->exportFormations($campagneBrhp);
        $zip->addFile($result[0], $sousDossier.'/Besoins_formation_suivi_'.($campagneBrhp->getAnneeEvaluee() - 1).'_'.$campagneBrhp->getAnneeEvaluee().'.csv');

        return $zip;
    }

    // Export des formations suivies N-1 et N-2
    private function exportFormations(CampagneBrhp $campagneBrhp)
    {
        // Repository de chaque formation
        /** @var FormationSuivieRepository $formationSuivieRepository */
        $formationSuivieRepository = $this->em->getRepository("AppBundle:FormationSuivie");
        /** @var CrepMcc02FormationT1Repository $formationT1Repository */
        $formationT1Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT1");
        /** @var CrepMcc02FormationT2Repository $formationT2Repository */
        $formationT2Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT2");
        /** @var CrepMcc02FormationT3Repository $formationT3Repository */
        $formationT3Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT3");

        $exportFormationSuivie = $formationSuivieRepository->exportFormations($campagneBrhp, $this->modeleCrep);
        $exportFormationT1 = $formationT1Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        $exportFormationT2 = $formationT2Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        $exportFormationT3 = $formationT3Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        // On regroupe toutes les formations
        $allFormation = array_merge($exportFormationSuivie, $exportFormationT1, $exportFormationT2, $exportFormationT3);


        // Fusionner les deux tableaux de formations
        $formationsSuivies = [];
        $formationsSuivies[$campagneBrhp->getAnneeEvaluee()] = $allFormation;

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Année', 'Libellé de la formation', 'Recours au CPF',  'Commentaires', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        // Champs
        // $key = annee (N-1 ou N-2)
        // $value = tableau des formations demandées
        foreach ($formationsSuivies as $key => $formations) {

            foreach ($formations as $formation) {
                $cpf = '';
                if (isset($formation['f_cpf'] ) ) {
                    if ($formation['f_cpf'] == 1) {
                        $cpf = 'Oui';
                    } elseif($formation['f_cpf'] == 0) {
                        $cpf = 'Non';
                    }
                }

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
                    $cpf,
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
                ), ';');
            }
        }

        fclose($handle);

        return $filePath;
    }
}
