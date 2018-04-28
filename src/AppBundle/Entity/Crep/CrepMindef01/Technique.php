<?php

namespace AppBundle\Entity\Crep\CrepMindef01;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Technique.
 *
 * @ORM\Table(name="technique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TechniqueRepository")
 */
class Technique
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
     * @ORM\ManyToOne(targetEntity="CrepMindef01", inversedBy="techniques")
     */
    protected $crepMindef01;

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
     * Set crepMindef01.
     *
     * @param \AppBundle\Entity\CrepMindef01 $crepMindef01
     *
     * @return Technique
     */
    public function setCrepMindef01(\AppBundle\Entity\CrepMindef01 $crepMindef01 = null)
    {
        $this->crepMindef01 = $crepMindef01;

        return $this;
    }

    /**
     * Get crepMindef01.
     *
     * @return \AppBundle\Entity\CrepMindef01
     */
    public function getCrepMindef01()
    {
        return $this->crepMindef01;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (null !== $this->libelle && null === $this->niveauAcquis) {
            $context->buildViolation('Le niveau est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }
}
