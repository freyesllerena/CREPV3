<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02CompetenceRequise
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02CompetenceRequiseRepository")
 */
class CrepMcc02CompetenceRequise extends Competence
{
  
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="competencesRequises")
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
     * @return CrepMcc02CompetenceRequise
     */
    public function setCrep(CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
