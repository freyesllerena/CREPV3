<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\ContraintePoste;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * CrepEddContraintePoste
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddContraintePosteRepository")
 */
class CrepEddContraintePoste extends ContraintePoste
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="contraintesPostes")
     */
    protected $crep;
    
    /**
     * Set crep
     *      
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEdd $crep
     *
     * @return ContraintePoste
     */
    public function setCrep(CrepEdd $crep = null)
    {
        $this->crep = $crep;
    
        return $this;
    }
    
    /**
     * Get crep
     *
     * @return \AppBundle\Entity\Crep\CrepEdd\CrepEdd
     */
    public function getCrep()
    {
        return $this->crep;
    }
    
    public function __construct($libelle){
        
        $this->libelle = $libelle;
        
    }
 
}
