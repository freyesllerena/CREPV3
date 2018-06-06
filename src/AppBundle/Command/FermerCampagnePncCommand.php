<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Service\CampagnePncManager;
use AppBundle\Entity\CampagnePnc;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Console\Command\Command;

class FermerCampagnePncCommand extends Command
{
    protected $campagnePncManager;

    public function __construct(CampagnePncManager $campagnePncManager)
    {
    	parent::__construct();
        $this->campagnePncManager = $campagnePncManager;
    }

    protected function configure()
    {
        $this
        ->setName('campagnePnc:fermer')
        ->setDescription('Fermer la campagne PNC dont l\'id est passé en paramètre')
        ->addArgument('campagne_id', InputArgument::REQUIRED, 'Id de la campagne à fermer ?')
        ->addArgument('utilisateur_id', InputArgument::REQUIRED, 'Id de l\'utiisateur réalisant l\'action ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $campagneId = $input->getArgument('campagne_id');
        $utilisateurId = $input->getArgument('utilisateur_id');

        $output->writeln([
            'Fermeture de la campagne id='.$campagneId.' par l\'utlisateur id='.$utilisateurId,
            '====================================================',

            '',
        ]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $em->getRepository('AppBundle:CampagnePnc')->find($campagneId);

        /* @var $utilisateur Utilisateur */
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->find($utilisateurId);

        // enregistrement de l'utilisateur courant dans le token_storage
        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());
        $tokenStorage = $this->getContainer()->get('security.token_storage');
        $tokenStorage->setToken($token);

        $this->campagnePncManager->fermer($campagnePnc);

        $output->writeln('Campagne fermée: '.$campagnePnc->getLibelle());
    }
}
