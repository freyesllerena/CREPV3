<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Service\UtilisateurManager;

class CreerUtilisateursCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('utilisateurs:creer')
        ->setDescription('Crée les comptes utilisateurs par lot')
        ->addArgument('nb_agents', InputArgument::REQUIRED, 'Nombre d\'agents ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nbAgents = $input->getArgument('nb_agents');

        $output->writeln([
            'Creation de '.$nbAgents.'comptes utilisateurs',
            '================================',
            '',
        ]);

        /* @var $utilisateurManager UtilisateurManager */
        $utilisateurManager = $this->getContainer()->get('utilisateur_manager');

        $utilisateurManager->creerFromAgents($nbAgents);

        $output->writeln('Utilisateurs créés');
    }
}
