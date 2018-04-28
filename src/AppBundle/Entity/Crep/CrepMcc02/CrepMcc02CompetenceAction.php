<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;
use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02Competence;

/**
 * CrepMcc02CompetenceAction
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02CompetenceActionRepository")
 */
class CrepMcc02CompetenceAction extends CrepMcc02Competence
{
  
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="competencesActions")
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
     * @return CrepMcc02CompetenceAction
     */
    public function setCrep(CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
