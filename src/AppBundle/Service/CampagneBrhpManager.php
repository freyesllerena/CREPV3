<?php

namespace AppBundle\Service;

use AppBundle\Entity\Agent;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\CampagneRlc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Repository\AgentRepository;
use Doctrine\Tests\Common\DataFixtures\TestEntity\User;
use AppBundle\Entity\Campagne;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\CampagnePnc;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;
use AppBundle\Util\Util;

class CampagneBrhpManager
{
    /* @var $repository CampagneBrhpRepository */

    protected $em;

    protected $tokenStorage;

    protected $personneManager;

    protected $appMailer;

    /* @var $repository CampagneBrhpRepository */
    protected $repository;

    public function __construct(
            EntityManagerInterface $entityManager,
            TokenStorageInterface $tokenStorage,
            PersonneManager $personneManager,
            AppMailer $appMailer
    ) {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->personneManager = $personneManager;
        $this->appMailer = $appMailer;
        
        $this->repository = $this->em->getRepository('AppBundle:CampagneBrhp');
    }

    /**
     * Crée les campagne BRHP à partir des périmètres de la campagne BRHP.
     *
     * @param CampagneRlc $campagneRlc
     */
    public function creer(CampagneRlc $campagneRlc, $nouveauxPerimetresBrhp = [])
    {
        $perimetresBrhp = $campagneRlc->getPerimetresBrhp();
        $perimetresBrhpIds = array();

        foreach ($nouveauxPerimetresBrhp as $perimetreBrhp) {
            $perimetresBrhpIds[$perimetreBrhp->getId()] = $perimetreBrhp;
        }

        $campagnesBrhp = array();

        // Création des campagnes BRHP : une campagne BRHP par périmètre BRHP
        foreach ($perimetresBrhp as $perimetreBrhp) {
            if (empty($nouveauxPerimetresBrhp) || isset($perimetresBrhpIds[$perimetreBrhp->getId()])) {
                $campagneBrhp = new CampagneBrhp();
                $campagneBrhp
                    ->setCampagneRlc($campagneRlc)
                    ->setPerimetreBrhp($perimetreBrhp);

                if ($campagneRlc->getCampagnePnc()->getDiffusee()) {
                    $campagneBrhp->setStatut(EnumStatutCampagne::CREEE);
                } else {
                    $campagneBrhp->setStatut(EnumStatutCampagne::INITIALISEE);
                }
                $this->em->persist($campagneBrhp);
                $campagnesBrhp[] = $campagneBrhp;
            }
        }
        $this->em->flush();

        return $campagnesBrhp;
    }

    /** Récupérer l'utilisateur courant
     *
     * @return User
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Envoyer les listes aux N+1.
     *
     * @param CampagneBrhp $campagneBrhp
     */
    public function ouvrirShd(CampagneBrhp $campagneBrhp)
    {
        $campagneBrhp->setStatut(EnumStatutCampagne::OUVERTE);
        $campagneBrhp->setDateOuverture(new \DateTime());
        $campagneBrhp->setOuvertePar($this->getUser());

        $this->em->persist($campagneBrhp);
        $this->em->flush();

        /* @var $repositoryAgent AgentRepository */
        $repositoryAgent = $this->em->getRepository('AppBundle:Agent');

        // On récupère tous les N+1 de la campagne BRHP
        $shds = $repositoryAgent->getShdsByCampagneBrhp($campagneBrhp);

        if (!empty($shds)) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs($shds, 'ROLE_SHD');
        }
        //Notifications au N+1
        $this->appMailer->notifierOuvrirShd($campagneBrhp);
    }

    /*
     * Rouvrir une campagne BRHP
     */
    public function rouvrir(CampagneBrhp $campagneBrhp)
    {
        $campagneBrhp->setStatut(EnumStatutCampagne::OUVERTE);
        $campagneBrhp->setDateOuverture(new \DateTime());
        $campagneBrhp->setOuvertePar($this->getUser());

        $this->em->persist($campagneBrhp);
        $this->em->flush();
    }

    public function getHistoriqueIndicateurs(CampagneBrhp $campagneBrhp)
    {
        return $this->em->getRepository("AppBundle:Statistiques\StatCampagneBrhp")->getHistoriqueIndicateurs($campagneBrhp);
    }
    
    public function getCampagnesBrhpByCampagneRlc(CampagneRlc $campagneRlc){
    	return $this->repository->getCampagnesBrhpByCampagneRlc($campagneRlc);
    }
    
    /**
     * Sauvegarder l'entité.
     *
     * @param Campagne $campagne
     */
    public function sauvegarder(CampagneBrhp $campagneBrhp)
    {
    	$this->em->persist($campagneBrhp);
    	$this->em->flush();
    }
    
    public function exporterPopulation(CampagneBrhp $campagneBrhp)
    {
    	$streamedResponse = new StreamedResponse(function() use($campagneBrhp)
    	{
    		/* @var $agentRepository AgentRepository */
    		$agentRepository = $this->em->getRepository(Agent::class);
    
    		$donneesAgents = $agentRepository->exportDonneesAgents($campagneBrhp);
    
    		$handle = fopen('php://output', 'r+');
    
    		// UTF-8 BOM pour qu'il soit correctement lisible par Excel
    		fputs($handle, "\xEF\xBB\xBF");
    
    		// Nom des colonnes du CSV
    		fputcsv($handle, array('Agent', 'Affectation', 'N+1', 'N+2', 'Evaluable', 'Statut', 'Avancement du CREP'), ';');
    
    
    		foreach ($donneesAgents as $donneesAgent){
    			fputcsv($handle, [
    					Util::identiteAgent($donneesAgent['civilite'], $donneesAgent['titre'], $donneesAgent['prenom'], $donneesAgent['nom'], $donneesAgent['email']),
    					$donneesAgent['affectation'],
    					Util::identiteAgent($donneesAgent['shd_civilite'], $donneesAgent['shd_titre'], $donneesAgent['shd_prenom'], $donneesAgent['shd_nom'], $donneesAgent['shd_email']),
    					Util::identiteAgent($donneesAgent['ah_civilite'], $donneesAgent['ah_titre'], $donneesAgent['ah_prenom'], $donneesAgent['ah_nom'], $donneesAgent['ah_email']),
    					Util::formatEvaluable($donneesAgent['evaluable']),
    					'1' == $donneesAgent['evaluable'] ? Util::formatStatutValidation($donneesAgent['statutValidation']) : '',
    					'1' == $donneesAgent['evaluable'] ? Util::formatStatutCrep($donneesAgent['crep_statut']) : ''
    			], ';');
    		}
    
    		fclose($handle);
    	});
    	 
    	$streamedResponse->headers->set('Content-Type', 'application/force-download');
    	$streamedResponse->headers->set('Content-Disposition','attachment; filename="export.csv"');
    	 
    	return $streamedResponse;
    }
}
