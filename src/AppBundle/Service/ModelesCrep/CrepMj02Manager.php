<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 18/07/2018
 * Time: 15:18
 */

namespace AppBundle\Service\ModelesCrep;


use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Repository\CrepRepository\CrepMj02Repository\CrepMj02FormationAnneeAvenirRepository;
use AppBundle\Repository\CrepRepository\CrepMj02Repository\CrepMj02FormationAnneeEcouleeRepository;
use AppBundle\Service\ConstanteManager;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CrepMj02Manager
 * @package AppBundle\Service\ModelesCrep
 */
class CrepMj02Manager
{
    protected $em;

    protected $session;

    protected $kernelRootDir;

    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMj02\CrepMj02';

    /**
     * CrepMj02Manager constructor.
     * @param EntityManagerInterface $entityManager
     * @param SessionInterface $session
     * @param ConstanteManager $constanteManager
     */
    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ConstanteManager
    $constanteManager)
    {
        $this->em = $entityManager;
        $this->session = $session;
        $this->kernelRootDir = $constanteManager->getKernelRootDir();
    }

    /**
     * Exporter Formations
     *
     * @param CampagneBrhp $campagneBrhp
     * @param ModeleCrep $modeleCrep
     * @param \ZipArchive $zip
     * @return \ZipArchive
     */
    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());
        $result = [];
        $result[] = $this->exportFormationAnneeEcoulee($campagneBrhp);
        $result[] = $this->exportFormationAnneeAvenir($campagneBrhp);
        $zip->addFile($result[0], $sousDossier.'/Formations_demandees_annee_ecoulee.csv');
        $zip->addFile($result[1], $sousDossier.'/Formations_demandees_annee_a_venir.csv');

        return $zip;
    }

    /**
     *  Export des formations demandées année écoulée
     *
     * @param CampagneBrhp $campagneBrhp
     *
     * @return string
     */
    private function exportFormationAnneeEcoulee(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations demandées année écoulée
        /** @var CrepMj02FormationAnneeEcouleeRepository $formationAnneeEcouleeRepository */
        $formationAnneeEcouleeRepository = $this->em->getRepository("AppBundle:Crep\CrepMj02\CrepMj02FormationAnneeEcoulee");
        $formationsAnneeEcoulees = $formationAnneeEcouleeRepository->exportFormations($campagneBrhp, $this->modeleCrep);
        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();
        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array(
            'Matricule',
            'Email',
            'Civilité',
            'Nom',
            'Prénom',
            'Catégorie',
            'Corps',
            'Grade',
            'Affectation',
            'Intitulé ou thématique de la formation',
            'Objet de la formation',
            'Durée de la formation',
            'Mobilisation du CPF',
            'Cadre de la formation T1, T2 ou T3',
            'Suivies',
            'Motifs',
            'Date signature définitive du CREP',
            'Date refus signature du CREP'
        ), ';');

        // Champs
        foreach ($formationsAnneeEcoulees as $formation) {
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
                $formation['f_objectif'],
                $formation['f_duree'],
                AppExtension::ouiNon($formation['f_cpf']),
                $formation['f_typologie'],
                AppExtension::ouiNon($formation['f_suivie']),
                $formation['f_motifNonSuivie'],
                $formation['c_dateNotification'],
                $formation['c_dateRefusNotification'],
            ), ';');
        }
        fclose($handle);

        return $filePath;
    }

    /**
     * Export des formations envisagees
     *
     * @param CampagneBrhp $campagneBrhp
     * @return string
     */
    private function exportFormationAnneeAvenir(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations année à venir
        /** @var CrepMj02FormationAnneeAvenirRepository $formationAnneeAsuivreRepository */
        $formationAnneeAsuivreRepository = $this->em->getRepository("AppBundle:Crep\CrepMj02\CrepMj02FormationAnneeAvenir");
        $formationsAnneeAsuivre = $formationAnneeAsuivreRepository->exportFormations($campagneBrhp, $this->modeleCrep);
        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();
        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array(
            'Matricule',
            'Email',
            'Civilité',
            'Nom',
            'Prénom',
            'Catégorie',
            'Corps',
            'Grade',
            'Affectation',
            'Intitulé ou thématique de la formation',
            'Objet de la formation',
            'Durée de la formation',
            'Mobilisation du CPF',
            'Cadre de la formation T1, T2 ou T3',
            'Suivies',
            'Motifs',
            'Date signature définitive du CREP',
            'Date refus signature du CREP'
        ), ';');

        foreach ($formationsAnneeAsuivre as $formation) {
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
                $formation['f_objectif'],
                $formation['f_duree'],
                AppExtension::ouiNon($formation['f_cpf']),
                $formation['f_typologie'],
                AppExtension::ouiNon($formation['f_suivie']),
                $formation['f_motifNonSuivie'],
                $formation['c_dateNotification'],
                $formation['c_dateRefusNotification'],
            ), ';');
        }
        fclose($handle);

        return $filePath;
    }
}
