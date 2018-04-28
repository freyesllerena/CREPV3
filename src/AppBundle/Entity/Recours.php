<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Recours.
 *
 * @ORM\Table(name="recours")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecoursRepository")
 */
class Recours extends GenericEntity
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Le type est obligatoire")
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message = "La date de la demande est obligatoire")
     */
    private $dateDemande;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $decision;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $decisionPriseEnCompte = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDecision;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="recours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crep;

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return Recours
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateDemande.
     *
     * @param \DateTime $dateDemande
     *
     * @return Recours
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande.
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set decision.
     *
     * @param int $decision
     *
     * @return Recours
     */
    public function setDecision($decision)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision.
     *
     * @return int
     */
    public function getDecision()
    {
        return $this->decision;
    }

    /**
     * Set dateDecision.
     *
     * @param \DateTime $dateDecision
     *
     * @return Recours
     */
    public function setDateDecision($dateDecision)
    {
        $this->dateDecision = $dateDecision;

        return $this;
    }

    /**
     * Get dateDecision.
     *
     * @return \DateTime
     */
    public function getDateDecision()
    {
        return $this->dateDecision;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return Recours
     */
    public function setCrep(\AppBundle\Entity\Crep $crep)
    {
        $this->crep = $crep;

        return $this;
    }

    public function getDecisionPriseEnCompte()
    {
        return $this->decisionPriseEnCompte;
    }

    public function setDecisionPriseEnCompte($decisionPriseEnCompte)
    {
        $this->decisionPriseEnCompte = $decisionPriseEnCompte;

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
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->dateDecision && $this->dateDemande) {
            if ($this->dateDecision < $this->dateDemande) {
                $context->buildViolation('La date de la décision ne peut pas être antérieure à la date de la demande')
                    ->atPath('dateDecision')
                    ->addViolation();
            }
        }

        if ($this->dateDecision && null === $this->decision) {
            $context->buildViolation('Vous ne pouvez pas déclarer une date de décision sans décision')
            ->atPath('dateDecision')
            ->addViolation();
        }
    }
}
