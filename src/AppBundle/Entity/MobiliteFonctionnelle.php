<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep\CrepMindef\CrepMindef;

/**
 * MobiliteFonctionnelle.
 *
 * @ORM\Table(name="mobilite_fonctionnelle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobiliteFonctionnelleRepository")
 */
class MobiliteFonctionnelle extends Souhait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $familleProfessionnelle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $filiere;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $priorite;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $anneeDepart;

    /**
     * @ORM\OneToOne(targetEntity="Crep", mappedBy="mobiliteFonctionnelle")
     */
    protected $crep;

    /**
     * Set familleProfessionnelle.
     *
     * @param string $familleProfessionnelle
     *
     * @return MobiliteFonctionnelle
     */
    public function setFamilleProfessionnelle($familleProfessionnelle)
    {
        $this->familleProfessionnelle = $familleProfessionnelle;

        return $this;
    }

    /**
     * Get familleProfessionnelle.
     *
     * @return string
     */
    public function getFamilleProfessionnelle()
    {
        return $this->familleProfessionnelle;
    }

    /**
     * Set filiere.
     *
     * @param string $filiere
     *
     * @return MobiliteFonctionnelle
     */
    public function setFiliere($filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Get filiere.
     *
     * @return string
     */
    public function getFiliere()
    {
        return $this->filiere;
    }

    /**
     * Set priorite.
     *
     * @param int $priorite
     *
     * @return MobiliteFonctionnelle
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
     * @return MobiliteFonctionnelle
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
        return 'Mobilité fonctionnelle';
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->choix) {
            if ($this->crep instanceof CrepMindef) {
                if (!$this->familleProfessionnelle && !$this->filiere) {
                    $context->buildViolation('Veuillez préciser votre souhait de mobilité.')
                             ->atPath('familleProfessionnelle')
                            ->addViolation();

                    $context->buildViolation('Veuillez préciser la filière.')
                    ->atPath('filiere')
                    ->addViolation();

                    $context->buildViolation('Veuillez préciser la priorité.')
                    ->atPath('priorite')
                    ->addViolation();
                }
            } elseif ($this->crep instanceof CrepMindef01) {
                if (!$this->familleProfessionnelle && !$this->anneeDepart) {
                    $context->buildViolation('Veuillez préciser votre souhait de mobilité.')
                    ->atPath('familleProfessionnelle')
                    ->addViolation();

                    $context->buildViolation('')
                    ->atPath('anneeDepart')
                    ->addViolation();
                }
            }
        }
    }

    /**
     * Set anneeDepart.
     *
     * @param string $anneeDepart
     *
     * @return MobiliteFonctionnelle
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
