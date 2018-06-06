<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ministere;
use AppBundle\Entity\PerimetreBrhp;
use Doctrine\ORM\EntityManagerInterface;

class PerimetreBrhpManager
{
    protected $agentManager;

    protected $em;

    public function __construct(AgentManager $agentManager, EntityManagerInterface $entityManager)
    {
        $this->agentManager = $agentManager;
        $this->em = $entityManager;
    }

    /**
     * Permet de récumétre les périmètre d'un ministère.
     *
     * @param Ministere $ministere
     */
    public function save(PerimetreBrhp $perimetreBrhp, $anciennesUos = [])
    {
        $nouvellesUos = $perimetreBrhp->getUnitesOrganisationnelles()->toArray();

        $uoEnPlus = array_diff($nouvellesUos, $anciennesUos);

        $uoEnMoins = array_diff($anciennesUos, $nouvellesUos);

        $this->agentManager->detacherAgentsDunBrhp($uoEnMoins);
        $this->agentManager->rattacherAgentsAUnBrhp($uoEnPlus);

        $this->em->persist($perimetreBrhp);
        $this->em->flush();
    }
}
