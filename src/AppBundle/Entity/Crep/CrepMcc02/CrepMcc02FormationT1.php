<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class CrepMcc02FormationT1
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationT1Repository")
 * @package AppBundle\Entity\Crep\CrepMcc02
 */
class CrepMcc02FormationT1 extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="formationsT1")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMcc02\CrepMcc02 $crep
     *
     * @return DemandeFormation
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
