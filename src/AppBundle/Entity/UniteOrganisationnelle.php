<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UniteOrganisationnelle.
 *
 * @ORM\Table(name="unite_organisationnelle", indexes = {	@ORM\Index(columns={"libelle"}),
 * 															@ORM\Index(columns={"code"}),
 * 															@ORM\Index(columns={"supprime"})
 * 							}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UniteOrganisationnelleRepository")
 * @UniqueEntity(fields={"code", "ministere", "supprime"},
 * 				errorPath="code",
 * 				message="Ce code UO est déjà utilisé.")
 */
class UniteOrganisationnelle extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Libellé obligatoire")
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Code obligatoire")
     */
    private $code;

    /**
     * @var Ministere
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ministere;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreBrhp", inversedBy="unitesOrganisationnelles")
     */
    private $perimetreBrhp;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UniteOrganisationnelle")
     * @ORM\JoinColumn(name="uo_mere_id", referencedColumnName="id")
     */
    private $uniteOrganisationnelleMere;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $supprime = false;

    private $codeUniteOrganisationnelleMere;

    private $ligne;

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return UniteOrganisationnelle
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
     * @return UniteOrganisationnelle
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
     * Set perimetreBrhp.
     *
     * @param PerimetreBrhp perimetreBrhp
     *
     * @return UniteOrganisationnelle
     */
    public function setPerimetreBrhp($perimetreBrhp)
    {
        $this->perimetreBrhp = $perimetreBrhp;

        return $this;
    }

    /**
     * Get perimetreBrhp.
     *
     * @return PerimetreBrhp
     */
    public function getPerimetreBrhp()
    {
        return $this->perimetreBrhp;
    }

    /**
     * Set ministere.
     *
     * @param int $ministere
     *
     * @return UniteOrganisationnelle
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
     * Set uniteOrganisationnelleMere.
     *
     * @param $uniteOrganisationnelleMere
     *
     * @return UniteOrganisationnelle
     */
    public function setUniteOrganisationnelleMere($uniteOrganisationnelleMere)
    {
        $this->uniteOrganisationnelleMere = $uniteOrganisationnelleMere;

        return $this;
    }

    /**
     * Get uniteOrganisationnelleMere.
     *
     * @return UniteOrganisationnelle
     */
    public function getUniteOrganisationnelleMere()
    {
        return $this->uniteOrganisationnelleMere;
    }

    /**
     * Set codeUniteOrganisationnelleMere.
     *
     * @param $codeUniteOrganisationnelleMere
     *
     * @return UniteOrganisationnelle
     */
    public function setCodeUniteOrganisationnelleMere($codeUniteOrganisationnelleMere)
    {
        $this->codeUniteOrganisationnelleMere = $codeUniteOrganisationnelleMere;

        return $this;
    }

    /**
     * Get codeUniteOrganisationnelleMere.
     *
     * @return UniteOrganisationnelle
     */
    public function getCodeUniteOrganisationnelleMere()
    {
        return $this->codeUniteOrganisationnelleMere;
    }

    /**
     * Set supprime.
     *
     * @param bool
     *
     * @return UniteOrganisationnelle
     */
    public function setSupprime($supprime)
    {
        $this->supprime = $supprime;

        return $this;
    }

    /**
     * Get supprime.
     *
     * @return UniteOrganisationnelle
     */
    public function getSupprime()
    {
        return $this->supprime;
    }

    public function getLigne()
    {
        return $this->ligne;
    }

    public function setLigne($ligne)
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function __toString()
    {
        return $this->code.' : '.$this->libelle;
    }
}
