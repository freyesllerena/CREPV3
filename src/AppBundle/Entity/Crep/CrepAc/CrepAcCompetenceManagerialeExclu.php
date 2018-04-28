<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepAcCompetenceManagerialeExclu.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcCompetenceManagerialeExcluRepository")
 */
class CrepAcCompetenceManagerialeExclu extends CrepAcCompetenceManageriale
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="competencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepAc;

    public function __construct($libelle)
    {
        $this->libelle = $libelle;
    }

    public function getCrepAc()
    {
        return $this->crepAc;
    }

    public function setCrepAc($crepAc)
    {
        $this->crepAc = $crepAc;

        return $this;
    }
}
