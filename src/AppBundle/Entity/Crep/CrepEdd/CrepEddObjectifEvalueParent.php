<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Objectif;

/**
 * CrepEddObjectifEvalueParent.
 *
 * @ORM\Table(name="crep_edd_objectif_evalue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifEvalueParentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepEddObjectifEvalueParent extends Objectif
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
     * @return ObjectifEvalueParent
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
