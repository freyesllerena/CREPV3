<?php

namespace AppBundle\Entity\Crep\CrepMso3;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceAgent.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso3Repository\CrepMso3FormationT1Repository")
 */
class CrepMso3FormationT1 extends CrepMso3Formation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso3", inversedBy="formationsT1")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep
     *
     * @return CrepMso3Formation
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepMso3\CrepMso3
     */
    public function getCrep()
    {
        return $this->crep;
    }
}
