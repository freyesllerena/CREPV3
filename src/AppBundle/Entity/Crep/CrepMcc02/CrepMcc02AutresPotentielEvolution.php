<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02AutresPotentielEvolution
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02AutresPotentielEvolutionRepository")
 */
class CrepMcc02AutresPotentielEvolution extends Competence
{

    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="autresPotentielsEvolutions")
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
     * @param CrepMcc02|null $crep
     * @return $this
     */
    public function setCrep(CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
