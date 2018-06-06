<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * FormationReglementaire.
 *
 * @ORM\Table(name="formation_reglementaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationReglementaireRepository")
 */
class FormationReglementaire extends FormationDemandee
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message = "Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsReglementaires")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="integer")
     */
    protected $niveauSame;

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return FormationReglementaire
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
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationReglementaire
     */
    public function setCrep(\AppBundle\Entity\Crep $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set niveauSame.
     *
     * @param int $niveauSame
     *
     * @return FormationReglementaire
     */
    public function setNiveauSame($niveauSame)
    {
        $this->niveauSame = $niveauSame;

        return $this;
    }

    /**
     * Get niveauSame.
     *
     * @return int
     */
    public function getNiveauSame()
    {
        return $this->niveauSame;
    }
}
