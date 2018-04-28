<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepAcCompetenceTransverse.
 *
 * @ORM\Table(name="crep_ac_comp_trans")
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcCompetenceTransverseRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepAcCompetenceTransverse
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
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    protected $niveauAcquis;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observations;

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
     * @return the text
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param
     *            $observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * @return the text
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param
     *            $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
