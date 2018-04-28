<?php

namespace AppBundle\Entity;

use AppBundle\EnumTypes\EnumStatutCampagne;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Campagne.
 *
 * @ORM\MappedSuperclass
 */
abstract class Campagne extends GenericEntity
{
    /**
     * @var EnumStatutCampagne
     *
     * @ORM\Column(name="statut", type="string")
     * @Assert\NotBlank(message = "Champ obligatoire",)
     */
    protected $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateOuverture;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ouvertePar;

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
     * Set statut.
     *
     * @param string $statut
     *
     * @return CampagnePnc
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut.
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    public function getDateOuverture()
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTime $dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getOuvertePar()
    {
        return $this->ouvertePar;
    }

    public function setOuvertePar($ouvertePar)
    {
        $this->ouvertePar = $ouvertePar;

        return $this;
    }
}
