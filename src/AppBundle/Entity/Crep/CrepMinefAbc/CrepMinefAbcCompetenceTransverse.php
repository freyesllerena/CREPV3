<?php

namespace AppBundle\Entity\Crep\CrepMinefAbc;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMinefAbcCompetenceTransverse.
 *
 * @ORM\Table(name="crep_minefAbc_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_minef_abc_id", "competence_transverse_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMinefAbcCompetenceTransverseRepository")
 */
class CrepMinefAbcCompetenceTransverse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    private $niveauAcquis;

    /**
     * @ORM\ManyToOne(targetEntity="CrepMinefAbc", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMinefAbc;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompetenceTransverse")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $competenceTransverse;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set niveauAcquis.
     *
     * @param int $niveauAcquis
     *
     * @return CrepMinefAbcCompetenceTransverse
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
     * Set crepMinefAbc.
     *
     * @param \AppBundle\Entity\CrepMinefAbc $crepMinefAbc
     *
     * @return CrepMinefAbcCompetenceTransverse
     */
    public function setCrepMinefAbc(CrepMinefAbc $crepMinefAbc = null)
    {
        $this->crepMinefAbc = $crepMinefAbc;

        return $this;
    }

    /**
     * Get crepMinefAbc.
     *
     * @return \AppBundle\Entity\CrepMinefAbc
     */
    public function getCrepMinefAbc()
    {
        return $this->crepMinefAbc;
    }

    /**
     * Set competenceTransverse.
     *
     * @param \AppBundle\Entity\CompetenceTransverse $competenceTransverse
     *
     * @return CrepMinefAbcCompetenceTransverse
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
