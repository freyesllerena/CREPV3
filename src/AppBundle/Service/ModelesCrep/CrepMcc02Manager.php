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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Service\ConstanteManager;

/**
 * Class CrepMcc02Manager
 * @package AppBundle\Service\ModelesCrep
 */
class CrepMcc02Manager extends BaseManager
{
    protected $em;

    protected $session;

    protected $kernelRootDir;

    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02';

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ConstanteManager $constanteManager)
    {
        $this->em = $entityManager;
        $this->session = $session;
        $this->kernelRootDir = $constanteManager->getKernelRootDir();
    }


    /**
     * Export de Formations suivies et Recueil des
     * @param CampagneBrhp $campagneBrhp
     * @param ModeleCrep $modeleCrep
     * @param \ZipArchive $zip
     * @return \ZipArchive
     */
    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());
        $result = [];
        $result[] = $this->exportFormationsSuivies($campagneBrhp);
        $result[] = $this->exportBesoinsFormations($campagneBrhp);
        $zip->addFile($result[0], $sousDossier.'/Formations_suivies_'.($campagneBrhp->getAnneeEvaluee() - 1).'_'.$campagneBrhp->getAnneeEvaluee().'.csv');
        $zip->addFile($result[1], $sousDossier.'/Recueil_des_besoins_de_formation_'.($campagneBrhp->getAnneeEvaluee() + 1).'_'.($campagneBrhp->getAnneeEvaluee() + 2).'.csv');

        return $zip;
    }

    /**
     * Esport Recuiel de besoin de formation
     *
     * @param CampagneBrhp $campagneBrhp
     * @return string
     */
    private function exportBesoinsFormations(CampagneBrhp $campagneBrhp)
    {
        /** @var CrepMcc02FormationT1Repository $formationT1Repository */
        $formationT1Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT1");
        /** @var CrepMcc02FormationT2Repository $formationT2Repository */
        $formationT2Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT2");
        /** @var CrepMcc02FormationT3Repository $formationT3Repository */
        $formationT3Repository = $this->em->getRepository("AppBundle:Crep\CrepMcc02\CrepMcc02FormationT3");

        $exportFormationT1 = $formationT1Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        $exportFormationT2 = $formationT2Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        $exportFormationT3 = $formationT3Repository->exportFormations($campagneBrhp, $this->modeleCrep);
        // On regroupe toutes les formations
        $allFormation = array_merge($exportFormationT1, $exportFormationT2, $exportFormationT3);

        // Fusionner les deux tableaux de formations
        $exportFormation = [];
        $exportFormation[$campagneBrhp->getAnneeEvaluee()] = $allFormation;

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, [
            'Matricule',
            'Email',
            'Civilité',
            'Nom',
            'Prénom',
            'Catégorie',
            'Corps',
            'Grade',
            'Affectation',
            'Année',
            'Libellé de la formation',
            'Sur demande de l\'agent',
            'Avis du responsable hiérarchique',
            'Sur demande du responsable hiérarchique',
            'Recours au CPF',
            'Échéance',
            'Date signature définitive du CREP',
            'Date refus signature du CREP'
        ], ';');

        foreach ($exportFormation as $key => $formations) {

            foreach ($formations as $formation) {
                $demandeeAgent = $this->choixDemandeFormation($formation, 'f_demandeeAgent');
                $avisShd = $this->choixDemandeFormation($formation, 'f_avisShd');
                $propositionAh = $this->choixDemandeFormation($formation, 'f_propositionAh');
                $cpf = $this->choixDemandeFormation($formation, 'f_cpf');
                if (!is_null($formation['c_dateNotification']) || !is_null($formation['c_dateRefusNotification'])) {
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
                        $demandeeAgent,
                        $avisShd,
                        $propositionAh,
                        $cpf,
                        $formation['f_echeance'],
                        $formation['c_dateNotification'],
                        $formation['c_dateRefusNotification'],
                    ), ';');
                }
            }
        }
        fclose($handle);

        return $filePath;
    }

    /**
     * Export des formatins suivies
     * @param CampagneBrhp $campagneBrhp
     * @return string
     */
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
        fputcsv($handle, [
            'Matricule',
            'Email',
            'Civilité',
            'Nom',
            'Prénom',
            'Catégorie',
            'Corps',
            'Grade',
            'Affectation',
            'Année',
            'Formation demandée',
            'Formation suivie',
            'Commentaires',
            'Date signature définitive du CREP',
            'Date refus signature du CREP'
        ], ';');

        foreach ($exportFormations as $formation) {
            if (!is_null($formation['c_dateNotification']) || !is_null($formation['c_dateRefusNotification'])) {
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
                    $formation['f_libelle2'],
                    $formation['f_libelle'],
                    $formation['f_commentaires'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
                ), ';');
            }
        }

        fclose($handle);

        return $filePath;
    }

    /**
     * Choix demande de formation
     *
     * @param $formation
     * @param $recueil
     * @return string
     */
    private function choixDemandeFormation($formation, $recueil)
    {
        $isChoisie = '';
        if (isset($formation[$recueil] ) ) {
            if ($formation[$recueil] == 1) {
                $isChoisie = 'Oui';
            } elseif($formation[$recueil] == 0) {
                $isChoisie = 'Non';
            }
        }

        return $isChoisie;
    }
}
