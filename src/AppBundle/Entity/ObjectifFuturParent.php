<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ObjectifFutur.
 *
 * @ORM\Table(name="objectif_futur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifFuturParentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class ObjectifFuturParent extends Objectif
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max = 255, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $echeance;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max = 4096, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $observationsEventuelles;

    /**
     * Set echeance.
     *
     * @return ObjectifFutur
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * Get echeance.
     */
    public function getEcheance()
    {
        return $this->echeance;
    }

    /**
     * @return the string
     */
    public function getObservationsEventuelles()
    {
        return $this->observationsEventuelles;
    }

    /**
     * @param
     *            $observationsEventuelles
     */
    public function setObservationsEventuelles($observationsEventuelles)
    {
        $this->observationsEventuelles = $observationsEventuelles;

        return $this;
    }
}
