<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DemandeFormationProfessionnelle.
 *
 * @ORM\Table(name="demande_formation_pro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeFormationProfessionnelle")
 * @ORM\HasLifecycleCallbacks()
 */
class DemandeFormationProfessionnelle extends Souhait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $typeFormation;

    /**
     * Set typeFormation.
     *
     * @param string $typeFormation
     *
     * @return DemandeFormationProfessionnelle
     */
    public function setTypeFormation($typeFormation)
    {
        $this->typeFormation = $typeFormation;

        return $this;
    }

    /**
     * Get typeFormation.
     *
     * @return string
     */
    public function getTypeFormation()
    {
        return $this->typeFormation;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->choix) {
            if (!$this->typeFormation) {
                $context->buildViolation('Veuillez préciser le type de la formation demandée.')
                    ->atPath('typeFormation')
                    ->addViolation();
            }
        }
    }
}
