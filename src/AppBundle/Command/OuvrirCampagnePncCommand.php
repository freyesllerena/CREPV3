<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Service\CampagnePncManager;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class OuvrirCampagnePncCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('campagnePnc:ouvrir')
        ->setDescription('Ouvre la campagne PNC dont l\'id est passé en paramètre')
        ->addArgument('campagne_id', InputArgument::REQUIRED, 'Id de la campagne à ouvrir ?')
        ->addArgument('utilisateur_id', InputArgument::REQUIRED, 'Id de l\'utiisateur réalisant l\'action ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $campagneId = $input->getArgument('campagne_id');
        $utilisateurId = $input->getArgument('utilisateur_id');

        $output->writeln([
            'Ouverture de la campagne id='.$campagneId.' par l\'utlisateur id='.$utilisateurId,
            '====================================================',
            '',
        ]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $em->getRepository('AppBundle:CampagnePnc')->find($campagneId);

        /* @var $utilisateur Utilisateur */
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->find($utilisateurId);

        /* @var $campagnePncManager CampagnePncManager */
        $campagnePncManager = $this->getContainer()->get('app.campagne_pnc_manager');

        // enregistrement de l'utilisateur courant dans le token_storage
        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());
        $tokenStorage = $this->getContainer()->get('security.token_storage');
        $tokenStorage->setToken($token);

        $campagnePncManager->ouvrir($campagnePnc);

        $output->writeln('Campagne ouverte: '.$campagnePnc->getLibelle());
    }
}
