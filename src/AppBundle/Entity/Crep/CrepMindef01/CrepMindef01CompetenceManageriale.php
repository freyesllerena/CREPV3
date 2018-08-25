<?php

namespace AppBundle\Entity\Crep\CrepMindef01;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMindef01CompetenceManageriale.
 *
 * @ORM\Table(name="crep_mindef01_comp_manager", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_mindef01_id", "competence_manageriale_id"})
 * }))
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindef01CompetenceManagerialeRepository")
 */
class CrepMindef01CompetenceManageriale
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
     * @var string
     *
     * @ORM\Column(name="niveauAcquis", type="integer",  nullable=true)
     */
    private $niveauAcquis;

    /**
     * @ORM\ManyToOne(targetEntity="CrepMindef01", inversedBy="competencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMindef01;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompetenceManageriale", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $competenceManageriale;

    public function __construct()
    {
        $this->niveauAcquis = '5';
    }

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
     * @return CrepMindef01CompetenceManageriale
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
     * @param CrepMindef01|null $crepMindef01
     *
     * @return $this
     */
    public function setCrepMindef01(CrepMindef01 $crepMindef01 = null)
    {
        $this->crepMindef01 = $crepMindef01;

        return $this;
    }

    /**
     * Get crepMindef01.
     *
     * @return mixed
     */
    public function getCrepMindef01()
    {
        return $this->crepMindef01;
    }

    /**
     * Set competenceManageriale.
     *
     * @param \AppBundle\Entity\CompetenceManageriale $competenceManageriale
     *
     * @return CrepMindef01CompetenceManageriale
     */
    public function setCompetenceManageriale(\AppBundle\Entity\CompetenceManageriale $competenceManageriale = null)
    {
        $this->competenceManageriale = $competenceManageriale;

        return $this;
    }

    /**
     * Get competenceManageriale.
     *
     * @return \AppBundle\Entity\CompetenceManageriale
     */
    public function getCompetenceManageriale()
    {
        return $this->competenceManageriale;
    }
}
