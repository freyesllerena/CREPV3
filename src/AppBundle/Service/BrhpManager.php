<?php

namespace AppBundle\Service;

use AppBundle\Entity\Brhp;
use AppBundle\Repository\CampagneBrhpRepository;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\PerimetreRlc;

class BrhpManager extends BaseManager
{
    protected $utilisateurManager;

    protected $personneManager;

    public function init(UtilisateurManager $utilisateurManager, PersonneManager $personneManager)
    {
        //call_user_func_array(array($this, 'parent::__construct'), func_get_args());
        $this->utilisateurManager = $utilisateurManager;
        $this->personneManager = $personneManager;
    }

    /**
     * Permet de supprimer un BRHP.
     *
     * @param BRHP $brhp
     */
    public function delete(Brhp $brhp, $perimetresRlc)
    {
        /* @var $perimetreRlc PerimetreRlc */
        foreach ($perimetresRlc as $perimetreRlc) {
            foreach ($perimetreRlc->getPerimetresBrhp() as $perimetreBrhp) {
                $brhp->removePerimetresBrhp($perimetreBrhp);
            }
        }

        if ($brhp->getPerimetresBrhp()->isEmpty()) {
            if ($brhp->getUtilisateur()) {
                $this->utilisateurManager->supprimerRole('ROLE_BRHP', $brhp->getUtilisateur());
            }

            $this->em->remove($brhp);
        }

        $this->em->flush();
    }

    /**
     * Ajoute le brhp dans la table Brhp, et créer l'utilisateur associé si besoin.
     *
     * @param Brhp $brhp
     */
    public function creerBrhp(Brhp $brhp)
    {
        /* @var $brhpRepository BrhpRepository */
        $brhpRepository = $this->em->getRepository('AppBundle:Brhp');
        /* @var $brhpExistant Brhp */
        $brhpExistant = $brhpRepository->findOneByUtilisateur($brhp->getUtilisateur());

        if ($brhpExistant) {
            foreach ($brhp->getPerimetresBrhp() as $perimetreBrhp) {
                if (!$brhpExistant->getPerimetresBrhp()->contains($perimetreBrhp)) {
                    $brhpExistant->addPerimetresBrhp($perimetreBrhp);
                }
            }
            $brhp = $brhpExistant;
        }

        /* @var $campagneBrhpRepository CampagneBrhpRepository */
        $campagneBrhpRepository = $this->em->getRepository('AppBundle:CampagneBrhp');
        $campagnesBrhp = $campagneBrhpRepository->getCampagnes($brhp);

        if ($campagnesBrhp) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs([$brhp], 'ROLE_BRHP');
        }

        $this->em->persist($brhp);
        $this->em->flush();
    }

    public function updateBrhp(Brhp $brhp, $anciensPerimetres, $perimetresRlc)
    {
        // Récupérer l'utilisateur associé au BRHP
        /* @var $utilisateur Utilisateur */
        $utilisateur = $brhp->getUtilisateur();

        // Mettre à jour l'utilisateur associé au BRHP s'il possède un compte
        if ($utilisateur) {
            $utilisateur->setCivilite($brhp->getCivilite())
                        ->setNom($brhp->getNom())
                        ->setPrenom($brhp->getPrenom());
        }

        $nouveauxPerimetres = $brhp->getPerimetresBrhp()->toArray();
        $perimetresAConserver = [];

        /* @var $ancienPerimetre PerimetreBrhp */
        foreach ($anciensPerimetres as $ancienPerimetre) {
            if (!in_array($ancienPerimetre->getPerimetreRlc(), $perimetresRlc->toArray())) {
                $perimetresAConserver[] = $ancienPerimetre;
            }
        }
        $perimetresAConserver = array_merge($perimetresAConserver, $nouveauxPerimetres);

        $brhp->getPerimetresBrhp()->clear();

        /* @var $perimetreAConserver PerimetreBrhp */
        foreach ($perimetresAConserver as $perimetreAConserver) {
            $brhp->addPerimetresBrhp($perimetreAConserver);
        }

        $this->em->flush();
    }

    /**
     * Récupérer les Brhps rattachés aux périmètres RLC passés en paramètre.
     *
     * @param array $perimetresRlc
     */
    public function getBrhps($perimetresRlc)
    {
        $brhps = array();
        $listeBrhpsSansDoublon = array();

        foreach ($perimetresRlc as $perimetreRlc) {
            $perimetresBrhp = $perimetreRlc->getPerimetresBrhp();

            foreach ($perimetresBrhp as $perimetreBrhp) {
                $brhps = array_merge($brhps, $perimetreBrhp->getBrhps()->toArray()); //listeBrhps avec doublons
            }
        }

        foreach ($brhps as $brhp) {
            if (!in_array($brhp, $listeBrhpsSansDoublon)) {
                array_push($listeBrhpsSansDoublon, $brhp);
            }
        }

        return $listeBrhpsSansDoublon;
    }
}
