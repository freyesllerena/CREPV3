<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 10/07/2018
 * Time: 11:07
 */

namespace AppBundle\Entity\Crep\CrepMj02;


use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class CrepMj02FormationAnneeEcoulee
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository\CrepMj02FormationAnneeEcouleeRepository")
 * @package AppBundle\Entity\Crep\CrepMj02
 */
class CrepMj02FormationAnneeEcoulee extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj02", inversedBy="formationsAnneeEcoulee")
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
