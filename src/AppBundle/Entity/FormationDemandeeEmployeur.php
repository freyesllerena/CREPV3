<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationDemandeeEmployeur.
 *
 * @ORM\Table(name="formation_demandee_employeur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationDemandeeEmployeurRepository")
 */
class FormationDemandeeEmployeur extends FormationDemandee
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $lienAvecObjectifs;

//     /**
//      * @ORM\ManyToOne(targetEntity="Formation")
//      */
//     protected $formation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsDemandeesEmployeur")
     */
    protected $crep;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $horsDif;

    /**
     * Set lienAvecObjectifs.
     *
     * @param bool $lienAvecObjectifs
     *
     * @return FormationDemandeeEmployeur
     */
    public function setLienAvecObjectifs($lienAvecObjectifs)
    {
        $this->lienAvecObjectifs = $lienAvecObjectifs;

        return $this;
    }

    /**
     * Get lienAvecObjectifs.
     *
     * @return bool
     */
    public function getLienAvecObjectifs()
    {
        return $this->lienAvecObjectifs;
    }

//     /**
//      * Set formation
//      *
//      * @param \AppBundle\Entity\Formation $formation
//      *
//      * @return FormationDemandeeEmployeur
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
     * @return FormationDemandeeEmployeur
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
     * @return FormationDemandeeEmployeur
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

    public function getHorsDif()
    {
        return $this->horsDif;
    }

    public function setHorsDif($horsDif)
    {
        $this->horsDif = $horsDif;

        return $this;
    }
}
