<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMso5FormationAutre.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5FormationAutreRepository")
 */
class CrepMso5FormationAutre extends CrepMso5Formation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="formationsAutres")
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
