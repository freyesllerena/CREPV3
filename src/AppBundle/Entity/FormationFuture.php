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
     * Libellé de la formation
     *
     * @var string
     *
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     * 
     */
    protected $libelle;

    /**
     * Confirmation si la demande de formation est effectuée par l'agent
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $demandeAgent;

    /**
     * Confiramtion si la demande de formatin est effectuée par le shd
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $demandeShd;

    /**
     * Confirmation si la demande de formation est effectuée par l'administration
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $demandeAdministration;

    /**
     * Durée en jours ou autres de la formation
     *
     * @var int
     * @ORM\Column(type="string")
     */
    protected $duree;

    /**
     * Code de la formation
     *
     * @var string
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * Année de la formation
     *
     * @var string
     * @ORM\Column(type="string")
     */
    protected $annee;

    /**
     * échéance de la formation
     *
     * @var string
     * @ORM\Column(type="string")
     */
    protected $echeance;

    /**
     * Objectif de la formation
     *
     * @var string
     * @ORM\Column(type="text")
     */
    protected $objetif;

    /**
     * Avis favorable ou non du Shd
     *
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $avisShd;

    /**
     * Confirmation si la formation est liée aux objectifs du service
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $lieeObjectifsService;

    /**
     * Confirmation si la formation est suivie
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $suivie;

    /**
     * Motif du refus de la formation
     *
     * @var string
     * @ORM\Column(type="text")
     */
    protected $motifNonSuivie;

    /**
     * Motif du refus du shd
     *
     * @var string
     * @ORM\Column(type="text")
     */
    protected $motifAvisShdDefavorable;

    /**
     * Confirmation si la formation est liée aux objectifs
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $lieeObjectifs;

    /**
     * @ORM\ManyToOne(targetEntity="Crep", inversedBy="formationsFutures")
     */
    protected $crep;

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
    public function isDemandeAgent()
    {
        return $this->demandeAgent;
    }

    /**
     * @param $demandeAgent
     * @return $this
     */
    public function setDemandeAgent($demandeAgent)
    {
        $this->demandeAgent = $demandeAgent;

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
     * @return mixed
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * @param $crep
     * @return $this
     */
    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }
}
