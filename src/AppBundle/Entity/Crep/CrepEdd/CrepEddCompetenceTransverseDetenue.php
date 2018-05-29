<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepEddCompetenceTransverseDetenue
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddCompetenceTransverseDetenueRepository")
 */
class CrepEddCompetenceTransverseDetenue extends Competence
{
	/**
	 * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="competencesTransversesDetenues")
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $crep;
	
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if($this->libelle !== null && $this->niveauAcquis === null){
            $context->buildViolation("Le niveau de la compétence est obligatoire")
            ->atPath('libelle')
            ->addViolation();
        }
    }
    
	public function getCrep() {
		return $this->crep;
	}
	public function setCrep($crep) {
		$this->crep = $crep;
		return $this;
	}
	
}
