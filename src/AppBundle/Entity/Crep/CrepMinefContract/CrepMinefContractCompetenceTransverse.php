<?php

namespace AppBundle\Entity\Crep\CrepMinefContract;

use AppBundle\Entity\GenericEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMinefContractCompetenceTransverse.
 *
 * @ORM\Table(name="crep_minef_cont_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_id", "competence_transverse_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMinefContractCompetenceTransverseRepository")
 */
class CrepMinefContractCompetenceTransverse extends GenericEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    private $niveauAcquis;

    /**
     * @ORM\ManyToOne(targetEntity="CrepMinefContract", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

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
     * @return CrepMinefContractCompetenceTransverse
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
     * Set crep.
     *
     * @param \AppBundle\Entity\CrepMinefContract $crep
     *
     * @return CrepMinefContractCompetenceTransverse
     */
    public function setCrepMinefContract(CrepMinefContract $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\CrepMinefContract
     */
    public function getCrepMinefContract()
    {
        return $this->crepMinefContract;
    }

    /**
     * Set competenceTransverse.
     *
     * @param \AppBundle\Entity\CompetenceTransverse $competenceTransverse
     *
     * @return CrepMinefContractCompetenceTransverse
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
