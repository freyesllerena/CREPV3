<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MobiliteGeographique.
 *
 * @ORM\Table(name="motivations_mobilite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MotivationsMobiliteRepository")
 */
class MotivationsMobilite extends GenericEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $projetProfessionnel;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $choix;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $reorganisation;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $rapprochementFamilial;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $autre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $echeance;

    /**
     * @ORM\OneToOne(targetEntity="Crep", mappedBy="motivationsMobilite")
     */
    protected $crep;

    /**
     * Set projetProfessionnel.
     *
     * @param bool $projetProfessionnel
     *
     * @return MotivationsMobilite
     */
    public function setProjetProfessionnel($projetProfessionnel)
    {
        $this->projetProfessionnel = $projetProfessionnel;

        return $this;
    }

    /**
     * Get projetProfessionnel.
     *
     * @return bool
     */
    public function getProjetProfessionnel()
    {
        return $this->projetProfessionnel;
    }

    /**
     * Set reorganisation.
     *
     * @param bool $reorganisation
     *
     * @return MotivationsMobilite
     */
    public function setReorganisation($reorganisation)
    {
        $this->reorganisation = $reorganisation;

        return $this;
    }

    /**
     * Get reorganisation.
     *
     * @return bool
     */
    public function getReorganisation()
    {
        return $this->reorganisation;
    }

    /**
     * Set rapprochementFamilial.
     *
     * @param bool $rapprochementFamilial
     *
     * @return MotivationsMobilite
     */
    public function setRapprochementFamilial($rapprochementFamilial)
    {
        $this->rapprochementFamilial = $rapprochementFamilial;

        return $this;
    }

    /**
     * Get rapprochementFamilial.
     *
     * @return bool
     */
    public function getRapprochementFamilial()
    {
        return $this->rapprochementFamilial;
    }

    /**
     * Set autre.
     *
     * @param string $autre
     *
     * @return MotivationsMobilite
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre.
     *
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }

    public function getEcheance()
    {
        return $this->echeance;
    }

    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    public function getCrep()
    {
        return $this->crep;
    }

    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }

    public function getChoix()
    {
        return $this->choix;
    }

    public function setChoix($choix)
    {
        $this->choix = $choix;

        return $this;
    }

//     /**
//      * @Assert\Callback
//      */
//     public function validate(ExecutionContextInterface $context)
//     {
//         if ($this->choix) {
// //             if ($this->crepMindef01 instanceof CrepMindef01) {
//                 if (!$this->projetProfessionnel && !$this->reorganisation && !$this->rapprochementFamilial && !$this->autre) {
//                     $context->buildViolation("Veuillez préciser votre souhait de mobilité.")
//                     ->atPath('projetProfessionnel')
//                     ->addViolation();

//                     $context->buildViolation("")
//                     ->atPath('reorganisation')
//                     ->addViolation();

//                     $context->buildViolation("")
//                     ->atPath('rapprochementFamilial')
//                     ->addViolation();

//                     $context->buildViolation("")
//                     ->atPath('autre')
//                     ->addViolation();
//                 }
//             }
// //         }

//     }
}
