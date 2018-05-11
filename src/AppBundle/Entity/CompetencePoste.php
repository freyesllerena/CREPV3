<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CompetencePoste.
 *
 * @ORM\Table(name="competence_poste")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetencePosteRepository")
 */
class CompetencePoste extends Competence
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauRequis;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="competencesPostes")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "L'appréciation ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciation;

    /**
     * Set niveauRequis.
     *
     * @param int $niveauRequis
     *
     * @return CompetencePoste
     */
    public function setNiveauRequis($niveauRequis)
    {
        $this->niveauRequis = $niveauRequis;

        return $this;
    }

    /**
     * Get niveauRequis.
     *
     * @return int
     */
    public function getNiveauRequis()
    {
        return $this->niveauRequis;
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return CompetencePoste
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

    /**
     * @Assert\Callback(groups={'Default', 'CrepMso3SignerShd'})
     */
    public function validate(ExecutionContextInterface $context)
    {
        // Si un niveau a été choisi, le libellé de la compétence est obligatoire
        if (null === $this->libelle && (null !== $this->niveauAcquis || null !== $this->niveauRequis)) {
            $context->buildViolation('Le libellé est obligatoire')
                        ->atPath('libelle')
                        ->addViolation();
        }

        if (null === $this->niveauAcquis) {
            $context->buildViolation('Niveau acquis obligatoire')
                        ->atPath('niveauAcquis')
                        ->addViolation();
        }

        if (null === $this->niveauRequis && $this->crep instanceof CrepMindef) {
            $context->buildViolation('Niveau requis obligatoire')
                ->atPath('niveauRequis')
                ->addViolation();
        }
    }
}
