<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\FormationFuture;
use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceAgent.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT2Repository")
 */
class CrepMcc02FormationT2 extends FormationFuture
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
