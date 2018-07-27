<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GenericEntity.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class GenericEntity implements GenericEntityInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    protected $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=true)
     */
    protected $dateModification;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="cree_par_id", referencedColumnName="id", nullable=true)
     */
    protected $creePar;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="modifie_par_id", referencedColumnName="id", nullable=true)
     */
    protected $modifiePar;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return GenericEntity
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification.
     *
     * @param \DateTime $dateModification
     *
     * @return GenericEntity
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification.
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set creePar.
     *
     * @param \AppBundle\Entity\Utilisateur $creePar
     *
     * @return GenericEntity
     */
    public function setCreePar(\AppBundle\Entity\Utilisateur $creePar = null)
    {
        $this->creePar = $creePar;

        return $this;
    }

    /**
     * Get creePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getCreePar()
    {
        return $this->creePar;
    }

    /**
     * Set modifiePar.
     *
     * @param \AppBundle\Entity\Utilisateur $modifiePar
     *
     * @return GenericEntity
     */
    public function setModifiePar(\AppBundle\Entity\Utilisateur $modifiePar = null)
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    /**
     * Get modifiePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getModifiePar()
    {
        return $this->modifiePar;
    }
}
