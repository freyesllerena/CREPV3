<?php

namespace AppBundle\Entity\Crep\CrepDgac;;

use AppBundle\Entity\DemandeFormation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CrepDgacFormationSuivie
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository
 * \CrepDgacFormationSuivieRepository")
 * @package AppBundle\Entity\Crep\CrepDgac
 */
class CrepDgacFormationSuivie extends DemandeFormation
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepDgac", inversedBy="crepDgacFormationsSuivies")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param CrepDgac|null $crep
     *
     * @return $this
     */
    public function setCrep($crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepDgac\CrepDgac
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $satisfaction;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $utilisationFormation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     */
    protected $commentaireAgent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $utilisationDocumentation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     */
    protected $formationComplementaire;

    /**
     * @return mixed
     */
    public function getSatisfaction()
    {
        return $this->satisfaction;
    }

    /**
     * @param mixed $satisfaction
     */
    public function setSatisfaction($satisfaction)
    {
        $this->satisfaction = $satisfaction;
    }

    /**
     * @return bool
     */
    public function isUtilisationFormation()
    {
        return $this->utilisationFormation;
    }

    /**
     * @param bool $utilisationFormation
     */
    public function setUtilisationFormation($utilisationFormation)
    {
        $this->utilisationFormation = $utilisationFormation;
    }

    /**
     * @return string
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    public function getCommentaireAgent()
    {
        return $this->commentaireAgent;
    }

    /**
     * @param string $commentaireAgent
     */
    public function setCommentaireAgent($commentaireAgent)
    {
        $this->commentaireAgent = $commentaireAgent;
    }

    /**
     * @return bool
     */
    public function isUtilisationDocumentation()
    {
        return $this->utilisationDocumentation;
    }

    /**
     * @param bool $utilisationDocumentation
     */
    public function setUtilisationDocumentation($utilisationDocumentation)
    {
        $this->utilisationDocumentation = $utilisationDocumentation;
    }

    /**
     * @return string
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    public function getFormationComplementaire()
    {
        return $this->formationComplementaire;
    }

    /**
     * @param string $formationComplementaire
     */
    public function setFormationComplementaire($formationComplementaire)
    {
        $this->formationComplementaire = $formationComplementaire;
    }

}
