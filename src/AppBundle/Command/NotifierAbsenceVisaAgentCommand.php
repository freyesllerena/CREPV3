<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Entity\Crep;
use AppBundle\Service\CrepManager;

class NotifierAbsenceVisaAgentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('crep:notifier_absence_visa_agent')
        ->setDescription('notifie les N+1 si les agents n\'ont pas visé leur CREP dans les délais');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Notification des N+1',
            '=====================',
            '',
        ]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        $creps = $em->getRepository('AppBundle:Crep')->getCrepsEnAbsenceVisaAgent();

        /* @var $crepManager CrepManager */
        $crepManager = $this->getContainer()->get('app.crep_manager');

        /* @var $crep Crep */
        foreach ($creps as $crep) {
            $crepManager->notifierAbsenceVisaAgent($crep);

            $output->writeln('Notification de : '.$crep->getShd()->getUtilisateur()->getEmail().' pour le CREP de '.$crep->getAgent()->getUtilisateur()->getEmail());
        }

        $output->writeln('Fin des notifications');
    }
}
