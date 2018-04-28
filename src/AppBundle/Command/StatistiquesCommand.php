<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Service\StatistiquesManager;

class StatistiquesCommand extends ContainerAwareCommand
{
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

        /* @var $statistiquesManager StatistiquesManager */
        $statistiquesManager = $this->getContainer()->get('app.statistiques_manager');

        $statistiquesManager->calculer();

        $output->writeln('Statistiques calcules');
    }
}
