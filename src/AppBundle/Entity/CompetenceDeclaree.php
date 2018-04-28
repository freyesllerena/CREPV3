<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CompetenceDeclaree.
 *
 * @ORM\Table(name="competence_declaree")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenceDeclareeRepository")
 */
class CompetenceDeclaree extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="competencesDeclarees")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return CompetenceDeclaree
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
    public function validate(ExecutionContextInterface $context)
    {
        //Si un niveau a été choisi, il faut renseigner le libellé
        if (null === $this->libelle && null !== $this->niveauAcquis) {
            $context->buildViolation('Le libellé de la compétence est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }

        //Si un niveau a été choisi, il faut renseigner le libellé
        if (null !== $this->libelle && null === $this->niveauAcquis) {
            $context->buildViolation('Le niveau acquis est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }
}
