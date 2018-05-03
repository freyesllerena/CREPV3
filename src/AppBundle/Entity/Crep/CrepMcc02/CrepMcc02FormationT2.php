<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceAgent.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT2Repository")
 */
class CrepMcc02FormationT2 extends CrepMcc02Formation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="formationsT2")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMcc02\CrepMcc02 $crep
     *
     * @return CrepMcc02Formation
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