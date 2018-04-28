<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    protected $echeance;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
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
