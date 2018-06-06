<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\ContraintePoste;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Crep;

/**
 * CrepEddAutreContraintePoste.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddAutreContraintePosteRepository")
 */
class CrepEddAutreContraintePoste extends ContraintePoste
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="autresContraintesPostes")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEdd $crep
     *
     * @return ContraintePoste
     */
    public function setCrep(CrepEdd $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crepEdd.
     *
     * @return \AppBundle\Entity\Crep\CrepEdd\CrepEdd
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
        if (null !== $this->libelle && null === $this->niveauDifficulte) {
            $context->buildViolation('Le niveau de difficulté est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }
}
