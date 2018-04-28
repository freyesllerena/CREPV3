<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrepMj01QualiteProfessionnelle.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01QualiteProfessionnelleRepository")
 */
class CrepMj01QualiteProfessionnelle extends CrepMj01Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj01", inversedBy="qualitesProfessionnelles")
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
     * @return CrepMj01QualiteProfessionnelle
     */
    public function setCrep(CrepMj01 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
