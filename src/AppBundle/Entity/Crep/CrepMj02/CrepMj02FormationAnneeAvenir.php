<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 12/07/2018
 * Time: 12:28
 */

namespace AppBundle\Entity\Crep\CrepMj02;


use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CrepMj02FormationAnneeAvenir
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository\CrepMj02FormationAnneeAvenirRepository")
 * @package AppBundle\Entity\Crep\CrepMj02
 */
class CrepMj02FormationAnneeAvenir extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj02", inversedBy="formationsAnneeAvenir")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param CrepMj02|null $crep
     * @return $this
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMj02\CrepMj02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return mixed
     */
    public function getCrep()
    {
        return $this->crep;
    }
}