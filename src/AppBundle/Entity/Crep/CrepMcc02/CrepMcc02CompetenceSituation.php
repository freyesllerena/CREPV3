<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02CompetenceSituation
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02CompetenceSituationRepository\CrepMcc02Repository")
 */
class CrepMcc02CompetenceSituation extends Competence
{
  
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="competencesSituations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;
    
    /**
     * Get crep
     *
     * @return CrepMcc02
     */
    public function getCrep()
    {
    	return $this->crep;
    }
  
    /**
     * Set crep
     *
     * @param CrepMcc02 $crep
     *
     * @return CrepMcc02CompetenceSituation
     */
    public function setCrep(CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
