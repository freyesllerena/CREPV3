<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Crep;
use AppBundle\Service\CrepManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;

class NotifierAbsenceVisaAgentCommand extends Command
{
    protected $crepManager;

    protected $em;

    public function __construct(CrepManager $crepManager, EntityManagerInterface $entityManager)
    {
    	parent::__construct();
        $this->crepManager = $crepManager;
        $this->em = $entityManager;
    }

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

        $creps = $this->em->getRepository('AppBundle:Crep')->getCrepsEnAbsenceVisaAgent();

        /* @var $crep Crep */
        foreach ($creps as $crep) {
            $this->crepManager->notifierAbsenceVisaAgent($crep);

            $output->writeln('Notification de : '.$crep->getShd()->getUtilisateur()->getEmail().' pour le CREP de '.$crep->getAgent()->getUtilisateur()->getEmail());
        }

        $output->writeln('Fin des notifications');
    }
}
