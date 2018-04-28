<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ObjectifEvalueParent;

/**
 * ObjectifEvalueIndividuel.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifEvalueIndividuelfRepository")
 */
class ObjectifEvalueIndividuel extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="objectifsEvaluesIndividuels")
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
