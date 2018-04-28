<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjectifEvalue.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifEvalueRepository")
 */
class ObjectifEvalue extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="objectifsEvalues")
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
