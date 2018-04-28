<?php

namespace AppBundle\Entity\Crep\CrepMindef;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMindefCompetenceTransverse.
 *
 * @ORM\Table(name="crep_mindef_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_mindef_id", "competence_transverse_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindefCompetenceTransverseRepository")
 */
class CrepMindefCompetenceTransverse
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
     * @ORM\ManyToOne(targetEntity="CrepMindef", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMindef;

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
     * @return CrepMindefCompetenceTransverse
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
     * Set crepMindef.
     *
     * @param CrepMindef $crepMindef
     *
     * @return CrepMindefCompetenceTransverse
     */
    public function setCrepMindef(CrepMindef $crepMindef = null)
    {
        $this->crepMindef = $crepMindef;

        return $this;
    }

    /**
     * Get crepMindef.
     *
     * @return \AppBundle\Entity\CrepMindef
     */
    public function getCrepMindef()
    {
        return $this->crepMindef;
    }

    /**
     * Set competenceTransverse.
     *
     * @param \AppBundle\Entity\CompetenceTransverse $competenceTransverse
     *
     * @return CrepMindefCompetenceTransverse
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
