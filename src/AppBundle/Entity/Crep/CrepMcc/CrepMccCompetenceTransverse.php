<?php

namespace AppBundle\Entity\Crep\CrepMcc;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMindefCompetenceTransverse.
 *
 * @ORM\Table(name="crep_mcc_comp_trans" , uniqueConstraints={
 * @ORM\UniqueConstraint(columns={"crep_mcc_id", "competence_transverse_id"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMccRepository\CrepMccCompetenceTransverseRepository")
 */
class CrepMccCompetenceTransverse extends GenericEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    protected $niveauAcquis;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompetenceTransverse")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $competenceTransverse;

    /**
     * Set niveauAcquis.
     *
     * @param int $niveauAcquis
     *
     * @return CrepMccCompetenceTransverse
     */
    public function setNiveauAcquis($niveauAcquis)
    {
        $this->niveauAcquis = $niveauAcquis;

        return $this;
    }

    /**
     * Get niveauAcquis.
     *
     * @return int
     */
    public function getNiveauAcquis()
    {
        return $this->niveauAcquis;
    }

    /**
     * Set competenceTransverse.
     *
     * @param \AppBundle\Entity\CompetenceTransverse $competenceTransverse
     *
     * @return CrepMccCompetenceTransverse
     */
    public function setCompetenceTransverse(\AppBundle\Entity\CompetenceTransverse $competenceTransverse = null)
    {
        $this->competenceTransverse = $competenceTransverse;

        return $this;
    }

    /**
     * Get competenceTransverse.
     *
     * @return \AppBundle\Entity\CompetenceTransverse
     */
    public function getCompetenceTransverse()
    {
        return $this->competenceTransverse;
    }
}
