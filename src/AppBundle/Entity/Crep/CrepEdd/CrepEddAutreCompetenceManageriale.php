<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CrepEddAutreCompetenceManageriale.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepositery\CrepEddRepositery\CrepEddAutreCompetenceManagerialeRepository")
 */
class CrepEddAutreCompetenceManageriale extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="autresCompetencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    public function getCrep()
    {
        return $this->crep;
    }

    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
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
