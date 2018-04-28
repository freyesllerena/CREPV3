<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ObjectifEvalueParent;

/**
 * ObjectifEvalueCollectif.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifEvalueCollectifRepository")
 */
class ObjectifEvalueCollectif extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="objectifsEvaluesCollectifs")
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
