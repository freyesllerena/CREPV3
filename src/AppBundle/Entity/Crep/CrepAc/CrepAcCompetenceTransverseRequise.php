<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepAcCompetenceTransverseRequise.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcCompetenceTransverseRequiseRepository")
 */
class CrepAcCompetenceTransverseRequise extends CrepAcCompetenceTransverse
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="competencesTransversesRequises")
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
