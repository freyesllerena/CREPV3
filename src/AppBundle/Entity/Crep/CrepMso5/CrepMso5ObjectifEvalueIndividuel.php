<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMso5ObjectifEvalueIndividuel.
 *
 * @ORM\Table(name="crep_mso5_objectif_eval_indiv")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5ObjectifEvalueIndividuelRepository")
 */
class CrepMso5ObjectifEvalueIndividuel extends CrepMso5ObjectifEvalueParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="objectifsEvaluesIndividuels")
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
