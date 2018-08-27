<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class CrepMso5FormationT1
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5FormationT1Repository")
 * @package AppBundle\Entity\Crep\CrepMso5
 */
class CrepMso5FormationT1 extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="formationsT1")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5 $crep
     *
     * @return DemandeFormation
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMso5\CrepMso5 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepMso5\CrepMso5
     */
    public function getCrep()
    {
        return $this->crep;
    }
}
