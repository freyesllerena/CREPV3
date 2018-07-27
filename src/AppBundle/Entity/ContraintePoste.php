<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContraintePoste.
 *
 * @ORM\Table(name="contrainte_poste")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContraintePosteRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class ContraintePoste extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauDifficulte;

    /**
     * @var string
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
     * @return string
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

    /**
     * @return int
     */
    public function getNiveauDifficulte()
    {
        return $this->niveauDifficulte;
    }

    /**
     * @param
     *            $niveauDifficulte
     */
    public function setNiveauDifficulte($niveauDifficulte)
    {
        $this->niveauDifficulte = $niveauDifficulte;

        return $this;
    }

    /**
     * @return string
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
}
