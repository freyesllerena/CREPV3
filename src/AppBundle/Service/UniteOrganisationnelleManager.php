<?php

namespace AppBundle\Service;

use AppBundle\Entity\UniteOrganisationnelle;
use AppBundle\Repository\UniteOrganisationnelleRepository;

class UniteOrganisationnelleManager extends BaseManager
{
    public function creer(UniteOrganisationnelle $uo)
    {
        /* @var $uoExistante UniteOrganisationnelle */
        $uoExistante = $this->em->getRepository('AppBundle:UniteOrganisationnelle')->getUniteOrganisationnelle($uo->getMinistere(), $uo->getCode());

        // Si l'uo existe, on la met à jour
        if ($uoExistante) {
            $uoExistante->setLibelle($uo->getLibelle());
            $uoExistante->setSupprime(false);
        } else {
            $this->em->persist($uo);
        }

        $this->em->flush();
    }

    public function sauvegarder(UniteOrganisationnelle $uo)
    {
        $this->em->flush();
    }

    public function supprimerReferentiel($ministere)
    {
        /* @var $uniteOrganisationnelleRepository UniteOrganisationnelleRepository */
        $uniteOrganisationnelleRepository = $this->em->getRepository('AppBundle:UniteOrganisationnelle');
        $uniteOrganisationnelleRepository->supprimerReferentiel($ministere);
        $this->em->flush();
    }
}
