<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\ObjectifEvalueParent;
use Doctrine\ORM\Mapping as ORM;


/**
 * CrepMcc02AutreObjectif
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02AutreObjectifRepository")
 */
class CrepMcc02AutreObjectif extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="autresObjectifs")
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
