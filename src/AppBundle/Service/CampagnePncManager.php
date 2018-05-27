<?php

namespace AppBundle\Service;

use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\Campagne;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\CampagneBrhp;

class CampagnePncManager extends CampagneManager
{
    /* @var $repository CampagnePncRepository */
    protected $repository;

    /* @var $campagneRlcManager CampagneRlcManager */
    protected $campagneRlcManager;

    public function init(
        PersonneManager $personneManager,
        CampagneRlcManager $campagneRlcManager,
        TokenStorage $jetonRegistre,
        AppMailer $mailer,
        TwigEngine $templating
    ) {
        $this->repository = $this->em->getRepository('AppBundle:CampagnePnc');
        $this->personneManager = $personneManager;
        $this->campagneRlcManager = $campagneRlcManager;
        $this->jetonRegistre = $jetonRegistre;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Ouvre la campagne Pnc.
     *
     * @param CampagnePnc $campagnePnc
     */
    public function ouvrir(CampagnePnc $campagnePnc)
    {
        $campagnePnc->setStatut(EnumStatutCampagne::OUVERTE);
        $campagnePnc->setDateOuverture(new \DateTime());
        $campagnePnc->setOuvertePar($this->getUser());

        // faire un flush ici, pour que l'information soit récupérée rapidement si cette fonction est appellée via une commande asynchrone
        $this->sauvegarder($campagnePnc);

        $perimetresRlc = $campagnePnc->getPerimetresRlc();

        $rlcs = $this->personneManager->getRlcs($perimetresRlc);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($rlcs, 'ROLE_RLC');

        $this->campagneRlcManager->creer($campagnePnc);

        $this->sauvegarder($campagnePnc);

        $this->mailer->notifierOuvrirCampagnePnc($campagnePnc);
    }

    /**
     * Ouvre un nouveau périmètre.
     *
     * @param CampagnePnc $campagnePnc
     * @param Collection  $perimetresRlc
     */
    public function ouvrirNouveauxPerimetres(CampagnePnc $campagnePnc, Collection $perimetresRlc)
    {
        $rlcs = $this->personneManager->getRlcs($perimetresRlc);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($rlcs, 'ROLE_RLC');

        $this->campagneRlcManager->creer($campagnePnc, $perimetresRlc->toArray());

        // le pnc notifie par mail les rlcs de l'ouverture de la campagne - old à supprimer
        // 		$this->mailer->notifierOuvrirCampagnePnc($campagnePnc, $rlcs);

        //SME- new --> créer nouvelle fonction dans AppMailer afin de n'avertir les bhrps que sur el perimètre ajouté
        $this->mailer->notifierAjoutPerimetresRlc($campagnePnc, $perimetresRlc);
    }

    public function cloturer(CampagnePnc $campagnePnc)
    {
        $campagnePnc->setStatut(EnumStatutCampagne::CLOTUREE);
        $campagnePnc->setDateCloture(new \DateTime());

        //Mise à jour du statut de la campagne pour l'affiche au niveau IHM soit correct
        $this->sauvegarder($campagnePnc);

        // Récupérer toutes les campagnes rlc de la campagne pnc pour les clôturer
        $campagnesRlc = $this->em->getRepository('AppBundle:CampagneRlc')->findByCampagnePnc($campagnePnc);

        // Pour chaque campagne Rlc, on récupère les campagnes BRHP, pour les clôturer aussi
        /* @var $campagneRlc CampagneRlc */
        foreach ($campagnesRlc as $campagneRlc) {
            // Clôturer campagne Rlc
            $campagneRlc->setStatut(EnumStatutCampagne::CLOTUREE);

            $campagnesBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->findByCampagneRlc($campagneRlc);

            /* @var $campagneBrhp CampagneBrhp */
            foreach ($campagnesBrhp as $campagneBrhp) {
                // Clôturer campagne BRHP
                $campagneBrhp->setStatut(EnumStatutCampagne::CLOTUREE);
            }
        }

        $this->sauvegarder($campagnePnc);
        $this->mailer->notifierCloturerCampagnePnc($campagnePnc);
    }

    /*
     * Rouvrir une campagne PNC, et notifier les rlcs
     */
    public function rouvrir(CampagnePnc $campagnePnc)
    {
        $campagnePnc->setStatut(EnumStatutCampagne::OUVERTE);
        $campagnePnc->setDateOuverture(new \DateTime());
        $campagnePnc->setOuvertePar($this->getUser());

        $this->sauvegarder($campagnePnc);
        $this->mailer->notifierRouvrirCampagne($campagnePnc);
    }

    public function fermer(CampagnePnc $campagnePnc)
    {
        $campagnePnc->setStatut(EnumStatutCampagne::FERMEE);
        $campagnePnc->setDateFermeture(new \DateTime());

        // faire un flush ici, pour que l'information soit récupérée rapidement si cette fonction est appellée via une commande asynchrone
        $this->sauvegarder($campagnePnc);

        // Récupérer toutes les campagnes rlc de la campagne pnc pour les fermer
        $campagnesRlc = $this->em->getRepository('AppBundle:CampagneRlc')->findByCampagnePnc($campagnePnc);

        // Pour chaque campagne Rlc, on récupère les campagnes BRHP, pour les fermer aussi
        /* @var $campagneRlc CampagneRlc */
        foreach ($campagnesRlc as $campagneRlc) {
            // Clôturer campagne Rlc
            $campagneRlc->setStatut(EnumStatutCampagne::FERMEE);

            $campagnesBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->findByCampagneRlc($campagneRlc);

            /* @var $campagneBrhp CampagneBrhp */
            foreach ($campagnesBrhp as $campagneBrhp) {
                // Clôturer campagne BRHP
                $campagneBrhp->setStatut(EnumStatutCampagne::FERMEE);
            }
        }

        $this->sauvegarder($campagnePnc);
        $this->mailer->notifierFermerCampagnePnc($campagnePnc);
    }

    protected function getUser()
    {
        return $this->jetonRegistre->getToken()->getUser();
    }

    public function diffuser(CampagnePnc $campagnePnc)
    {
        $campagnesBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->getCampagnesBrhpByCampagnePnc($campagnePnc);

        $campagnePnc->setDiffusee(true);

        /* @var $campagneBrhp CampagneBrhp */
        foreach ($campagnesBrhp as $campagneBrhp) {
            $campagneBrhp->setStatut(EnumStatutCampagne::CREEE);
        }

        $this->em->flush();

        $this->mailer->notifierDiffuserPopulation($campagnePnc);
    }

    public function getHistoriqueIndicateurs(CampagnePnc $campagnePnc)
    {
        return $this->em->getRepository("AppBundle:Statistiques\StatCampagnePnc")->getHistoriqueIndicateurs($campagnePnc);
    }
}
