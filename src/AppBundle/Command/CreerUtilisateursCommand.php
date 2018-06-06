<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Service\UtilisateurManager;
use Symfony\Component\Console\Command\Command;

class CreerUtilisateursCommand extends Command
{
    protected $utilisateurManager;

    public function __construct(UtilisateurManager $utilisateurManager)
    {
    	parent::__construct();
        $this->utilisateurManager = $utilisateurManager;
    }

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

        $this->utilisateurManager->creerFromAgents($nbAgents);

        $output->writeln('Utilisateurs créés');
    }
}
