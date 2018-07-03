<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 02/07/2018
 * Time: 15:27
 */

namespace AppBundle\Entity\Crep\CrepMj02;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ObjectifEvalueParent;

/**
 * Class CrepMj02ObjectifEvalueGlobal
 * @package AppBundle\Entity\Crep\CrepMj02
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository\CrepMj02ObjectifEvalueGlobalRepository")
 */
class CrepMj02ObjectifEvalueGlobal extends ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj02", inversedBy="objectifsEvaluesGlobaux")
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
