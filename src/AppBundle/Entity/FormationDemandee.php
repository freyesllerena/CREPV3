<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationDemandee.
 *
 * @ORM\MappedSuperclass
 */
abstract class FormationDemandee extends GenericEntity
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $priorite;

    /**
     * Set priorite.
     *
     * @param int $priorite
     *
     * @return FormationDemandee
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite.
     *
     * @return int
     */
    public function getPriorite()
    {
        return $this->priorite;
    }
}
