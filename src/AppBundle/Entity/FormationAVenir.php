<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormationAVenir.
 *
 * @ORM\Table(name="formation_a_venir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationAVenirRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class FormationAVenir extends GenericEntity
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
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsAVenir")
     */
    protected $crep;

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
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationAVenir
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
