<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMso5CompetenceTransverse
 *
 * @ORM\Table(name="crep_mso5_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_mso5_id", "id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5CompetenceTransverseRepository")
 */
class CrepMso5CompetenceTransverse extends GenericEntity
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
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepMso5;


    public function __construct($libelle = null, $typeCompetence = null)
    {
        $this->libelle = $libelle;
        $this->typeCompetence = $typeCompetence;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return CrepMso5CompetenceTransverse
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set niveauAcquis
     *
     * @param integer $niveauAcquis
     *
     * @return CrepMso5CompetenceTransverse
     */
    public function setNiveauAcquis($niveauAcquis)
    {
        $this->niveauAcquis = $niveauAcquis;

        return $this;
    }

    /**
     * Get niveauAcquis
     *
     * @return integer
     */
    public function getNiveauAcquis()
    {
        return $this->niveauAcquis;
    }

    /**
     * Set crepMso5
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5 $crepMso5
     *
     * @return CrepMso5CompetenceTransverse
     */
    public function setCrepMso5(\AppBundle\Entity\Crep\CrepMso5\CrepMso5 $crepMso5 = null)
    {
        $this->crepMso5 = $crepMso5;

        return $this;
    }

    /**
     * Get Competence
     *
     * @return string
     */
    public function getTypeCompetence()
    {
        return $this->typeCompetence;
    }

    /**
     * Set typeCompetence
     *
     * @param string $typeCompetence
     *
     * @return string
     */
    public function setTypeCompetence($typeCompetence)
    {
        $this->typeCompetence = $typeCompetence;
        return $this;
    }

    /**
     * Get crepMso5
     *
     * @return \AppBundle\Entity\Crep\CrepMso5\CrepMso5
     */
    public function getCrepMso5()
    {
        return $this->crepMso5;
    }
}
