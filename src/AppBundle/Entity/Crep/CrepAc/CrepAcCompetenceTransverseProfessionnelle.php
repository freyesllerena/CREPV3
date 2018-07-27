<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepAcCompetenceTransverseProfessionnelle.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcCompetenceTransverseProfessionnelleRepository")
 */
class CrepAcCompetenceTransverseProfessionnelle extends CrepAcCompetenceTransverse
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="competencesTransversesProfessionnelles")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepAc;

    public function __construct($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * Set crepAc.
     *
     * @param CrepAc $crepAc
     */
    public function setCrepAc(CrepAc $crepAc = null)
    {
        $this->crepAc = $crepAc;

        return $this;
    }

    /**
     * Get crepAc.
     *
     * @return CrepAc
     */
    public function getCrepAc()
    {
        return $this->crepAc;
    }
}
