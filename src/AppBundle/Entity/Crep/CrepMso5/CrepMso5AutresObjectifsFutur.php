<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMso5AutresObjectifsFutur.
 *
 * @ORM\Table(name="crep_mso5_autres_objectifs_futur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5AutresObjectifsFuturfRepository")
 */
class CrepMso5AutresObjectifsFutur extends CrepMso5ObjectifFuturParent
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="autresObjectifsFuturs")
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
