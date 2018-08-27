<?php

namespace AppBundle\Entity\Crep\CrepDgac;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Crep;

/**
 * CrepDgacCompetenceManageriale.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository\CrepDgacCompetenceManagerialeRepository")
 */
class CrepDgacCompetenceManageriale extends Competence
{
	/**
	 * @var text
	 *
	 * @ORM\Column(type="text")
	 *
	 * @Assert\NotBlank(message="Le libellé est obligatoire")
	 *
	 * @Assert\Length(
	 *      max = 4096,
	 *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
	 * )
	 */
	protected $libelle;
	
    /**
     * @ORM\ManyToOne(targetEntity="CrepDgac", inversedBy="competencesManageriales")
     */
    protected $crep;
	
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauRequis;
    
    
    public function __construct($libelle)
    {
    	$this->libelle = $libelle;
    }
    
   	/**
	 * Set crep.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgac $crep
	 *
	 * @return CompetenceManageriale
	 */
	public function setCrep(\AppBundle\Entity\Crep\CrepDgac\CrepDgac $crep = null)
	{
		$this->crep = $crep;
	
		return $this;
	}
	
	public function getCrep()
	{
		return $this->crep;
	}
    
    /**
     * Set niveauRequis.
     *
     * @param int $niveauRequis
     *
     * @return Competence
     */
    public function setNiveauRequis($niveauRequis)
    {
    	$this->niveauRequis = $niveauRequis;
    
    	return $this;
    }
    
    /**
     * Get niveauRequis.
     *
     * @return int
     */
    public function getNiveauRequis()
    {
    	return $this->niveauRequis;
    }
    
}
