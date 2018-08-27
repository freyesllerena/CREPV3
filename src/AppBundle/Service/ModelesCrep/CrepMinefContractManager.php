<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Repository\FormationDemandeeAgentRepository;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Repository\FormationSuivieRepository;
use AppBundle\Entity\ModeleCrep;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Service\ConstanteManager;

class CrepMinefContractManager
{
	protected $em;
	
	protected $session;
	
	protected $kernelRootDir;
	
	protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMinefContract\CrepMinefContract';

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

        $result[] = $this->exportFormationsDemandeesAgent($campagneBrhp);

        $zip->addFile($result[0], $sousDossier.'/Formations_suivies.csv');
        $zip->addFile($result[1], $sousDossier.'/Formations_a_envisager_T1_T2_T3.csv');

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
        fputcsv($handle, array('Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Intitulé de la formation', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        //Champs
        foreach ($exportFormations as $formation) {
            if (!is_null($formation['c_dateNotification']) || !is_null($formation['c_dateRefusNotification'])) {
                fputcsv($handle, array(
                    $formation['a_email'],
                    Util::twig_title($formation['a_civilite']),
                    $formation['a_nom'],
                    $formation['a_prenom'],
                    $formation['a_categorieAgent'],
                    $formation['a_corps'],
                    $formation['a_grade'],
                    $formation['a_affectation'],
                    $formation['f_libelle'],
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
                ), ';');
            }
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
        fputcsv($handle, array('Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Priorité', 'Intitulé de la formation', 'Type d\'actions de formation', 'DIF', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

        //Champs
        foreach ($exportFormations as $formation) {
            if (!is_null($formation['c_dateNotification']) || !is_null($formation['c_dateRefusNotification'])) {
                fputcsv($handle, array(
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
                    AppExtension::selectTypologieFormationCrepMinefContract($formation['f_typologie']),
                    AppExtension::ouiNon($formation['f_dif']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
                ), ';');
            }
        }

        fclose($handle);

        return $filePath;
    }
}
