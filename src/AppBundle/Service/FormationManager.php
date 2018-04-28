<?php

namespace AppBundle\Service;

use AppBundle\Entity\Formation;
use AppBundle\Repository\FormationRepository;

class FormationManager extends BaseManager
{
    public function creer(Formation $uo)
    {
        $this->em->persist($uo);
        $this->em->flush();
    }

    public function sauvegarder(Formation $uo)
    {
        $this->em->flush();
    }

    public function supprimerReferentiel($ministere)
    {
        /* @var $formationRepository FormationRepository */
        $formationRepository = $this->em->getRepository('AppBundle:Formation');
        $formationRepository->supprimerReferentielFormation($ministere);
        $this->em->flush();
    }
}
