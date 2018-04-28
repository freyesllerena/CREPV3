<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Souhait.
 *
 * @ORM\MappedSuperclass
 */
abstract class Souhait extends GenericEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $choix;

    /**
     * Set choix.
     *
     * @param bool $choix
     *
     * @return Souhait
     */
    public function setChoix($choix)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix.
     *
     * @return bool
     */
    public function getChoix()
    {
        return $this->choix;
    }
}
