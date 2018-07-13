<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceAgent.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT3Repository")
 */
class CrepMcc02FormationT3 extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="formationsT3")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param CrepMcc02|null $crep
     *
     * @return $this
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMcc02\CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepMcc02\CrepMcc02
     */
    public function getCrep()
    {
        return $this->crep;
    }
}
