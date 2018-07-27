<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Formation.
 *
 * @ORM\Table(name = "formation")
 * @ORM\Entity(repositoryClass = "AppBundle\Repository\FormationRepository")
 * @UniqueEntity(fields={"code", "ministere"},
 * 				errorPath="code",
 * 				message="Cette formation existe déjà dans le référentiel des formations")
 */
class Formation extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type = "string")
     * @Assert\NotBlank(message="Champ obligatoire.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type = "string")
     * @Assert\NotBlank(message="Champ obligatoire.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(type = "float", nullable = true)
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Durée de formation trop petite",
     *      maxMessage = "Durée de formation trop grande",
     *      invalidMessage= "La durée de formation doit être positive avec un 'point' pour les valeurs décimales" )
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity = "AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable = false)
     */
    private $ministere;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type = "datetime")
     * @Assert\Date(message = "Date non valide")
     */
    private $dateFinValidite;

    public function __construct()
    {
        $this->dateFinValidite = new \DateTime('2999-12-31');
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Formation
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
     * Set code.
     *
     * @param string $code
     *
     * @return Formation
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
     * Set ministere.
     *
     * @param Ministere $ministere
     *
     * @return Formation
     */
    public function setMinistere(Ministere $ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return Ministere
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set dateFinValidite.
     *
     * @param Ministere $ministere
     *
     * @return Formation
     */
    public function setDateFinValidite($dateFinValidite)
    {
        $this->dateFinValidite = $dateFinValidite;

        return $this;
    }

    /**
     * Get dateFinValidite.
     *
     * @return \DateTime
     */
    public function getDateFinValidite()
    {
        return $this->dateFinValidite;
    }
}
