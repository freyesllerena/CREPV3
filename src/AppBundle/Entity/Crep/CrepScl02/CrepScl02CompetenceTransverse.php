<?php

namespace AppBundle\Entity\Crep\CrepScl02;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * CrepScl02CompetenceTransverse
 *
 * @ORM\Table(name="crep_scl02_comp_trans", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"crep_scl02_id", "id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepScl02Repository\CrepScl02CompetenceTransverseRepository")
 */
class CrepScl02CompetenceTransverse extends GenericEntity
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
    private $niveauAcquis ;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_competence", type="string", nullable=true)
     */
    protected $typeCompetence;

    /**
     * @ORM\ManyToOne(targetEntity="CrepScl02", inversedBy="competencesTransverses")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepScl02;
    
    
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
     * @return CrepScl02CompetenceTransverse
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
     * @return CrepScl02CompetenceTransverse
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
     * Set crepScl02
     *
     * @param \AppBundle\Entity\Crep\CrepScl02\CrepScl02 $crepScl02
     *
     * @return CrepScl02CompetenceTransverse
     */
    public function setCrepScl02(\AppBundle\Entity\Crep\CrepScl02\CrepScl02 $crepScl02 = null)
    {
        $this->crepScl02 = $crepScl02;

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
     * Get crepScl02
     *
     * @return \AppBundle\Entity\Crep\CrepScl02\CrepScl02
     */
    public function getCrepScl02()
    {
        return $this->crepScl02;
    }
}
