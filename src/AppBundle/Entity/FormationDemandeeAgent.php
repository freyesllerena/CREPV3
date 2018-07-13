<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormationDemandeeAgent.
 *
 * @ORM\Table(name="formation_demandee_agent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationDemandeeAgentRepository")
 */
class FormationDemandeeAgent extends FormationDemandee
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $dif;

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
     * @Assert\Length(
     *    min = 1,
     *    max = 200,
     *    minMessage = "Le libellé de la formation doit contenir au moins {{ limit }} caractère",
     *    maxMessage = "Le libellé de la formation doit contenir au plus {{ limit }} caractères")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsDemandeesAgent")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $typologie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)

     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauSame;

    /**
     * Set dif.
     *
     * @param bool $dif
     *
     * @return FormationDemandeeAgent
     */
    public function setDif($dif)
    {
        $this->dif = $dif;

        return $this;
    }

    /**
     * Get dif.
     *
     * @return bool
     */
    public function getDif()
    {
        return $this->dif;
    }

//     /**
//      * Set formation
//      *
//      * @param \AppBundle\Entity\Formation $formation
//      *
//      * @return FormationDemandeeAgent
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
     * @return FormationDemandeeAgent
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
     * @return FormationDemandeeAgent
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
     * @return FormationDemandeeAgent
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
     * @return FormationDemandeeAgent
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
     * @return FormationDemandeeAgent
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
