<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Objectif.
 *
 * @ORM\MappedSuperclass
 */
abstract class Objectif extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $resultat;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $indicateurs;

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

    /**
     * Set resultat.
     *
     * @param string $resultat
     *
     * @return Objectif
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat.
     *
     * @return string
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    public function getIndicateurs()
    {
        return $this->indicateurs;
    }

    public function setIndicateurs($indicateurs)
    {
        $this->indicateurs = $indicateurs;

        return $this;
    }
}
