<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Emploi.
 *
 * @ORM\Table(name="emploi")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmploiRepository")
 */
class Emploi extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $affectation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $poste;

    /**
     * @var date
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateDebut;

    /**
     * @var date
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $familleMorgane;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="emplois")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nombreAnneesDomaine;

    /**
     * Set affectation.
     *
     * @param string $affectation
     *
     * @return Emploi
     */
    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;

        return $this;
    }

    /**
     * Get affectation.
     *
     * @return string
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * Set poste.
     *
     * @param string $poste
     *
     * @return Emploi
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste.
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set dateDebut.
     *
     * @param \DateTime $dateDebut
     *
     * @return Emploi
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut.
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin.
     *
     * @param \DateTime $dateFin
     *
     * @return Emploi
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin.
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set familleMorgane.
     *
     * @param string $familleMorgane
     *
     * @return Emploi
     */
    public function setFamilleMorgane($familleMorgane)
    {
        $this->familleMorgane = $familleMorgane;

        return $this;
    }

    /**
     * Get familleMorgane.
     *
     * @return string
     */
    public function getFamilleMorgane()
    {
        return $this->familleMorgane;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return Emploi
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
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        // Vérification sur la cohérence des dates
        if ($this->dateFin && $this->dateDebut && $this->dateDebut > $this->dateFin) {
            $context->buildViolation('Date incohérente')
            ->atPath('dateFin')
            ->addViolation();
        }

        if (($this->familleMorgane || $this->dateDebut || $this->dateFin) && !$this->affectation) {
            $context->buildViolation('Champ obligatoire')
            ->atPath('affectation')
            ->addViolation();
        }

        if (($this->familleMorgane || $this->dateDebut || $this->dateFin) && !$this->poste) {
            $context->buildViolation('Champ obligatoire')
            ->atPath('poste')
            ->addViolation();
        }

        if (!$this->poste && $this->nombreAnneesDomaine) {
            $context->buildViolation('Le domaine est obligatoire')
            ->atPath('poste')
            ->addViolation();
        }
    }

    /**
     * Set nombreAnneesDomaine.
     *
     * @param string $nombreAnneesDomaine
     *
     * @return Emploi
     */
    public function setNombreAnneesDomaine($nombreAnneesDomaine)
    {
        $this->nombreAnneesDomaine = $nombreAnneesDomaine;

        return $this;
    }

    /**
     * Get nombreAnneesDomaine.
     *
     * @return string
     */
    public function getNombreAnneesDomaine()
    {
        return $this->nombreAnneesDomaine;
    }
}
