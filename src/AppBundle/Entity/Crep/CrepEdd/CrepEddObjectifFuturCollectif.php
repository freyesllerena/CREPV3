<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CrepEddObjectifFuturCollectif
 *
 * @ORM\Table(name="crep_edd_objectif_futur_coll")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifFuturCollectifRepositery")
 */
class CrepEddObjectifFuturCollectif extends CrepEddObjectifFuturParent
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
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="objectifsFutursCollectifs")
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
