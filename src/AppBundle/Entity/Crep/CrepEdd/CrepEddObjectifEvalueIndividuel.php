<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueParent;

/**
 * CrepEddObjectifEvalueIndividuel
 *
 * @ORM\Table(name="crep_edd_objectif_eval_indiv")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifEvalueIndividuelfRepository")
 */
class CrepEddObjectifEvalueIndividuel extends CrepEddObjectifEvalueParent
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="objectifsEvaluesIndividuels")
	 */
	protected $crep;
	
	
	public function getCrep() {
		return $this->crep;
	}
	public function setCrep($crep) {
		$this->crep = $crep;
		return $this;
	}
	
    
}
