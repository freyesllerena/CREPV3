<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02Formation.
 *
 * @ORM\Table(name="crep_mcc02_formation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02FormationRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMcc02Formation extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $commentaires;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $formationSuivie;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $demandeeAgent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $avisShd;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $propositionAh;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $cpf;

    /**
     * @var bool
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 2000,
     *      max = 2050,
     *      minMessage = "Valeur non valide.",
     *      maxMessage = "Valeur non valide."
     *
     * )
     */
    protected $echeance;

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return CrepMcc02Formation
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
     * Set commentaires.
     *
     * @param string $commentaires
     *
     * @return CrepMcc02Formation
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires.
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set formationSuivie.
     *
     * @param bool $formationSuivie
     *
     * @return CrepMcc02Formation
     */
    public function setFormationSuivie($formationSuivie)
    {
        $this->formationSuivie = $formationSuivie;

        return $this;
    }

    /**
     * Get formationSuivie.
     *
     * @return bool
     */
    public function getFormationSuivie()
    {
        return $this->formationSuivie;
    }

    /**
     * Set demandeeAgent.
     *
     * @param bool $demandeeAgent
     *
     * @return CrepMcc02Formation
     */
    public function setDemandeeAgent($demandeeAgent)
    {
        $this->demandeeAgent = $demandeeAgent;

        return $this;
    }

    /**
     * Get demandeeAgent.
     *
     * @return bool
     */
    public function getDemandeeAgent()
    {
        return $this->demandeeAgent;
    }

    /**
     * Set avisShd.
     *
     * @param bool $avisShd
     *
     * @return CrepMcc02Formation
     */
    public function setAvisShd($avisShd)
    {
        $this->avisShd = $avisShd;

        return $this;
    }

    /**
     * Get avisShd.
     *
     * @return bool
     */
    public function getAvisShd()
    {
        return $this->avisShd;
    }

    /**
     * Set propositionAh.
     *
     * @param bool $propositionAh
     *
     * @return CrepMcc02Formation
     */
    public function setPropositionAh($propositionAh)
    {
        $this->propositionAh = $propositionAh;

        return $this;
    }

    /**
     * Get propositionAh.
     *
     * @return bool
     */
    public function getPropositionAh()
    {
        return $this->propositionAh;
    }

    /**
     * Set cpf.
     *
     * @param bool $cpf
     *
     * @return CrepMcc02Formation
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get cpf.
     *
     * @return bool
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set echeance.
     *
     * @param int $echeance
     *
     * @return CrepMcc02Formation
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * Get echeance.
     *
     * @return int
     */
    public function getEcheance()
    {
        return $this->echeance;
    }
}
