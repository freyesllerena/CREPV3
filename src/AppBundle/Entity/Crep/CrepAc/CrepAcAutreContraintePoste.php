<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\ContraintePoste;

/**
 * CrepAcContraintePoste.
 *
 * @ORM\Table(name="crep_ac_autre_contrainte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcAutreContraintePosteRepository")
 */
class CrepAcAutreContraintePoste extends ContraintePoste
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="autresContraintesPoste")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\CrepAc $crep
     *
     * @return ContraintePoste
     */
    public function setCrep(CrepAc $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\CrepAc
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
