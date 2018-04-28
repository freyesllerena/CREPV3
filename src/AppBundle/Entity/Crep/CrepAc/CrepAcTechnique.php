<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepAcTechnique.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcTechniqueRepository")
 */
class CrepAcTechnique
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauAcquis", type="integer", nullable=true)
     */
    private $niveauAcquis;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="techniques")
     */
    protected $crepAc;

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
    protected $observations;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set niveauAcquis.
     *
     * @param int $niveauAcquis
     *
     * @return Technique
     */
    public function setNiveauAcquis($niveauAcquis)
    {
        $this->niveauAcquis = $niveauAcquis;

        return $this;
    }

    /**
     * Get niveauAcquis.
     *
     * @return int
     */
    public function getNiveauAcquis()
    {
        return $this->niveauAcquis;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Technique
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set crepAc.
     *
     * @param \AppBundle\Entity\CrepAc $crepAc
     *
     * @return Technique
     */
    public function setCrepAc(\AppBundle\Entity\CrepAc $crepAc = null)
    {
        $this->crepAc = $crepAc;

        return $this;
    }

    /**
     * Get crepAc.
     *
     * @return \AppBundle\Entity\CrepAc
     */
    public function getCrepAc()
    {
        return $this->crepAc;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
//         if($this->libelle === null && $this->niveauAcquis !== null){
//             $context->buildViolation("Le libellé est obligatoire")
//             ->atPath('libelle')
//             ->addViolation();
//         }

        if (null !== $this->libelle && null === $this->niveauAcquis) {
            $context->buildViolation('Le niveau est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }
}
