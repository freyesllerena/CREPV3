<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjectifFutur.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifAVenirRepository")
 */
class ObjectifFutur extends ObjectifFuturParent
{
    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="objectifsFuturs")
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
