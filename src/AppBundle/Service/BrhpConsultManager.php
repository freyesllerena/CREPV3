<?php

namespace AppBundle\Service;

use AppBundle\Entity\Brhp;
use AppBundle\Repository\CampagneBrhpRepository;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\BrhpConsult;
use Doctrine\ORM\EntityManagerInterface;

class BrhpConsultManager
{
    protected $utilisateurManager;

    protected $personneManager;
    
    protected $em;

    public function __construct(UtilisateurManager $utilisateurManager, PersonneManager $personneManager, EntityManagerInterface $entityManager)
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->personneManager = $personneManager;
        $this->em = $entityManager;
    }

    /**
     * Permet de supprimer un BRHP Consult.
     *
     * @param BRHPConsult $brhpConsult
     */
    public function delete(BrhpConsult $brhpConsult, $perimetresRlc)
    {
        /* @var $perimetreRlc PerimetreRlc */
        foreach ($perimetresRlc as $perimetreRlc) {
            foreach ($perimetreRlc->getPerimetresBrhp() as $perimetreBrhp) {
                $brhpConsult->removePerimetresBrhp($perimetreBrhp);
            }
        }

        if ($brhpConsult->getPerimetresBrhp()->isEmpty()) {
            if ($brhpConsult->getUtilisateur()) {
                $this->utilisateurManager->supprimerRole('ROLE_BRHP_CONSULT', $brhpConsult->getUtilisateur());
            }

            $this->em->remove($brhpConsult);
        }

        $this->em->flush();
    }

    /**
     * Ajoute le brhpConsult dans la table BrhpConsult, et créer l'utilisateur associé si besoin.
     *
     * @param BrhpConsult $brhpConsult
     */
    public function creerBrhpConsult(BrhpConsult $brhpConsult)
    {
        /* @var $brhpConsultRepository BrhpConsultRepository */
        $brhpConsultRepository = $this->em->getRepository('AppBundle:BrhpConsult');
        /* @var $brhpExistant BrhpConsult */
        $brhpConsultExistant = null;

        if ($brhpConsult->getUtilisateur()) {
            $brhpConsultExistant = $brhpConsultRepository->findOneByUtilisateur($brhpConsult->getUtilisateur());
        }

        // Si le BRHP Consultant existe déjà, c'est à dire qu'il a été ajouté par un autre RLC
        // alors on lui ajoute les nouveaux périmètres aux périmètres qu'il gère déjà
        if ($brhpConsultExistant) {
            foreach ($brhpConsult->getPerimetresBrhp() as $perimetreBrhp) {
                if (!$brhpConsultExistant->getPerimetresBrhp()->contains($perimetreBrhp)) {
                    $brhpConsultExistant->addPerimetresBrhp($perimetreBrhp);
                }
            }
            $brhpConsult = $brhpConsultExistant;
        }

        /* @var $campagneBrhpRepository CampagneBrhpRepository */
        $campagneBrhpRepository = $this->em->getRepository('AppBundle:CampagneBrhp');
        $campagnesBrhp = $campagneBrhpRepository->getCampagnes($brhpConsult);

        if ($campagnesBrhp) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs([$brhpConsult], 'ROLE_BRHP_CONSULT');
        }

        $this->em->persist($brhpConsult);
        $this->em->flush();
    }

    public function updateBrhpConsult(BrhpConsult $brhpConsult, $anciensPerimetres, $perimetresRlc)
    {
        // Récupérer l'utilisateur associé au BRHP Consult
        /* @var $utilisateur Utilisateur */
        $utilisateur = $brhpConsult->getUtilisateur();

        // Mettre à jour l'utilisateur associé au BRHP Consult s'il possède un compte
        if ($utilisateur) {
            $utilisateur->setCivilite($brhpConsult->getCivilite())
                        ->setNom($brhpConsult->getNom())
                        ->setPrenom($brhpConsult->getPrenom())
            			->setTitre($brhpConsult->getTitre());
        }

        $nouveauxPerimetres = $brhpConsult->getPerimetresBrhp()->toArray();
        $perimetresAConserver = [];

        /* @var $ancienPerimetre PerimetreBrhp */
        foreach ($anciensPerimetres as $ancienPerimetre) {
            if (!in_array($ancienPerimetre->getPerimetreRlc(), $perimetresRlc->toArray())) {
                $perimetresAConserver[] = $ancienPerimetre;
            }
        }
        $perimetresAConserver = array_merge($perimetresAConserver, $nouveauxPerimetres);

        $brhpConsult->getPerimetresBrhp()->clear();

        /* @var $perimetreAConserver PerimetreBrhp */
        foreach ($perimetresAConserver as $perimetreAConserver) {
            $brhpConsult->addPerimetresBrhp($perimetreAConserver);
        }

        $this->em->flush();
    }

    /**
     * Récupérer les Brhps consultation rattachés aux périmètres RLC passés en paramètre.
     *
     * @param array $perimetresRlc
     */
    public function getBrhpsConsult($perimetresRlc)
    {
        $brhpsConsult = array();
        $listeBrhpsConsultSansDoublon = array();

        foreach ($perimetresRlc as $perimetreRlc) {
            $perimetresBrhp = $perimetreRlc->getPerimetresBrhp();

            /* @var $perimetreBrhp PerimetreBrhp */
            foreach ($perimetresBrhp as $perimetreBrhp) {
                $brhpsConsult = array_merge($brhpsConsult, $perimetreBrhp->getBrhpsConsult()->toArray()); //listeBrhpsConsult avec doublons
            }
        }

        foreach ($brhpsConsult as $brhpConsult) {
            if (!in_array($brhpConsult, $listeBrhpsConsultSansDoublon)) {
                array_push($listeBrhpsConsultSansDoublon, $brhpConsult);
            }
        }

        return $listeBrhpsConsultSansDoublon;
    }
}
