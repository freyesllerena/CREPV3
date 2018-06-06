<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Service\StatistiquesManager;
use Symfony\Component\Console\Command\Command;

class StatistiquesCommand extends Command
{
    protected $statistiquesManager;

    public function __construct(StatistiquesManager $statistiquesManager)
    {
    	parent::__construct();
        $this->statistiquesManager = $statistiquesManager;
    }

    protected function configure()
    {
        $this
        ->setName('calculer:statistiques')
        ->setDescription('Calcule les statistiques des campagnes ouvertes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Calcul des statistiques',
            '=======================',
            '',
        ]);

        $this->statistiquesManager->calculer();

        $output->writeln('Statistiques calcules');
    }
}
