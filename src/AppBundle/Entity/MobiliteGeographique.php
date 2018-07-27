<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep\CrepMindef\CrepMindef;
use AppBundle\Entity\Crep\CrepMindef01\CrepMindef01;

/**
 * MobiliteGeographique.
 *
 * @ORM\Table(name="mobilite_geographique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobiliteGeographiqueRepository")
 */
class MobiliteGeographique extends Souhait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $region;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $departement;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ville;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $priorite;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $anneeDepart;

    /**
     * @ORM\OneToOne(targetEntity="Crep", mappedBy="mobiliteGeographique")
     */
    protected $crep;

    /**
     * Set region.
     *
     * @param string $region
     *
     * @return MobiliteGeographique
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set departement.
     *
     * @param string $departement
     *
     * @return MobiliteGeographique
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement.
     *
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return MobiliteGeographique
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set priorite.
     *
     * @param int $priorite
     *
     * @return MobiliteGeographique
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
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return MobiliteGeographique
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
        return 'Mobilité géographique';
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->choix) {
            if ($this->crep instanceof CrepMindef) {
                if (!$this->region && !$this->departement && !$this->ville) {
                    $context->buildViolation('Veuillez préciser votre souhait de mobilité.')
                    ->atPath('region')
                    ->addViolation();

                    $context->buildViolation('')
                    ->atPath('departement')
                    ->addViolation();

                    $context->buildViolation('')
                    ->atPath('ville')
                    ->addViolation();

                    $context->buildViolation('')
                    ->atPath('priorite')
                    ->addViolation();
                }
            } elseif ($this->crep instanceof CrepMindef01) {
                if (!$this->anneeDepart) {
                    $context->buildViolation('Veuillez préciser votre souhait de mobilité.')
                    ->atPath('anneeDepart')
                    ->addViolation();
                }
            }
        }
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return MobiliteGeographique
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set anneeDepart.
     *
     * @param string $anneeDepart
     *
     * @return MobiliteGeographique
     */
    public function setAnneeDepart($anneeDepart)
    {
        $this->anneeDepart = $anneeDepart;

        return $this;
    }

    /**
     * Get anneeDepart.
     *
     * @return string
     */
    public function getAnneeDepart()
    {
        return $this->anneeDepart;
    }
}
