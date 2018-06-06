<?php

namespace AppBundle\Service;

use AppBundle\Entity\Formation;
use AppBundle\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;

class FormationManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

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
