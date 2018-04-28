<?php

namespace AppBundle\Entity\Crep\CrepMcc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * FormationAVenir.
 *
 * @ORM\Table(name="crep_mcc_formation_a_venir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMccRepository\CrepMccFormationAVenirRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMccFormationAVenir extends GenericEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $besoinAvere;

//     /**
//      * @ORM\ManyToOne(targetEntity="Formation")
//      */
//     protected $formation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $besoinToujoursAvere;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $origine;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $cpf;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        //Si le résultat, échéance ou observations sont renseignés,  l'intitulé de l'objectif est obligatoire
        if (null !== $this->libelle && (null === $this->origine)) {
            $context->buildViolation("L'origine de la demande est obligatoire")
            ->atPath('libelle')
            ->addViolation();
        }
    }

    /**
     * Set besoinAvere.
     *
     * @param bool $besoinAvere
     *
     * @return FormationAVenir
     */
    public function setBesoinAvere($besoinAvere)
    {
        $this->besoinAvere = $besoinAvere;

        return $this;
    }

    /**
     * Get besoinAvere.
     *
     * @return bool
     */
    public function getBesoinAvere()
    {
        return $this->besoinAvere;
    }

//     /**
//      * Set formation
//      *
//      * @param \AppBundle\Entity\Formation $formation
//      *
//      * @return FormationAVenir
//      */
//     public function setFormation(\AppBundle\Entity\Formation $formation = null)
//     {
//         $this->formation = $formation;

//         return $this;
//     }

//     /**
//      * Get formation
//      *
//      * @return \AppBundle\Entity\Formation
//      */
//     public function getFormation()
//     {
//         return $this->formation;
//     }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return FormationAVenir
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set besoinToujoursAvere.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationSuivie
     */
    public function setBesoinToujoursAvere($besoinToujoursAvere)
    {
        $this->besoinToujoursAvere = $besoinToujoursAvere;

        return $this;
    }

    /**
     * Get besoinToujoursAvere.
     *
     * @return bool
     */
    public function getBesoinToujoursAvere()
    {
        return $this->besoinToujoursAvere;
    }

    public function getOrigine()
    {
        return $this->origine;
    }

    public function setOrigine($origne)
    {
        $this->origine = $origne;

        return $this;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }
}
