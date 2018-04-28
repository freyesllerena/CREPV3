<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ContraintePoste;

/**
 * CrepAcContraintePoste.
 *
 * @ORM\Table(name="crep_ac_contrainte_poste")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcContraintePosteRepository")
 */
class CrepAcContraintePoste extends ContraintePoste
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="contraintesPoste")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\CrepAc $crep
     *
     * @return ContraintePoste
     */
    public function setCrep(CrepAc $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\CrepAc
     */
    public function getCrep()
    {
        return $this->crep;
    }

    public function __construct($libelle)
    {
        $this->libelle = $libelle;
    }
}
