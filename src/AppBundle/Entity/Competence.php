<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Competence.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenceRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Competence extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     * @Assert\NotBlank(message = "Libellé obligatoire")
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauAcquis;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $appreciation;


    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Competence
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
     * @return Competence
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
     * @return string
     */
    public function getAppreciation()
    {
        return $this->appreciation;
    }

    /**
     * @param string $appreciation
     */
    public function setAppreciation($appreciation)
    {
        $this->appreciation = $appreciation;
    }
}
