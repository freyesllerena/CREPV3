<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Entity\CampagneBrhp;
use AppBundle\Util\Util;
use AppBundle\Entity\ModeleCrep;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Service\ConstanteManager;

class CrepDgacManager
{
	protected $em;
	
	protected $session;
	
	protected $kernelRootDir;
	
	protected $modeleCrep = 'AppBundle\Entity\Crep\CrepDgac\CrepDgac';

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ConstanteManager $constanteManager)
    {
    	$this->em = $entityManager;
    	$this->session = $session;
    	$this->kernelRootDir = $constanteManager->getKernelRootDir();
    }

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp);

//         $result[] = $this->exportFormationsSollicitees($campagneBrhp);

//         $result[] = $this->exportFormationsEnvisagees($campagneBrhp);

        $zip->addFile($result[0], $sousDossier.'/Formations_suivies.csv');
//         $zip->addFile($result[1], $sousDossier.'/Formations_sollicitees.csv');
//         $zip->addFile($result[2], $sousDossier.'/Formations_envisagees.csv');

        return $zip;
    }

    // Export des formations suivies
    private function exportFormationsSuivies(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations suivies N-1
        // AppBundle\Repository\CrepRepository\CrepDgacRepository
        $formationSuivieRepository = $this->em->getRepository("AppBundle:Crep\CrepDgac\CrepDgacFormationSuivie");

        $formationsSuivies = $formationSuivieRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Durée', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        // Champs
        foreach ($formationsSuivies as $formation) {
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
                    $formation['f_duree'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    // Export des formations sollicitees
    private function exportFormationsSollicitees(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations sollicitees
        $formationSolliciteRepository = $this->em->getRepository("AppBundle:Crep\CrepDgac\CrepDgacFormationSollicitee");

        $formationsSuivies = $formationSolliciteRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Origine de la demande', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        $originesFormations = [
                0 => 'Formation proposée par l\'administration',
                1 => 'Formation demandée par l\'agent',
                2 => 'Formation demandée par les deux parties',
        ];

        foreach ($formationsSuivies as $formation) {
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
                    null !== $formation['f_origine'] ? $originesFormations[$formation['f_origine']] : '',
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    // Export des formations envisagees
    private function exportFormationsEnvisagees(CampagneBrhp $campagneBrhp)
    {
        // Repository des formations envisagees
        $formationEnvisageesRepository = $this->em->getRepository("AppBundle:Crep\CrepDgac\CrepDgacFormationEnvisagee");

        $formationsEnvisagees = $formationEnvisageesRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Origine de la demande', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        $originesFormations = [
                0 => 'Formation proposée par l\'administration',
                1 => 'Formation demandée par l\'agent',
                2 => 'Formation demandée par les deux parties',
        ];

        foreach ($formationsEnvisagees as $formation) {
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
                    null !== $formation['f_origine'] ? $originesFormations[$formation['f_origine']] : '',
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
