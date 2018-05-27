<?php

namespace AppBundle\Service;

use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\CampagneRlc;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\Campagne;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\Agent;
use AppBundle\Entity\CampagneBrhp;
use Doctrine\Common\Collections\ArrayCollection;

class CampagneRlcManager extends CampagneManager
{
    /* @var $repository CampagneRlcRepository */
    protected $repository;

    /* @var $campagneBrhpManager CampagneBrhpManager */
    protected $campagneBrhpManager;

    public function init(
        PersonneManager $personneManager,
        CampagneBrhpManager $campagneBrhpManager,
        TokenStorage $jetonRegistre,
        AppMailer $mailer,
        TwigEngine $templating
    ) {
        $this->repository = $this->em->getRepository('AppBundle:CampagneRlc');
        $this->personneManager = $personneManager;
        $this->campagneBrhpManager = $campagneBrhpManager;
        $this->jetonRegistre = $jetonRegistre;
        $this->mailer = $mailer;
        $this->templating = $templating;
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

        $this->sauvegarder($campagneRlc);
        $this->mailer->notifierRouvrirCampagne($campagneRlc);
    }

    protected function getUser()
    {
        return $this->jetonRegistre->getToken()->getUser();
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
}
