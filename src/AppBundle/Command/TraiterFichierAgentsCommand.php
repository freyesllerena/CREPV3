<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Service\ImportCsv;
use AppBundle\Service\AppMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;

class TraiterFichierAgentsCommand extends Command
{
    protected $importCsv;

    protected $appMailer;

    protected $em;

    public function __construct(ImportCsv $importCsv, AppMailer $appMailer, EntityManagerInterface $entityManager)
    {
    	parent::__construct();
        $this->importCsv = $importCsv;
        $this->appMailer = $appMailer;
        $this->em = $entityManager;
    }

    protected function configure()
    {
        $this
        ->setName('campagnePnc:traiterFichierPopulation')
        ->setDescription('Charge le fichier population de la campagne PNC dont l\'id est passé en paramètre')
        ->addArgument('campagne_id', InputArgument::REQUIRED, 'Id de la campagne ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $campagneId = $input->getArgument('campagne_id');

        $output->writeln([
            'Chargement du fichier d\'agents sur la campagne id='.$campagneId,
            '====================================================',
            '',
        ]);

        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $this->em->getRepository('AppBundle:CampagnePnc')->find($campagneId);

        $campagnePnc->setEnCoursDeChargementDuFichierAgent(true);
        $this->em->flush();

        $retour = $this->importCsv->importerPopulation($campagnePnc, true);

        // Si le retour est un tableau, c'est qu'il y a eu des erreurs au chargement
        // Envoyer une notification pour informer les administrateurs ministériels
        if (is_array($retour)) {
            $this->appMailer->notifierfinChargementPopulation($campagnePnc, false);

            // Supprimer le fichier d'agents suite à une erreur de chargement
            $uploadeDocument = $campagnePnc->getDocPopulation();
            $campagnePnc->setDocPopulation(null);
            $this->em->remove($uploadeDocument);

            // Dans tous les cas on met le flag enCoursDeChargementDuFichierAgent à false après la fin du script asynchrone
            $campagnePnc->setEnCoursDeChargementDuFichierAgent(false);
            $this->em->flush();
            
            ob_start();
            var_dump($retour);
            $errors = ob_get_clean();
            
            $output->writeln('KO : Erreur du chargement du fichier d\'agents sur la campagne : '.$campagnePnc->getId());
            $output->writeln($errors);
            
        } elseif (true == $retour) { // $retour == true signifie que le fichier d'agent a été correctement chargée
            $this->appMailer->notifierFinChargementPopulation($campagnePnc, true);
            
            // Dans tous les cas on met le flag enCoursDeChargementDuFichierAgent à false après la fin du script asynchrone
            $campagnePnc->setEnCoursDeChargementDuFichierAgent(false);
            $this->em->flush();
            $output->writeln('OK : Fin du chargement du fichier d\'agents sur la campagne : '.$campagnePnc->getId());
        }

        $output->writeln([
        		'Fin du chargement du fichier d\'agents sur la campagne id='.$campagneId,
        		'==============================================================',
        		'',
        ]);
    }
}
