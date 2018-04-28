<?php

namespace AppBundle\Entity\Crep\CrepScl;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;

/**
 * CrepSclCompetenceTransverse.
 *
 * @ORM\Table(name="crep_scl_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_scl_id", "id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepSclRepository\CrepSclCompetenceTransverseRepository")
 */
class CrepSclCompetenceTransverse extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    private $niveauAcquis;

    /**
     * @var string
     *
     * @ORM\Column(name="type_competence", type="string", nullable=true)
     */
    protected $typeCompetence;

    /**
     * @ORM\ManyToOne(targetEntity="CrepScl", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepScl;

    public function __construct($libelle = null, $typeCompetence = null)
    {
        $this->libelle = $libelle;
        $this->typeCompetence = $typeCompetence;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return CompetenceTransverse
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set niveauAcquis.
     *
     * @param int $niveauAcquis
     *
     * @return CrepSclCompetenceTransverse
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
     * Set crepScl.
     *
     * @param \AppBundle\Entity\Crep\CrepScl\CrepScl $crepScl
     *
     * @return CrepSclCompetenceTransverse
     */
    public function setCrepScl(\AppBundle\Entity\Crep\CrepScl\CrepScl $crepScl = null)
    {
        $this->crepScl = $crepScl;

        return $this;
    }

    public function getTypeCompetence()
    {
        return $this->typeCompetence;
    }

    public function setTypeCompetence($typeCompetence)
    {
        $this->typeCompetence = $typeCompetence;

        return $this;
    }

    /**
     * Get crepScl.
     *
     * @return \AppBundle\Entity\Crep\CrepScl\CrepScl
     */
    public function getCrepScl()
    {
        return $this->crepScl;
    }
}
