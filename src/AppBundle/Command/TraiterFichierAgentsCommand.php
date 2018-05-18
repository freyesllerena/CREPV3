<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Service\ImportCsv;
use AppBundle\Service\AppMailer;

class TraiterFichierAgentsCommand extends ContainerAwareCommand
{
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
            'Chargement du fichier d\'agents sur la campagne id='.$campagneId.
            '====================================================',
            '',
        ]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $em->getRepository('AppBundle:CampagnePnc')->find($campagneId);

        $campagnePnc->setEnCoursDeChargementDuFichierAgent(true);
        $em->flush();

        /* @var $importCsvManager ImportCsv */
        $importCsvManager = $this->getContainer()->get('app.import_csv');
        $retour = $importCsvManager->importerPopulation($campagnePnc, true);

        /* @var $appMailer AppMailer */
        $appMailer = $this->getContainer()->get('app.mailer');

        // Si le retour est un tableau, c'est qu'il y a eu des erreurs au chargement
        // Envoyer une notification pour informer les administrateurs ministériels
        if (is_array($retour)) {
            $appMailer->notifierfinChargementPopulation($campagnePnc, false);

            // Supprimer le fichier d'agents suite à une erreur de chargement
            $uploadeDocument = $campagnePnc->getDocPopulation();
            $campagnePnc->setDocPopulation(null);
            $em->remove($uploadeDocument);
        } elseif (true == $retour) { // $retour == true signifie que le fichier d'agent a été correctement chargée
            $appMailer->notifierFinChargementPopulation($campagnePnc, true);
        }

        // Dans tous les cas on met le flag enCoursDeChargementDuFichierAgent à false après la fin du script asynchrone
        $campagnePnc->setEnCoursDeChargementDuFichierAgent(false);
        $em->flush();

        $output->writeln('Fin du chargement du fichier d\'agents sur la campagne : '.$retour.' '.$campagnePnc->getId());
    }
}
