<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateurTmp.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurTmpRepository")
 */
class UtilisateurTmp extends GenericEntity
{
    /**
     * @var Agent
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $role;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $locked;

    /**
     * Set agent.
     *
     * @param Agent $agent
     *
     * @return UtilisateurTmp
     */
    public function setAgent(Agent $agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent.
     *
     * @return Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set role.
     *
     * @param string $role
     *
     * @return UtilisateurTmp
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }
}
