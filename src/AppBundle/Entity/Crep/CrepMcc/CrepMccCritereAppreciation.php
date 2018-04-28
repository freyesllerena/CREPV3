<?php

namespace AppBundle\Entity\Crep\CrepMcc;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMccCritereAppreciation.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMccRepository\CrepMccCritereAppreciationRepository")
 */
class CrepMccCritereAppreciation extends CrepMccCompetenceTransverse
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc", inversedBy="criteresAppreciations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMcc;

    /**
     * Set crepMcc.
     *
     * @param \AppBundle\Entity\CrepMcc $crepMcc
     *
     * @return CrepMccCompetenceTransverse
     */
    public function setCrepMcc(CrepMcc $crepMcc = null)
    {
        $this->crepMcc = $crepMcc;

        return $this;
    }

    /**
     * Get crepMcc.
     *
     * @return \AppBundle\Entity\Mcc
     */
    public function getCrepMcc()
    {
        return $this->crepMcc;
    }
}
