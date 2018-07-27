<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\ObjectifFuturParent;

/**
 * ObjectifFuturIndividuel.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifAVenirIndividuelRepository")
 */
class ObjectifFuturIndividuel extends ObjectifFuturParent
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
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="objectifsFutursIndividuels")
     */
    protected $crep;

    /**
     * @return string
     */
    public function getIndicateurs()
    {
        return $this->indicateurs;
    }

    /**
     * @param
     *            $indicateurs
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
