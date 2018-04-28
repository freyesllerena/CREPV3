<?php

namespace AppBundle\Entity\Crep\CrepMindef;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMindefCompetenceManageriale.
 *
 * @ORM\Table(name="crep_mindef_comp_manage", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_mindef_id", "competence_manageriale_id"})
 * }))
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindefCompetenceManagerialeRepository")
 */
class CrepMindefCompetenceManageriale
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
     * @ORM\ManyToOne(targetEntity="CrepMindef", inversedBy="competencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMindef;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompetenceManageriale")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $competenceManageriale;

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
     * @return CrepMindefCompetenceManageriale
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
     * @return CrepMindefCompetenceManageriale
     */
    public function setCrepMindef(CrepMindef $crepMindef = null)
    {
        $this->crepMindef = $crepMindef;

        return $this;
    }

    /**
     * Get crepMindef.
     *
     * @return CrepMindef
     */
    public function getCrepMindef()
    {
        return $this->crepMindef;
    }

    /**
     * Set competenceManageriale.
     *
     * @param \AppBundle\Entity\CompetenceManageriale $competenceManageriale
     *
     * @return CrepMindefCompetenceManageriale
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
