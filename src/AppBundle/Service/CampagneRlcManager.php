<?php

namespace AppBundle\Service;

use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\Campagne;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\Agent;
use AppBundle\Entity\CampagneBrhp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use AppBundle\Util\Util;

class CampagneRlcManager extends CampagneManager
{
    /* @var $campagneBrhpManager CampagneBrhpManager */
    protected $campagneBrhpManager;

    protected $em;

    /* @var $repository CampagneRlcRepository */
    protected $repository;

    public function __construct(
        PersonneManager $personneManager,
        CampagneBrhpManager $campagneBrhpManager,
        TokenStorageInterface $tokenStorage,
        AppMailer $mailer,
        EngineInterface $templating,
        EntityManagerInterface $entityManager
    ) {
        $this->personneManager = $personneManager;
        $this->campagneBrhpManager = $campagneBrhpManager;
        $this->tokenStorage = $tokenStorage;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('AppBundle:CampagneRlc');
    }

    /**
     * Crée les campagne RLC à partir des périmètres de la campagne PNC.
     *
     * @param CampagnePnc $campagnePnc
     */
    public function creer(CampagnePnc $campagnePnc, $nouveauxPerimetresRlc = [])
    {
        $perimetresRlc = $campagnePnc->getPerimetresRlc();
        $perimetresRlcIds = array();

        foreach ($nouveauxPerimetresRlc as $perimetreRlc) {
            $perimetresRlcIds[$perimetreRlc->getId()] = $perimetreRlc;
        }

        // Création des campagnes RLC : une campagne RLC par périmètre RLC
        foreach ($perimetresRlc as $perimetreRlc) {
            if (empty($nouveauxPerimetresRlc) || isset($perimetresRlcIds[$perimetreRlc->getId()])) {
                $campagneRlc = new CampagneRlc();
                $campagneRlc
                    ->setCampagnePnc($campagnePnc)
                    ->setPerimetreRlc($perimetreRlc)
                    ->setStatut(EnumStatutCampagne::INITIALISEE)
                ;
                $this->em->persist($campagneRlc);
            }
        }

        $this->em->flush();
    }

    /**
     * Ouvre la campagne Rlc.
     *
     * @param CampagneRlc $campagneRlc
     */
    public function ouvrir(CampagneRlc $campagneRlc)
    {
        $campagneRlc->setStatut(EnumStatutCampagne::OUVERTE);
        $campagneRlc->setDateOuverture(new \DateTime());
        $campagneRlc->setOuvertePar($this->getUser());

        $this->em->persist($campagneRlc);

        $perimetresBrhp = $campagneRlc->getPerimetresBrhp();

        $brhps = $this->personneManager->getBrhps($perimetresBrhp);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($brhps, 'ROLE_BRHP');

        $brhpsConsult = $this->personneManager->getBrhpsConsult($perimetresBrhp);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($brhpsConsult, 'ROLE_BRHP_CONSULT');

        // crée les campagne BRHP à partir des périmètres de la campagne BRHP
        $campagnesBrhp = $this->campagneBrhpManager->creer($campagneRlc);

        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        // Il faut rattacher les agents aux campagnes BRHP qu'on vient de créer et aux périmetres Brhp
        foreach ($campagnesBrhp as $campagneBrhp) {
            $agents = $agentRepository->getAgentsByPerimetreBrhp($campagneBrhp->getPerimetreBrhp(), $campagneRlc->getCampagnePnc());

            /* @var $agent Agent */
            foreach ($agents as $agent) {
                $agent->setCampagneBrhp($campagneBrhp);
                $agent->setPerimetreBrhp($campagneBrhp->getPerimetreBrhp());
            }
        }

        $this->em->flush();

        $this->mailer->notifierOuvrirCampagneRlc($campagneRlc);
    }

    /*
     * Rouvrir une campagne Rlc, et notifier les brhp
     */
    public function rouvrir(CampagneRlc $campagneRlc)
    {
        $campagneRlc->setStatut(EnumStatutCampagne::OUVERTE);
        $campagneRlc->setDateOuverture(new \DateTime());
        $campagneRlc->setOuvertePar($this->getUser());

        //On récupère les campagnes BRHP rattachées à la campagneRlc
        $campagnesBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->getCampagnesBrhpByCampagneRlc($campagneRlc);

        $anciensPerimetresBrhp = array();
        //On récupère les périmètres BRHP des campagnes BRHP préalablement récupérés
        /* @var $campagneBrhp CampagneBrhp */
        foreach ($campagnesBrhp as $campagneBrhp) {
            $anciensPerimetresBrhp[] = $campagneBrhp->getPerimetreBrhp();
        }

        //On vérifie s'il y a des nouveaux périmètres BRHP qui ont été ajoutés à la campagne
        $nouveauxPerimetresBrhp = array_diff($campagneRlc->getPerimetresBrhp()->getValues(), $anciensPerimetresBrhp);

        if ($nouveauxPerimetresBrhp) {
            $nouveauxPerimetresBrhp = array_values($nouveauxPerimetresBrhp);
            $collectionNouveauxPerimetresBrhp = new ArrayCollection($nouveauxPerimetresBrhp);
            $this->ouvrirNouveauxPerimetres($campagneRlc, $collectionNouveauxPerimetresBrhp);
        }

        $this->em->persist($campagneRlc);
        $this->em->flush();
        
        $this->mailer->notifierRouvrirCampagne($campagneRlc);
    }

    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Ouvre un nouveau périmètre.
     *
     * @param CampagnePnc $campagneRlc
     * @param Collection  $perimetresBrhp
     */
    public function ouvrirNouveauxPerimetres(CampagneRlc $campagneRlc, Collection $perimetresBrhp)
    {
        $brhps = $this->personneManager->getBrhps($perimetresBrhp);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($brhps, 'ROLE_BRHP');

        // crée les campagne BRHP à partir des périmètres de la campagne BRHP
        $campagnesBrhp = $this->campagneBrhpManager->creer($campagneRlc, $perimetresBrhp->toArray());

        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        // Il faut rattacher les agents aux campagnes BRHP qu'on vient de créer et aux périmetres Brhp
        foreach ($campagnesBrhp as $campagneBrhp) {
            $agents = $agentRepository->getAgentsByPerimetreBrhp($campagneBrhp->getPerimetreBrhp(), $campagneRlc->getCampagnePnc());

            /* @var $agent Agent */
            foreach ($agents as $agent) {
                $agent->setCampagneBrhp($campagneBrhp);
                $agent->setPerimetreBrhp($campagneBrhp->getPerimetreBrhp());
            }
        }

        //SME- new --> créer nouvelle fonction dans AppMailer afin de n'avertir les bhrps que sur el perimètre ajouté
        $this->mailer->notifierAjoutPerimetresBrhp($campagneRlc, $perimetresBrhp);
    }

    public function getHistoriqueIndicateurs(CampagneRlc $campagneRlc)
    {
        return $this->em->getRepository("AppBundle:Statistiques\StatCampagneRlc")->getHistoriqueIndicateurs($campagneRlc);
    }
    
    public function exporterPopulation(CampagneRlc $campagneRlc)
    {
    	$streamedResponse = new StreamedResponse(function() use($campagneRlc)
    	{
    		/* @var $agentRepository AgentRepository */
    		$agentRepository = $this->em->getRepository(Agent::class);
    		
    		$donneesAgents = $agentRepository->exportDonneesAgents($campagneRlc);
    		
    		$handle = fopen('php://output', 'r+');
    		
    		// UTF-8 BOM pour qu'il soit correctement lisible par Excel
    		fputs($handle, "\xEF\xBB\xBF");
    		
    		// Nom des colonnes du CSV
    		fputcsv($handle, array('Agent', 'Périmètre BRHP', 'N+1', 'N+2', 'Affectation', 'Evaluable', 'Statut', 'Avancement du CREP'), ';');
    		
    				
    		foreach ($donneesAgents as $donneesAgent){
    			fputcsv($handle, [
    					Util::identiteAgent($donneesAgent['civilite'], $donneesAgent['titre'], $donneesAgent['prenom'], $donneesAgent['nom'], $donneesAgent['email']),
    					$donneesAgent['perimetreBrhp_libelle'],
    					Util::identiteAgent($donneesAgent['shd_civilite'], $donneesAgent['shd_titre'], $donneesAgent['shd_prenom'], $donneesAgent['shd_nom'], $donneesAgent['shd_email']),
    					Util::identiteAgent($donneesAgent['ah_civilite'], $donneesAgent['ah_titre'], $donneesAgent['ah_prenom'], $donneesAgent['ah_nom'], $donneesAgent['ah_email']),
    					$donneesAgent['affectation'],
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
