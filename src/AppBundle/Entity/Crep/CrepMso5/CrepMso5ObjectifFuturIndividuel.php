<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMso5ObjectifFuturIndividuel.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5ObjectifFuturIndividuelRepositery")
 */
class CrepMso5ObjectifFuturIndividuel extends CrepMso5ObjectifFuturParent
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $indicateurs;

    /**
     * @ORM\ManyToOne(targetEntity="CrepMso5", inversedBy="objectifsFutursIndividuels")
     */
    protected $crep;

    /**
     * @return  string
     */
    public function getIndicateurs()
    {
        return $this->indicateurs;
    }

    /**
     * @param   $indicateurs
     *
     * @return  $indicateurs
     */
    public function setIndicateurs($indicateurs)
    {
        $this->indicateurs = $indicateurs;

        return $this;
    }

    public function getCrep()
    {
        return $this->crep;
    }

    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }
}
