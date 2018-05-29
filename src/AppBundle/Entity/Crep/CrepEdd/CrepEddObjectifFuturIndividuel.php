<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CrepEddObjectifFuturIndividuel
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifFuturIndividuelRepositery")
 */
class CrepEddObjectifFuturIndividuel extends CrepEddObjectifFuturParent
{
    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $indicateurs;
    
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="objectifsFutursIndividuels")
     */
    protected $crep;
    
    /**
     *
     * @return the text
     */
    public function getIndicateurs()
    {
        return $this->indicateurs;
    }
    
    /**
     *
     * @param
     *            $indicateurs
     */
    public function setIndicateurs($indicateurs)
    {
        $this->indicateurs = $indicateurs;
        return $this;
    }
	public function getCrep() {
		return $this->crep;
	}
	public function setCrep($crep) {
		$this->crep = $crep;
		return $this;
	}
	
    
    
}
