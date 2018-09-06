<?php

namespace AppBundle\Entity\Crep\CrepMso3;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CompetencePoste.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMso3AptitudeManagementAgentRepository")
 */
class CrepMso3AptitudeManagementAgent extends CrepMso3Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso3", inversedBy="aptitudesManagementAgent")
     */
    protected $crep;

    public function __construct($libelle = null)
    {
        parent::__construct($libelle);
        $this->niveau = null;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep
     *
     * @return CrepMso3Competence
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepMso3\CrepMso3
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * @Assert\Callback()
     */
    public function validateCrepMso3CompetenceNiveau(ExecutionContextInterface $context)
    {
        // Surcharger la fonction validateCrepMso3CompetenceNiveau de la classe mère pour accepter les niveaux à null
    }
}
