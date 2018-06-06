<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Service\CampagnePncManager;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;

class OuvrirCampagnePncCommand extends Command
{
    protected $campagnePncManager;

    protected $tokenStorage;

    protected $em;

    public function __construct(CampagnePncManager $campagnePncManager, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
    	parent::__construct();
        $this->campagnePncManager = $campagnePncManager;
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
    }

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

        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $this->em->getRepository('AppBundle:CampagnePnc')->find($campagneId);

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->find($utilisateurId);

        // enregistrement de l'utilisateur courant dans le token_storage
        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());

        $this->tokenStorage->setToken($token);

        $this->campagnePncManager->ouvrir($campagnePnc);

        $output->writeln('Campagne ouverte: '.$campagnePnc->getLibelle());
    }
}
