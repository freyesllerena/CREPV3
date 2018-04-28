<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\ObjectifFuturParent;

/**
 * ObjectifFuturCollectif.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifAVenirCollectifRepository")
 */
class ObjectifFuturCollectif extends ObjectifFuturParent
{
    /**
     * @var text
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
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="objectifsFutursCollectifs")
     */
    protected $crep;

    /**
     * @return the text
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
