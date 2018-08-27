<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ObjectifEvalueParent;

/**
 * CrepMso5AutresObjectifsEvalue.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5AutresObjectifsEvalueRepository")
 */
class CrepMso5AutresObjectifsEvalue extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="autresObjectifsEvalues")
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
