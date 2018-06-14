<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormationFuture
 *
 * @ORM\Table(name="formation_future")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationFutureRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class FormationFuture extends GenericEntity
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
     * Confiramtion si la demande de formatin est effectuée par le shd
     *
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $demandeShd;

    /**
     * Confirmation si la demande de formation est effectuée par l'administration
     *
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $demandeAdministration;

    /**
     * Durée en jours ou autres de la formation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $duree;

    /**
     * Code de la formation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $code;

    /**
     * Année de la formation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $annee;

    /**
     * Echèance de la formation
     *
     * @ORM\Column(type="string", nullable=true)
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
     * Objectif de la formation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $objetif;

    /**
     * Avis favorable ou non du Shd
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $avisShd;

    /**
     * Confirmation si la formation est liée aux objectifs du service
     *
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $lieeObjectifsService;

    /**
     * Confirmation si la formation est suivie
     *
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $suivie;

    /**
     * Motif du refus de la formation
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $motifNonSuivie;

    /**
     * Motif du refus du shd
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $motifAvisShdDefavorable;

    /**
     * Confirmation si la formation est liée aux objectifs
     *
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $lieeObjectifs;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
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
    protected $propositionAh;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $cpf;

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param $libelle
     * @return $this
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDemandeShd()
    {
        return $this->demandeShd;
    }

    /**
     * @param $demandeShd
     * @return $this
     */
    public function setDemandeShd($demandeShd)
    {
        $this->demandeShd = $demandeShd;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDemandeAdministration()
    {
        return $this->demandeAdministration;
    }

    /**
     * @param $demandeAdministration
     * @return $this
     */
    public function setDemandeAdministration($demandeAdministration)
    {
        $this->demandeAdministration = $demandeAdministration;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param $duree
     * @return $this
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param $annee
     * @return $this
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return string
     */
    public function getEcheance()
    {
        return $this->echeance;
    }

    /**
     * @param $echeance
     * @return $this
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjetif()
    {
        return $this->objetif;
    }

    /**
     * @param $objetif
     * @return $this
     */
    public function setObjetif($objetif)
    {
        $this->objetif = $objetif;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvisShd()
    {
        return $this->avisShd;
    }

    /**
     * @param $avisShd
     * @return $this
     */
    public function setAvisShd($avisShd)
    {
        $this->avisShd = $avisShd;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLieeObjectifsService()
    {
        return $this->lieeObjectifsService;
    }

    /**
     * @param $lieeObjectifsService
     * @return $this
     */
    public function setLieeObjectifsService($lieeObjectifsService)
    {
        $this->lieeObjectifsService = $lieeObjectifsService;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuivie()
    {
        return $this->suivie;
    }

    /**
     * @param $suivie
     * @return $this
     */
    public function setSuivie($suivie)
    {
        $this->suivie = $suivie;

        return $this;
    }

    /**
     * @return string
     */
    public function getMotifNonSuivie()
    {
        return $this->motifNonSuivie;
    }

    /**
     * @param $motifNonSuivie
     * @return $this
     */
    public function setMotifNonSuivie($motifNonSuivie)
    {
        $this->motifNonSuivie = $motifNonSuivie;

        return $this;
    }

    /**
     * @return string
     */
    public function getMotifAvisShdDefavorable()
    {
        return $this->motifAvisShdDefavorable;
    }

    /**
     * @param $motifAvisShdDefavorable
     * @return $this
     */
    public function setMotifAvisShdDefavorable($motifAvisShdDefavorable)
    {
        $this->motifAvisShdDefavorable = $motifAvisShdDefavorable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLieeObjectifs()
    {
        return $this->lieeObjectifs;
    }

    /**
     * @param $lieeObjectifs
     * @return $this
     */
    public function setLieeObjectifs($lieeObjectifs)
    {
        $this->lieeObjectifs = $lieeObjectifs;

        return $this;
    }

    /**
     * Set commentaires.
     *
     * @param string $commentaires
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * Set propositionAh.
     *
     * @param bool $propositionAh
     *
     * @return $this
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
     * @return $this
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
}
