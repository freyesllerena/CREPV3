<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormationDemandeeAdministration.
 *
 * @ORM\Table(name="formation_demandee_admin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationDemandeeAdministrationRepository")
 */
class FormationDemandeeAdministration extends FormationDemandee
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
     * @ORM\Column(type="string", nullable = false)
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsDemandeesAdministration")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable = true)
     */
    protected $typologie;

    /**
     * @var string
     *
     * @ORM\Column(type="string" , nullable = true)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $niveauSame;

    /**
     * Set lienAvecObjectifs.
     *
     * @param bool $lienAvecObjectifs
     *
     * @return FormationDemandeeAdministration
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
//      * @return FormationDemandeeAdministration
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
     * @return FormationDemandeeAdministration
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
     * @return FormationDemandeeAdministration
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
     * Set typologie.
     *
     * @param string $typologie
     *
     * @return FormationDemandeeAdministration
     */
    public function setTypologie($typologie)
    {
        $this->typologie = $typologie;

        return $this;
    }

    /**
     * Get typologie.
     *
     * @return string
     */
    public function getTypologie()
    {
        return $this->typologie;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return FormationDemandeeAdministration
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set niveauSame.
     *
     * @param int $niveauSame
     *
     * @return FormationDemandeeAdministration
     */
    public function setNiveauSame($niveauSame)
    {
        $this->niveauSame = $niveauSame;

        return $this;
    }

    /**
     * Get niveauSame.
     *
     * @return int
     */
    public function getNiveauSame()
    {
        return $this->niveauSame;
    }
}
