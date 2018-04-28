<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ministere;
use AppBundle\Entity\PerimetreBrhp;

class PerimetreBrhpManager extends BaseManager
{
    protected $agentManager;

    public function init(AgentManager $agentManager)
    {
        $this->agentManager = $agentManager;
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
