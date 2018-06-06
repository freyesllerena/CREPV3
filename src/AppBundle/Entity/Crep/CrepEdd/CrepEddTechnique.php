<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * CrepEddTechnique.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddTechniqueRepository")
 */
class CrepEddTechnique extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="techniques")
     */
    protected $crep;

    /**
     * Set crep.
     *
     *
     * @return Technique
     */
    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
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
        if($this->libelle !== null && $this->niveauAcquis === null){
            $context->buildViolation("Le niveau de la connaissance est obligatoire")
                ->atPath('libelle')
                ->addViolation();
        }
    }
}
