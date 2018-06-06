<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Ministere.
 *
 * @ORM\Table(name="ministere")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MinistereRepository")
 *
 * @UniqueEntity(fields={"libelleCourt"}, errorPath="libelleCourt", message="Ce libellé court existe déjà en base")
 * @ORM\HasLifecycleCallbacks
 */
class Ministere extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_court", type="string")
     * @Assert\NotBlank(message = "Libellé court obligatoire")
     */
    private $libelleCourt;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_long", type="text")
     *  @Assert\NotBlank(message = "Libellé long obligatoire")
     */
    private $libelleLong;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_officiel", type="text")
     *  @Assert\NotBlank(message = "Libellé officiel obligatoire")
     */
    private $libelleOfficiel;

    /**
     * @var bool
     *
     * @ORM\Column(name="supprime", type="boolean", options={"default":false})
     */
    private $supprime = false;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default":2})
     */
    protected $delaiVisa = 2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default":0})
     */
    protected $delaiSignatureDefinitive = 0;

    /**
     * @var ModeleCrep
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModeleCrep", mappedBy="ministere", cascade={"persist", "remove"})
     */
    private $modelesCrep;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->modelesCrep = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ModeleCrep.
     *
     * @param ModeleCrep $modeleCREP
     *
     * @return Ministere
     */
    public function addModelesCrep(ModeleCrep $modeleCREP)
    {
        $this->modelesCrep[] = $modeleCREP;
        $modeleCREP->setMinistere($this);

        return $this;
    }

    /**
     * remove ModeleCrep.
     *
     * @param ModeleCrep $modeleCREP
     */
    public function removeModelesCrep(ModeleCrep $modeleCREP)
    {
        $this->modelesCrep->removeElement($modeleCREP);
        $modeleCREP->setMinistere(null);
    }

    /**
     * Get modeleCREP.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModelesCrep()
    {
        return $this->modelesCrep;
    }

    /**
     * Set libelleCourt.
     *
     * @param string $libelleCourt
     *
     * @return Ministere
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;

        return $this;
    }

    /**
     * Get libelleCourt.
     *
     * @return string
     */
    public function getLibelleCourt()
    {
        return $this->libelleCourt;
    }

    /**
     * Set libelleLong.
     *
     * @param string $libelleLong
     *
     * @return Ministere
     */
    public function setLibelleLong($libelleLong)
    {
        $this->libelleLong = $libelleLong;

        return $this;
    }

    /**
     * Get libelleLong.
     *
     * @return string
     */
    public function getLibelleLong()
    {
        return $this->libelleLong;
    }

    /**
     * Set libelleOfficiel.
     *
     * @param string $libelleOfficiel
     *
     * @return Ministere
     */
    public function setLibelleOfficiel($libelleOfficiel)
    {
        $this->libelleOfficiel = $libelleOfficiel;

        return $this;
    }

    /**
     * Get libelleOfficiel.
     *
     * @return string
     */
    public function getLibelleOfficiel()
    {
        return $this->libelleOfficiel;
    }

    /**
     * Set supprime.
     *
     * @param bool $supprime
     *
     * @return Ministere
     */
    public function setSupprime($supprime)
    {
        $this->supprime = $supprime;

        return $this;
    }

    /**
     * Get supprime.
     *
     * @return bool
     */
    public function getSupprime()
    {
        return $this->supprime;
    }

    /**
     * Get delaiVisa.
     *
     * @return int
     */
    public function getDelaiVisa()
    {
        return $this->delaiVisa;
    }

    /**
     * Set delaiVisa.
     *
     * @param int $delaiVisa
     *
     * @return Ministere
     */
    public function setDelaiVisa($delaiVisa)
    {
        $this->delaiVisa = $delaiVisa;

        return $this;
    }

    /**
     * Get delaiSignatureDefinitive.
     *
     * @return int
     */
    public function getDelaiSignatureDefinitive()
    {
        return $this->delaiSignatureDefinitive;
    }

    /**
     * Set delaiSignatureDefinitive.
     *
     * @param int $delaiSignatureDefinitive
     *
     * @return Ministere
     */
    public function setDelaiSignatureDefinitive($delaiSignatureDefinitive)
    {
        $this->delaiSignatureDefinitive = $delaiSignatureDefinitive;

        return $this;
    }

    public function __toString()
    {
        return $this->libelleCourt;
    }
}
