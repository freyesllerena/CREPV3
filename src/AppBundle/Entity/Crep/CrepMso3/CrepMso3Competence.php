<?php

namespace AppBundle\Entity\Crep\CrepMso3;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * CompetencePoste.
 *
 * @ORM\Table(name="crep_mso3_competence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMso3CompetenceRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMso3Competence extends GenericEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\NotBlank(message = "Champ obligatoire", groups={"EnregistrementShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveau = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $appreciation;

    public function __construct($libelle = null)
    {
        $this->libelle = $libelle;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return CrepMso3Competence
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
     * Set niveau.
     *
     * @param int $niveau
     *
     * @return CrepMso3Competence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau.
     *
     * @return int
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set appreciation.
     *
     * @param string $appreciation
     *
     * @return CrepMso3Competence
     */
    public function setAppreciation($appreciation)
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    /**
     * Get appreciation.
     *
     * @return string
     */
    public function getAppreciation()
    {
        return $this->appreciation;
    }

    /**
     * @Assert\Callback(groups={"EnregistrementShd"})
     */
    public function validateCrepMso3CompetenceNiveau(ExecutionContextInterface $context)
    {
        if (null !== $this->libelle && null === $this->niveau) {
            $context->buildViolation('Le niveau est obligatoire')
            ->atPath('libelle')
            ->addViolation();
        }
    }
}
