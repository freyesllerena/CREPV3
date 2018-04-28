<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ModeleCrep.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModeleCrepRepository")
 * @UniqueEntity(
 *     fields={"libelle", "ministere"},
 *     errorPath="libelle",
 *     message="Un modèle avec cet libellé existe déjà."
 * )
 */
class ModeleCrep extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere", inversedBy="modelesCrep", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $ministere;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $typeEntity;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $actif;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->actif = true;
        $this->setDateCreation(new \DateTime());
        $this->setDateModification(new \DateTime());
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Objectif
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

    public function getMinistere()
    {
        return $this->ministere;
    }

    public function setMinistere($ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    public function getTypeEntity()
    {
        return $this->typeEntity;
    }

    public function setTypeEntity($typeEntity)
    {
        $this->typeEntity = $typeEntity;

        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }
}
