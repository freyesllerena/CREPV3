<?php

namespace AppBundle\Entity\Crep\CrepEddMindef;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;

/**
 * CrepEddMindefCompetenceRequise
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddMindefRepository\CrepEddMindefCompetenceRequiseRepository")
 */
class CrepEddMindefCompetenceRequise extends Competence
{
  
    /**
     * @ORM\ManyToOne(targetEntity="CrepEddMindef", inversedBy="competencesRequises")
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
     * @return CrepEddMindefCompetenceRequise
     */
    public function setCrep(CrepEddMindef $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
