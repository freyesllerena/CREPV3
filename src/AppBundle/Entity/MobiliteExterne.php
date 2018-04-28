<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MobiliteExterne.
 *
 * @ORM\Table(name="mobilite_externe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobiliteExterneRepository")
 */
class MobiliteExterne extends Souhait
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ministere;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $horsMinistere;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $priorite;

    /**
     * @ORM\OneToOne(targetEntity="Crep", mappedBy="mobiliteExterne")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $anneeDepart;

    /**
     * Set horsMinistere.
     *
     * @param string $horsMinistere
     *
     * @return MobiliteExterne
     */
    public function setHorsMinistere($horsMinistere)
    {
        $this->horsMinistere = $horsMinistere;

        return $this;
    }

    /**
     * Get horsMinistere.
     *
     * @return string
     */
    public function getHorsMinistere()
    {
        return $this->horsMinistere;
    }

    /**
     * Set priorite.
     *
     * @param int $priorite
     *
     * @return MobiliteExterne
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

    /**
     * Set ministere.
     *
     * @param \AppBundle\Entity\Ministere $ministere
     *
     * @return MobiliteExterne
     */
    public function setMinistere(\AppBundle\Entity\Ministere $ministere = null)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return \AppBundle\Entity\Ministere
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return MobiliteExterne
     */
    public function setCrep(\AppBundle\Entity\Crep $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep
     */
    public function getCrep()
    {
        return $this->crep;
    }

    public function __toString()
    {
        return 'Mobilité externe';
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->choix) {
            if (!$this->ministere && !$this->horsMinistere) {
                $context->buildViolation('Veuillez préciser votre souhait de mobilité.')->atPath('ministere')->addViolation();

                $context->buildViolation('')->atPath('horsMinistere')->addViolation();

                $context->buildViolation('')->atPath('priorite')->addViolation();
            }
        }
    }

    public function getAnneeDepart()
    {
        return $this->anneeDepart;
    }

    public function setAnneeDepart($anneeDepart)
    {
        $this->anneeDepart = $anneeDepart;

        return $this;
    }
}
