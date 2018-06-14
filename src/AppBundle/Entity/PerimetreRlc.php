<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PerimetreRlc.
 *
 * @ORM\Table(name="perimetre_rlc", indexes = { @ORM\Index(columns={"libelle"}) })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerimetreRlcRepository")
 * @UniqueEntity(fields={"libelle", "ministere"},
 * 				errorPath="libelle",
 * 				message="Ce périmètre RLC existe déjà en base")
 */
class PerimetreRlc extends Perimetre
{
    /**
     * @ORM\ManyToOne(targetEntity="Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $ministere;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rlc", mappedBy="perimetresRlc")
     */
    private $rlcs;

    /**
     * @ORM\OneToMany(targetEntity="PerimetreBrhp", mappedBy="perimetreRlc")
     */
    private $perimetresBrhp;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CampagnePnc", mappedBy="perimetresRlc")
     */
    private $campagnesPnc;

    /**
     * @var CampagneRlc
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CampagneRlc", mappedBy="perimetreRlc")
     * @ORM\JoinColumn(nullable=true)
     */
    private $campagnesRlc;

    /**
     * Set ministere.
     *
     * @param \AppBundle\Entity\Ministere $ministere
     *
     * @return PerimetreRlc
     */
    public function setMinistere(\AppBundle\Entity\Ministere $ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return \AppBundle\Entity\Ministere
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
        $this->rlcs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rlc.
     *
     * @param \AppBundle\Entity\Rlc $rlc
     *
     * @return PerimetreRlc
     */
    public function addRlc(\AppBundle\Entity\Rlc $rlc)
    {
        $this->rlcs[] = $rlc;

        return $this;
    }

    /**
     * Remove rlc.
     *
     * @param \AppBundle\Entity\Rlc $rlc
     */
    public function removeRlc(\AppBundle\Entity\Rlc $rlc)
    {
        $this->rlcs->removeElement($rlc);
    }

    /**
     * Get rlcs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRlcs()
    {
        return $this->rlcs;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * Add perimetresBrhp.
     *
     * @param \AppBundle\Entity\PerimetreBrhp $perimetresBrhp
     *
     * @return PerimetreRlc
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

    /**
     * Add campagnePnc.
     *
     * @param \AppBundle\Entity\CampagnePnc $campagnePnc
     *
     * @return PerimetreRlc
     */
    public function addCampagnePnc(\AppBundle\Entity\CampagnePnc $campagnePnc)
    {
        $this->campagnesPnc[] = $campagnePnc;

        return $this;
    }

    /**
     * Remove campagnePnc.
     *
     * @param \AppBundle\Entity\CampagnePnc $campagnePnc
     */
    public function removeCampagnePnc(\AppBundle\Entity\CampagnePnc $campagnePnc)
    {
        $this->campagnesPnc->removeElement($campagnePnc);
    }

    /**
     * Get campagnePnc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampagnesPnc()
    {
        return $this->campagnesPnc;
    }

    /**
     * Get campagneRlc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampagnesRlc()
    {
        return $this->campagnesRlc;
    }
}
