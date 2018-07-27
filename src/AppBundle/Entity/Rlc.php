<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Rlc.
 *
 * @ORM\Table(name="rlc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RlcRepository")
 * @UniqueEntity(fields={"email"},
 * 				errorPath="email",
 * 				message="Cet email est déjà utilisé pour un autre RLC.")
 */
class Rlc extends Personne
{
    /**
     * @var Utilisateur
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ministere;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerimetreRlc", inversedBy="rlcs")
     * @ORM\JoinTable(name="rlc_perimetres_rlc")
     * @Assert\Count(min = "1", minMessage  = "Périmètre obligatoire")
     */
    private $perimetresRlc;

    /**
     * Set utilisateur.
     *
     * @param Utilisateur $utilisateur
     *
     * @return Rlc
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur.
     *
     * @return Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set ministere.
     *
     * @param Ministere $ministere
     *
     * @return Rlc
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
     * Constructor.
     */
    public function __construct()
    {
        $this->perimetresRlc = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add perimetreRlc.
     *
     * @param \AppBundle\Entity\PerimetreRlc $perimetreRlc
     *
     * @return Rlc
     */
    public function addPerimetresRlc(\AppBundle\Entity\PerimetreRlc $perimetreRlc)
    {
        $this->perimetresRlc[] = $perimetreRlc;
        $perimetreRlc->addRlc($this);

        return $this;
    }

    /**
     * Remove perimetreRlc.
     *
     * @param \AppBundle\Entity\PerimetreRlc $perimetreRlc
     */
    public function removePerimetresRlc(\AppBundle\Entity\PerimetreRlc $perimetreRlc)
    {
        $this->perimetresRlc->removeElement($perimetreRlc);
    }

    /**
     * Get perimetresRlc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerimetresRlc()
    {
        return $this->perimetresRlc;
    }
}
