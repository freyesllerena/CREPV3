<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PerimetreBrhp.
 *
 * @ORM\Table(name="perimetre_brhp")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerimetreBrhpRepository")
 * @UniqueEntity(fields={"libelle", "perimetreRlc"},
 * 				errorPath="libelle",
 * 				message="Ce périmètre BRHP existe déjà en base")
 */
class PerimetreBrhp extends Perimetre
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreRlc", inversedBy="perimetresBrhp")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $perimetreRlc;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Brhp", mappedBy="perimetresBrhp")
     */
    private $brhps;
    
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BrhpConsult", mappedBy="perimetresBrhp")
     */
    private $brhpsConsult;

    /**
     * @var campagneBrhp
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CampagneBrhp", mappedBy="perimetreBrhp")
     * @ORM\JoinColumn(nullable=true)
     */
    private $campagnesBrhp;

    /**
     * @var campagneRlc
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CampagneRlc", mappedBy="perimetresBrhp")
     */
    private $campagnesRlc;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UniteOrganisationnelle", mappedBy="perimetreBrhp")
     */
    private $unitesOrganisationnelles;

    /**
     * Set perimetreRlc.
     *
     * @param \AppBundle\Entity\PerimetreRlc $perimetreRlc
     *
     * @return PerimetreBrhp
     */
    public function setPerimetreRlc(\AppBundle\Entity\PerimetreRlc $perimetreRlc)
    {
        $this->perimetreRlc = $perimetreRlc;

        return $this;
    }

    /**
     * Get perimetreRlc.
     *
     * @return \AppBundle\Entity\PerimetreRlc
     */
    public function getPerimetreRlc()
    {
        return $this->perimetreRlc;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->brhps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->campagnesBrhp = new \Doctrine\Common\Collections\ArrayCollection();
        $this->campagnesRlc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unitesOrganisationnelles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add brhp.
     *
     * @param \AppBundle\Entity\Brhp $brhp
     *
     * @return PerimetreBrhp
     */
    public function addBrhp(\AppBundle\Entity\Brhp $brhp)
    {
        $this->brhps[] = $brhp;

        return $this;
    }

    /**
     * Remove brhp.
     *
     * @param \AppBundle\Entity\Brhp $brhp
     */
    public function removeBrhp(\AppBundle\Entity\Brhp $brhp)
    {
        $this->brhps->removeElement($brhp);
    }

    /**
     * Get brhps.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrhps()
    {
        return $this->brhps;
    }

    /**
     * Add brhpConsult.
     *
     * @param \AppBundle\Entity\BrhpConsult $brhpConsult
     *
     * @return PerimetreBrhp
     */
    public function addBrhpConsult(\AppBundle\Entity\BrhpConsult $brhpConsult)
    {
    	$this->brhpsConsult[] = $brhpConsult;
    
    	return $this;
    }
    
    /**
     * Remove brhpConsult.
     *
     * @param \AppBundle\Entity\BrhpConsult $brhpConsult
     */
    public function removeBrhpConsult(\AppBundle\Entity\BrhpConsult $brhpConsult)
    {
    	$this->brhpsConsult->removeElement($brhpConsult);
    }
    
    /**
     * Get brhpsConsult.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrhpsConsult()
    {
    	return $this->brhpsConsult;
    }

    /**
     * Get campagneBrhp.
     *
     * @return CampagneBrhp
     */
    public function getCampagnesBrhp()
    {
        return $this->campagnesBrhp;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * Add campagnesBrhp.
     *
     * @param \AppBundle\Entity\CampagneBrhp $campagnesBrhp
     *
     * @return PerimetreBrhp
     */
    public function addCampagnesBrhp(\AppBundle\Entity\CampagneBrhp $campagnesBrhp)
    {
        $this->campagnesBrhp[] = $campagnesBrhp;

        return $this;
    }

    /**
     * Remove campagnesBrhp.
     *
     * @param \AppBundle\Entity\CampagneBrhp $campagnesBrhp
     */
    public function removeCampagnesBrhp(\AppBundle\Entity\CampagneBrhp $campagnesBrhp)
    {
        $this->campagnesBrhp->removeElement($campagnesBrhp);
    }

    /**
     * Add campagnesRlc.
     *
     * @param \AppBundle\Entity\CampagneRlc $campagnesRlc
     *
     * @return PerimetreBrhp
     */
    public function addCampagnesRlc(\AppBundle\Entity\CampagneRlc $campagnesRlc)
    {
        $this->campagnesRlc[] = $campagnesRlc;

        return $this;
    }

    /**
     * Remove campagnesRlc.
     *
     * @param \AppBundle\Entity\CampagneRlc $campagnesRlc
     */
    public function removeCampagnesRlc(\AppBundle\Entity\CampagneRlc $campagnesRlc)
    {
        $this->campagnesRlc->removeElement($campagnesRlc);
    }

    /**
     * Get campagnesRlc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampagnesRlc()
    {
        return $this->campagnesRlc;
    }

    /**
     * Add uniteOrganisationnelle.
     *
     * @param \AppBundle\Entity\UniteOrganisationnelle $uniteOrganisationnelle
     *
     * @return PerimetreBrhp
     */
    public function addUnitesOrganisationnelle(\AppBundle\Entity\UniteOrganisationnelle $uniteOrganisationnelle)
    {
        $this->unitesOrganisationnelles[] = $uniteOrganisationnelle;
        $uniteOrganisationnelle->setPerimetreBrhp($this);

        return $this;
    }

    /**
     * Remove uniteOrganisationnelle.
     *
     * @param \AppBundle\Entity\UniteOrganisationnelle $uniteOrganisationnelle
     */
    public function removeUnitesOrganisationnelle(\AppBundle\Entity\UniteOrganisationnelle $uniteOrganisationnelle)
    {
        $this->unitesOrganisationnelles->removeElement($uniteOrganisationnelle);
        $uniteOrganisationnelle->setPerimetreBrhp(null);
    }

    /**
     * Get uniteOrganisationnelle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnitesOrganisationnelles()
    {
        return $this->unitesOrganisationnelles;
    }
}
