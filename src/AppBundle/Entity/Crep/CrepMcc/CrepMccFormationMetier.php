<?php

namespace AppBundle\Entity\Crep\CrepMcc;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationAVenir.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMccRepository\CrepMccFormationMetierRepository")
 */
class CrepMccFormationMetier extends CrepMccFormationAVenir
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc", inversedBy="formationsEvolutionMetiers")
     */
    protected $crep;

    public function getCrep()
    {
        return $this->crep;
    }

    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }
}
