<?php

namespace AppBundle\Service\ModelesCrep;

use AppBundle\Repository\FormationDemandeeAgentRepository;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Twig\AppExtension;
use AppBundle\Util\Util;
use AppBundle\Repository\FormationSuivieRepository;
use AppBundle\Repository\FormationAVenirRepository;
use AppBundle\Entity\FormationDemandeeAdministration;
use AppBundle\Repository\FormationDemandeeAdministrationRepository;
use AppBundle\Repository\FormationReglementaireRepository;
use AppBundle\Entity\ModeleCrep;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Service\MessageGenerator;
use AppBundle\Service\DoctrineUserRepository;
use AppBundle\Service\ConstanteManager;

class CrepMindef01Manager
{
    protected $em;
    
    protected $session;
    
    protected $kernelRootDir;
    
    protected $modeleCrep = 'AppBundle\Entity\Crep\CrepMindef01\CrepMindef01';

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ConstanteManager $constanteManager)
    {
    	$this->em = $entityManager;
    	$this->session = $session;
    	$this->kernelRootDir = $constanteManager->getKernelRootDir();
    }

    public function exporterFormations(CampagneBrhp $campagneBrhp, ModeleCrep $modeleCrep, \ZipArchive $zip)
    {
        $anneeEvaluee = $campagneBrhp->getCampagnePnc()->getAnneeEvaluee();

        $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $modeleCrep->getLibelle());

        $result = [];

        $result[] = $this->exportFormationsSuivies($campagneBrhp);

        $result[] = $this->exportFormationsAvenir($campagneBrhp);

        $result[] = $this->exportFormationsDemandeesAdministration($campagneBrhp);

        $result[] = $this->exportFormationsReglementaires($campagneBrhp);

        $result[] = $this->exportFormationsDemandeesAgent($campagneBrhp);

        $zip->addFile($result[0], $sousDossier.'/Formations_suivies_'.$anneeEvaluee.'.csv');
        $zip->addFile($result[1], $sousDossier.'/Formations_demandees_'.($anneeEvaluee + 1).'.csv');
        $zip->addFile($result[2], $sousDossier.'/Formations_demandees_administration.csv');
        $zip->addFile($result[3], $sousDossier.'/Formations_reglementaires.csv');
        $zip->addFile($result[4], $sousDossier.'/Formations_demandees_agents.csv');

        return $zip;
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
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Typologie', 'Libellé de la formation', 'Code de la formation', 'Priorité', 'Niveau SAME', 'CPF', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    AppExtension::selectTypologieFormationCrepMindef01($formation['f_typologie']),
                    $formation['f_libelle'],
                    $formation['f_code'],
                    $formation['f_priorite'],
                    AppExtension::echelleNiveauSameCrepMindef01($formation['f_niveauSame']),
                    AppExtension::ouiNon($formation['f_dif']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
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
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormationsAvenir(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationAVenirRepository */
        $formationRepository = $this->em->getRepository('AppBundle:FormationAVenir');

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormationsDemandeesAdministration(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationDemandeeAdministrationRepository */
        $formationRepository = $this->em->getRepository('AppBundle:FormationDemandeeAdministration');

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Typologie', 'Libellé de la formation', 'Code de la formation', 'Priorité', 'Niveau SAME', 'En lien avec les objectifs', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    AppExtension::selectTypologieFormationCrepMindef01($formation['f_typologie']),
                    $formation['f_libelle'],
                    $formation['f_code'],
                    $formation['f_priorite'],
                    AppExtension::echelleNiveauSameCrepMindef01($formation['f_niveauSame']),
                    AppExtension::ouiNon($formation['f_lienAvecObjectifs']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }

    private function exportFormationsReglementaires(CampagneBrhp $campagneBrhp)
    {
        /* @var $formationRepository FormationReglementaireRepository */
        $formationRepository = $this->em->getRepository('AppBundle:FormationReglementaire');

        $exportFormations = $formationRepository->exportFormations($campagneBrhp, $this->modeleCrep);

        $filePath = $this->kernelRootDir.'/../var/tmp/'.uniqid().$this->session->getId();

        $handle = fopen($filePath, 'w+');

        // UTF-8 BOM pour qu'il soit correctement lisible par Excel
        fputs($handle, "\xEF\xBB\xBF");

        // Nom des colonnes du CSV
        fputcsv($handle, array('Matricule', 'Email', 'Civilité', 'Nom', 'Prénom', 'Catégorie', 'Corps', 'Grade', 'Affectation', 'Libellé de la formation', 'Priorité', 'Niveau SAME', 'Date signature définitive du CREP', 'Date refus signature du CREP'), ';');

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
                    $formation['f_priorite'],
                    AppExtension::echelleNiveauSameCrepMindef01($formation['f_niveauSame']),
                    $formation['c_dateNotification'],
                    $formation['c_dateRefusNotification'],
            ), ';');
        }

        fclose($handle);

        return $filePath;
    }
}
