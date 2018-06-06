<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Objectif;

/**
 * CrepEddObjectifFutur.
 *
 * @ORM\Table(name="crep_edd_objectif_futur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddObjectifFuturParentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepEddObjectifFuturParent extends Objectif
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
