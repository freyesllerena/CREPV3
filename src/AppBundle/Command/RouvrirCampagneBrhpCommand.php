<?php

//namespace AppBundle\Command;

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Service\CampagneBrhpManager;
use AppBundle\Entity\CampagneBrhp;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use AppBundle\Entity\Utilisateur;

class RouvrirCampagneBrhpCommand extends Command
{
    protected $campagneBrhpManager;

    protected $tokenStorage;

    protected $em;

    public function __construct(CampagneBrhpManager $campagneBrhpManager, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
    	parent::__construct();
        $this->campagneBrhpManager = $campagneBrhpManager;
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
    }

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

        /* @var $campagneBrhp CampagneBrhp */
        $campagneBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->find($campagneId);

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->find($utilisateurId);

        // enregistrement de l'utilisateur courant dans le token_storage
        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());

        $this->tokenStorage->setToken($token);

        $$this->campagneBrhpManager->rouvrir($campagneBrhp);

        $output->writeln('Campagne rouverte: '.$campagneBrhp->getLibelle());
    }
}
