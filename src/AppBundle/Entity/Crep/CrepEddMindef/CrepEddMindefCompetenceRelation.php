<?php

namespace AppBundle\Entity\Crep\CrepEddMindef;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;

/**
 * CrepEddMindefCompetenceRelation
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddMindefRepository\CrepEddMindefCompetenceRelationRepository")
 */
class CrepEddMindefCompetenceRelation extends Competence
{

    /**
     * @ORM\ManyToOne(targetEntity="CrepEddMindef", inversedBy="competencesRelations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;


    /**
     * Get crep
     *
     * @return CrepEddMindef
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set crep
     *
     * @param CrepEddMindef $crep
     *
     * @return CrepEddMindefCompetenceRelation
     */
    public function setCrep(CrepEddMindef $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
