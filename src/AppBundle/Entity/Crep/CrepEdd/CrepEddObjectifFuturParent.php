<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     *
     * @Assert\Length(max = 200, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $echeance;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(max = 4090, maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères")
     */
    protected $observationsEventuelles;

    /**
     * Set echeance.
     *
     * @return $echeance
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
     * @return   string
     */
    public function getObservationsEventuelles()
    {
        return $this->observationsEventuelles;
    }

    /**
     * Set observationsEventuelles
     *
     * return $observationsEventuelles
     */
    public function setObservationsEventuelles($observationsEventuelles)
    {
        $this->observationsEventuelles = $observationsEventuelles;

        return $this;
    }
}
