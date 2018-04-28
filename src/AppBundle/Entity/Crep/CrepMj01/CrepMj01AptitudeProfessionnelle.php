<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMj01AptitudeProfessionnelle.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01AptitudeProfessionnelleRepository")
 */
class CrepMj01AptitudeProfessionnelle extends CrepMj01Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj01", inversedBy="aptitudesProfessionnelles")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    /**
     * Get crep.
     *
     * @return CrepMj01
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set crep.
     *
     * @param CrepMj01 $crep
     *
     * @return CrepMj01AptitudeProfessionnelle
     */
    public function setCrep(CrepMj01 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
