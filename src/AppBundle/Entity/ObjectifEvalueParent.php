<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjectifEvalueParent.
 *
 * @ORM\Table(name="objectif_evalue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifEvalueParentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class ObjectifEvalueParent extends Objectif
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
