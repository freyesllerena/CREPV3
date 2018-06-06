<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BrhpConsult.
 *
 * @ORM\Table(name="brhp_consult")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrhpConsultRepository")
 */
class BrhpConsult extends Personne
{
    /**
     * @var Utilisateur
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @var Ministere
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ministere;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerimetreBrhp", inversedBy="brhpsConsult")
     * @ORM\JoinTable(name="brhp_consult_perimetres_brhp")
     * @Assert\Count(min = "1", minMessage  = "Périmètre obligatoire")
     */
    private $perimetresBrhp;

    /**
     * Set utilisateur.
     *
     * @param Utilisateur $utilisateur
     *
     * @return Brhp
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
     * @param int $ministere
     *
     * @return Brhp
     */
    public function setMinistere($ministere)
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
        $this->perimetresBrhp = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add perimetresBrhp.
     *
     * @param \AppBundle\Entity\PerimetreBrhp $perimetresBrhp
     *
     * @return Brhp
     */
    public function addPerimetresBrhp(\AppBundle\Entity\PerimetreBrhp $perimetresBrhp)
    {
        $this->perimetresBrhp[] = $perimetresBrhp;

        return $this;
    }

    /**
     * Remove perimetresBrhp.
     *
     * @param \AppBundle\Entity\PerimetreBrhp $perimetresBrhp
     */
    public function removePerimetresBrhp(\AppBundle\Entity\PerimetreBrhp $perimetresBrhp)
    {
        $this->perimetresBrhp->removeElement($perimetresBrhp);
    }

    /**
     * Get perimetresBrhp.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerimetresBrhp()
    {
        return $this->perimetresBrhp;
    }
}
