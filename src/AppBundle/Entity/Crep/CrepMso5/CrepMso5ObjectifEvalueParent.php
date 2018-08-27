<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Objectif;

/**
 * CrepMso5ObjectifEvalueParent.
 *
 * @ORM\Table(name="crep_mso5_objectif_evalue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5ObjectifEvalueParentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMso5ObjectifEvalueParent extends Objectif
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $resultatObtenu;

    /**
     * Set resultatObtenu.
     *
     * @param int $resultatObtenu
     *
     * @return CrepMso5ObjectifEvalueParent
     */
    public function setResultatObtenu($resultatObtenu)
    {
        $this->resultatObtenu = $resultatObtenu;

        return $this;
    }

    /**
     * Get resultatObtenu.
     *
     * @return int
     */
    public function getResultatObtenu()
    {
        return $this->resultatObtenu;
    }
}
