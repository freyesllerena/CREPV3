<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 27/06/2018
 * Time: 11:23
 */

namespace AppBundle\Entity\Crep\CrepMj02;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;

/**
 * Class CrepMj02CompetenceEncadrement
 * @package AppBundle\Entity\Crep\CrepMj02
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository
 * \CrepMj02CompetenceEncadrementRepository")
 */
class CrepMj02CompetenceEncadrement extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj02", inversedBy="competencesEncadrements")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    /**
     * Get crep
     *
     * @return mixed
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set crep
     *
     * @param CrepMj02|null $crep
     *
     * @return $this
     */
    public function setCrep(CrepMj02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}