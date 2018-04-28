<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMj01Competence.
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\Table(name="crep_mj01_competence")
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01CompetenceRepository")
 */
class CrepMj01Competence extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;

//     public function __construct($libelle = null, $typeCompetence = null ){
    // 		$this->libelle = $libelle;
    // 		$this->typeCompetence = $typeCompetence;
//     }

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
     * Set niveau.
     *
     * @param int $niveau
     *
     * @return CrepMj01CompetenceTransverse
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau.
     *
     * @return int
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
}
