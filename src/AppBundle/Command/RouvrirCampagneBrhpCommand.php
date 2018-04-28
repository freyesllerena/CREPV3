<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Service\CampagneBrhpManager;
use AppBundle\Entity\CampagneBrhp;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RouvrirCampagneBrhpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('campagneBrhp:rouvrir')
        ->setDescription('Rouvre la campagne BRHP dont l\'id est passé en paramètre')
        ->addArgument('campagne_id', InputArgument::REQUIRED, 'Id de la campagne à rouvrir ?')
        ->addArgument('utilisateur_id', InputArgument::REQUIRED, 'Id de l\'utiisateur réalisant l\'action ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $campagneId = $input->getArgument('campagne_id');
        $utilisateurId = $input->getArgument('utilisateur_id');

        $output->writeln([
            'Réouverture de la campagne id='.$campagneId.' par l\'utlisateur id='.$utilisateurId,
            '====================================================',
            '',
        ]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        /* @var $campagneBrhp CampagneBrhp */
        $campagneBrhp = $em->getRepository('AppBundle:CampagneBrhp')->find($campagneId);

        /* @var $utilisateur Utilisateur */
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->find($utilisateurId);

        /* @var $campagneBrhpManager CampagneBrhpManager */
        $campagneBrhpManager = $this->getContainer()->get('app.campagne_brhp_manager');

        // enregistrement de l'utilisateur courant dans le token_storage
        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());
        $tokenStorage = $this->getContainer()->get('security.token_storage');
        $tokenStorage->setToken($token);

        $campagneBrhpManager->rouvrir($campagneBrhp);

        $output->writeln('Campagne rouverte: '.$campagneBrhp->getLibelle());
    }
}
