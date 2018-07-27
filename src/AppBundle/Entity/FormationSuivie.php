<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormationSuivie.
 *
 * @ORM\Table(name="formation_suivie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationSuivieRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class FormationSuivie extends GenericEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="date_debut", nullable=true)
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $type;

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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *    min = 1,
     *    max = 200,
     *    minMessage = "Le libellé 2 de la formation doit contenir au moins {{ limit }} caractère",
     *    maxMessage = "Le libellé 2 de la formation doit contenir au plus {{ limit }} caractères")
     */
    protected $libelle2;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsSuivies")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable = true)
     */
    protected $commentaires;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable = true)
     */
    protected $annee;
    
    /**
     * @var int
     *
     * @ORM\Column(type = "integer", nullable = true)
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Durée de formation trop petite",
     *      maxMessage = "Durée de formation trop grande",
     *      invalidMessage= "La durée de formation doit être positive avec un 'point' pour les valeurs décimales" )
     */
    protected $duree;

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return FormationSuivie
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return FormationSuivie
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

//     /**
//      * Set formation
//      *
//      * @param \AppBundle\Entity\Formation $formation
//      *
//      * @return FormationSuivie
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
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationSuivie
     */
    public function setCrep(\AppBundle\Entity\Crep $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return FormationSuivie
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
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep
     */
    public function getCrep()
    {
        return $this->crep;
    }

    public function getCommentaires()
    {
        return $this->commentaires;
    }

    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getAnnee()
    {
        return $this->annee;
    }

    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Set duree.
     *
     * @param int $duree
     *
     * @return Formation
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree.
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @return string
     */
    public function getLibelle2()
    {
        return $this->libelle2;
    }

    /**
     * @param string $libelle2
     */
    public function setLibelle2($libelle2)
    {
        $this->libelle2 = $libelle2;
    }
}
