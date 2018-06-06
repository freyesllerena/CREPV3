<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ObjectifEvalueParent;

/**
 * CrepEddObjectifEvalueCollectif.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifEvalueCollectifRepository")
 */
class CrepEddObjectifEvalueCollectif extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="objectifsEvaluesCollectifs")
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
