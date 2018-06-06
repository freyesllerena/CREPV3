<?php

namespace AppBundle\Service;

use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Doctrine\Common\Collections\Collection;
use AppBundle\Entity\Campagne;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\CampagneBrhp;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;

class CampagnePncManager extends CampagneManager
{
    /* @var $campagneRlcManager CampagneRlcManager */
    protected $campagneRlcManager;

    protected $tokenStorage;

    protected $em;

    /* @var $repository CampagnePncRepository */
    protected $repository;

    public function __construct(
        PersonneManager $personneManager,
        CampagneRlcManager $campagneRlcManager,
        TokenStorageInterface $tokenStorage,
        AppMailer $mailer,
        EngineInterface $templating,
        EntityManagerInterface $entityManager
    ) {
        $this->personneManager = $personneManager;
        $this->campagneRlcManager = $campagneRlcManager;
        $this->tokenStorage = $tokenStorage;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('AppBundle:CampagnePnc');
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
        $this->em->persist($campagnePnc);
        $this->em->flush();

        $perimetresRlc = $campagnePnc->getPerimetresRlc();

        $rlcs = $this->personneManager->getRlcs($perimetresRlc);

        $this->personneManager->ajoutePersonnesDansUtilisateurs($rlcs, 'ROLE_RLC');

        $this->campagneRlcManager->creer($campagnePnc);

        $this->em->persist($campagnePnc);
        $this->em->flush();

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
        $this->em->persist($campagnePnc);
        $this->em->flush();

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

        $this->em->persist($campagnePnc);
        $this->em->flush();
        
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

        $this->em->persist($campagnePnc);
        $this->em->flush();
        
        $this->mailer->notifierRouvrirCampagne($campagnePnc);
    }

    public function fermer(CampagnePnc $campagnePnc)
    {
        $campagnePnc->setStatut(EnumStatutCampagne::FERMEE);
        $campagnePnc->setDateFermeture(new \DateTime());

        // faire un flush ici, pour que l'information soit récupérée rapidement si cette fonction est appellée via une commande asynchrone
        $this->em->persist($campagnePnc);
        $this->em->flush();

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

        $this->em->persist($campagnePnc);
        $this->em->flush();
        
        $this->mailer->notifierFermerCampagnePnc($campagnePnc);
    }

    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
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
