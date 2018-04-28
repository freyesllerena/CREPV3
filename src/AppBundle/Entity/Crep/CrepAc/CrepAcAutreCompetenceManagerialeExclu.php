<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepAcAutreCompetenceManagerialeExclu.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcAutreCompetenceManagerialeExcluRepository")
 */
class CrepAcAutreCompetenceManagerialeExclu extends CrepAcCompetenceManageriale
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="autresCompetencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crepAc;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (null !== $this->libelle && null === $this->niveauAcquis) {
            $context->buildViolation('Le niveau de la compétence est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }

    public function getCrepAc()
    {
        return $this->crepAc;
    }

    public function setCrepAc($crepAc)
    {
        $this->crepAc = $crepAc;

        return $this;
    }
}
