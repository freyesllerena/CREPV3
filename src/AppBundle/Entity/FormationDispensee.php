<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationDispensee.
 *
 * @ORM\Table(name="formation_dispensee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationDispenseeRepository")
 */
class FormationDispensee extends GenericEntity
{
    /**
     * @var date
     *
     * @ORM\Column(type="date", name="date_debut", nullable=true)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $formation;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsDispensees")
     */
    protected $crep;

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return FormationDispensee
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
     * Set formation.
     *
     * @param \AppBundle\Entity\Formation $formation
     *
     * @return FormationDispensee
     */
    public function setFormation(\AppBundle\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation.
     *
     * @return \AppBundle\Entity\Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationDispensee
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
}
