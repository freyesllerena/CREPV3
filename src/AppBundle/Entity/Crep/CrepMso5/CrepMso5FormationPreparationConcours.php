<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMso5FormationPreparationConcours.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5FormationPreparationConcoursRepository")
 */
class CrepMso5FormationPreparationConcours extends CrepMso5Formation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="formationsPreparationConcours")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5 $crep
     *
     * @return CrepMso5Formation
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
