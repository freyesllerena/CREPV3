<?php

namespace AppBundle\Entity\Crep\CrepMindef01;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMindefCompetenceTransverse.
 *
 * @ORM\Table(name="crep_mindef01_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_mindef01_id", "competence_transverse_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindef01CompetenceTransverseRepository")
 */
class CrepMindef01CompetenceTransverse
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
     * @ORM\ManyToOne(targetEntity="CrepMindef01", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMindef01;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompetenceTransverse", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $competenceTransverse;

//     public function __construct(){

//         $this->niveauAcquis = "5";
//     }

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
     * @return CrepMindef01CompetenceTransverse
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
     * Set crepMindef01.
     *
     * @param \AppBundle\Entity\CrepMindef01 $crepMindef01
     *
     * @return CrepMindef01CompetenceTransverse
     */
    public function setCrepMindef01(CrepMindef01 $crepMindef01 = null)
    {
        $this->crepMindef01 = $crepMindef01;

        return $this;
    }

    /**
     * Get crepMindef01.
     *
     * @return \AppBundle\Entity\CrepMindef01
     */
    public function getCrepMindef01()
    {
        return $this->crepMindef01;
    }

    /**
     * Set competenceTransverse.
     *
     * @param \AppBundle\Entity\CompetenceTransverse $competenceTransverse
     *
     * @return CrepMindef01CompetenceTransverse
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
