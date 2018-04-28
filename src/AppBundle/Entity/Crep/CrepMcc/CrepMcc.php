<?php

namespace AppBundle\Entity\Crep\CrepMcc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;

/**
 * CrepMcc.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMcc")
 * @ORM\HasLifecycleCallbacks()
 */
class CrepMcc extends Crep
{
    public static $echelleObjectifEvalue = [
            'Atteint' => 1,
            'Partiellement Atteint' => 2,
            'Non atteint' => 3,
            'Devenu sans objet' => 4,
    ];

    public static $typologieFormations = [
            "Demande de l'agent-e (*)",
            'Avis du-de la responsable hiérarchique (*)',
            'Demande au regard des objectifs du service',
            "Préciser l'objectif individuel visé",
            'Recours au CPF',
    ];

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomPatronymique;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $affectation;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom d'usage obligatoire")
     * @ORM\Column(type="string", nullable=false)
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomUsage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $direction;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Prénom obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $service;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $bureau;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $titulaire;

    /**
     * @var string
     *
     * @ORM\Column(name="corps", type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $corps;

    /**
     * @ORM\Column(type="date", nullable = true)
     *
     * @Assert\Date(message = "Date d'entrée dans le corps non valide")
     */
    protected $dateEntreeCorps;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $grade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable = true)
     *
     * @Assert\Date(message = "Date d'entrée dans le grade non valide")
     */
    protected $dateEntreeGrade;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     *
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $echelon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable = true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntreeEchelon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable = true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntreeMinistere;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $contrat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable = true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateDebutContrat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $intitulePoste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $groupeRifseep;

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
    protected $descriptionPosteMission;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable = true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntreePoste;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_objectifs_passes")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsObjectifsPasses;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEncadres;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsAEvaluer;

    /**
     * @var int
     *
     * @ORM\Column(name="NB_AGENTS_EVALUES_AN_PREC", type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEvaluesAnneePrec;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $avisCriteresAppreciations;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $appreciationsManiereServir;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $acquisExperiencePro;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 8192,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $actionsFormationFormateur;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 8192,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $objectifsCollectifsService;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 8192,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $contextePrevisibleAnnee;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $evolutionPosteActuel;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $mobilite;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "comm_agent_sur_entretien")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $commentaireAgentSurEntretien;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "com_agent_carriere_mobilite")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $commentaireAgentCarriereMobilite;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     *
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $dureeEntretien;

    /**
     * @var string
     *
     * @ORM\Column(type="integer")
     */
    protected $attributionPartVariable;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "avis_attr_part_variable")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $avisAttributionPartVariable;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $avancement;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $explicationAvancement;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $attributionCia;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "explication_attr_cia")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $explicationAttributionCia;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $avancementGrade;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      max = 90,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $gradeConcerne;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $avisSurAvancementGrade;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "explication_avance_grade")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $explicationAvancementGrade;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $avancementCorps;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(
     *      max = 90,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $corpsConcerne;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $avisSurAvancementCorps;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name = "explication_avance_corps")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $explicationAvancementCorps;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAgentNotif;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $qualiteShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\Length(
     *      max = 230,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $qualiteAh;

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
    protected $observationsNotifAgent;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccCritereAppreciation", mappedBy="crepMcc", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $criteresAppreciations;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccRespEncadrement", mappedBy="crepMcc", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $responsabilitesEncadrements;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccFormationAdapatationPoste", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAdaptationPosteTravail;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccFormationMetier", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsEvolutionMetiers;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccFormationDevQualif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsDevQualifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccFormationPrepaConcours", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsPrepaConcoursExamens;

    /**
     * @ORM\OneToMany(targetEntity="CrepMccFormationAutresActions", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAutresActions;

    public function __construct()
    {
        parent::init();
        $this->criteresAppreciations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->responsabilitesEncadrements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAdaptationPosteTravail = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsEvolutionMetiers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsDevQualifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsPrepaConcoursExamens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAutresActions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNomPatronymique()
    {
        return $this->nomPatronymique;
    }

    public function setNomPatronymique($nomPatronymique)
    {
        $this->nomPatronymique = $nomPatronymique;

        return $this;
    }

    public function getAffectation()
    {
        return $this->affectation;
    }

    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    public function getBureau()
    {
        return $this->bureau;
    }

    public function setBureau($bureau)
    {
        $this->bureau = $bureau;

        return $this;
    }

    public function getTitulaire()
    {
        return $this->titulaire;
    }

    public function setTitulaire($titulaire)
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    public function getCorps()
    {
        return $this->corps;
    }

    public function setCorps($corps)
    {
        $this->corps = $corps;

        return $this;
    }

    public function getDateEntreeCorps()
    {
        return $this->dateEntreeCorps;
    }

    public function setDateEntreeCorps(\DateTime $dateEntreeCorps = null)
    {
        $this->dateEntreeCorps = $dateEntreeCorps;

        return $this;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    public function getDateEntreeGrade()
    {
        return $this->dateEntreeGrade;
    }

    public function setDateEntreeGrade(\DateTime $dateEntreeGrade = null)
    {
        $this->dateEntreeGrade = $dateEntreeGrade;

        return $this;
    }

    public function getEchelon()
    {
        return $this->echelon;
    }

    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    public function getDateEntreeEchelon()
    {
        return $this->dateEntreeEchelon;
    }

    public function setDateEntreeEchelon(\DateTime $dateEntreeEchelon = null)
    {
        $this->dateEntreeEchelon = $dateEntreeEchelon;

        return $this;
    }

    public function getDateEntreeMinistere()
    {
        return $this->dateEntreeMinistere;
    }

    public function setDateEntreeMinistere(\DateTime $dateEntreeMinistere = null)
    {
        $this->dateEntreeMinistere = $dateEntreeMinistere;

        return $this;
    }

    public function getContrat()
    {
        return $this->contrat;
    }

    public function setContrat($contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getDateDebutContrat()
    {
        return $this->dateDebutContrat;
    }

    public function setDateDebutContrat(\DateTime $dateDebutContrat = null)
    {
        $this->dateDebutContrat = $dateDebutContrat;

        return $this;
    }

    public function getIntitulePoste()
    {
        return $this->intitulePoste;
    }

    public function setIntitulePoste($intitulePoste)
    {
        $this->intitulePoste = $intitulePoste;

        return $this;
    }

    public function getGroupeRifseep()
    {
        return $this->groupeRifseep;
    }

    public function setGroupeRifseep($GroupeRifseep)
    {
        $this->groupeRifseep = $GroupeRifseep;

        return $this;
    }

    public function getDescriptionPosteMission()
    {
        return $this->descriptionPosteMission;
    }

    public function setDescriptionPosteMission($descriptionPosteMission)
    {
        $this->descriptionPosteMission = $descriptionPosteMission;

        return $this;
    }

    public function getDateEntreePoste()
    {
        return $this->dateEntreePoste;
    }

    public function setDateEntreePoste(\DateTime $dateEntreePoste = null)
    {
        $this->dateEntreePoste = $dateEntreePoste;

        return $this;
    }

    public function getObservationsObjectifsPasses()
    {
        return $this->observationsObjectifsPasses;
    }

    public function setObservationsObjectifsPasses($observationsObjectifsPasses)
    {
        $this->observationsObjectifsPasses = $observationsObjectifsPasses;

        return $this;
    }

    public function getNbAgentsEncadres()
    {
        return $this->nbAgentsEncadres;
    }

    public function setNbAgentsEncadres($nbAgentsEncadres)
    {
        $this->nbAgentsEncadres = $nbAgentsEncadres;

        return $this;
    }

    public function getNbAgentsAEvaluer()
    {
        return $this->nbAgentsAEvaluer;
    }

    public function setNbAgentsAEvaluer($nbAgentsAEvaluer)
    {
        $this->nbAgentsAEvaluer = $nbAgentsAEvaluer;

        return $this;
    }

    public function getNbAgentsEvaluesAnneePrec()
    {
        return $this->nbAgentsEvaluesAnneePrec;
    }

    public function setNbAgentsEvaluesAnneePrec($nbAgentsEvaluesAnneePrec)
    {
        $this->nbAgentsEvaluesAnneePrec = $nbAgentsEvaluesAnneePrec;

        return $this;
    }

    public function getAvisCriteresAppreciations()
    {
        return $this->avisCriteresAppreciations;
    }

    public function setAvisCriteresAppreciations($avisCriteresAppreciations)
    {
        $this->avisCriteresAppreciations = $avisCriteresAppreciations;

        return $this;
    }

    public function getAppreciationsManiereServir()
    {
        return $this->appreciationsManiereServir;
    }

    public function setAppreciationsManiereServir($appreciationsManiereServir)
    {
        $this->appreciationsManiereServir = $appreciationsManiereServir;

        return $this;
    }

    public function getAcquisExperiencePro()
    {
        return $this->acquisExperiencePro;
    }

    public function setAcquisExperiencePro($acquisExperiencePro)
    {
        $this->acquisExperiencePro = $acquisExperiencePro;

        return $this;
    }

    public function getActionsFormationFormateur()
    {
        return $this->actionsFormationFormateur;
    }

    public function setActionsFormationFormateur($actionsFormationFormateur)
    {
        $this->actionsFormationFormateur = $actionsFormationFormateur;

        return $this;
    }

    public function getObjectifsCollectifsService()
    {
        return $this->objectifsCollectifsService;
    }

    public function setObjectifsCollectifsService($objectifsCollectifsService)
    {
        $this->objectifsCollectifsService = $objectifsCollectifsService;

        return $this;
    }

    public function getContextePrevisibleAnnee()
    {
        return $this->contextePrevisibleAnnee;
    }

    public function setContextePrevisibleAnnee($contextePrevisibleAnnee)
    {
        $this->contextePrevisibleAnnee = $contextePrevisibleAnnee;

        return $this;
    }

    public function getEvolutionPosteActuel()
    {
        return $this->evolutionPosteActuel;
    }

    public function setEvolutionPosteActuel($evolutionPosteActuel)
    {
        $this->evolutionPosteActuel = $evolutionPosteActuel;

        return $this;
    }

    public function getMobilite()
    {
        return $this->mobilite;
    }

    public function setMobilite($mobilite)
    {
        $this->mobilite = $mobilite;

        return $this;
    }

    public function getCommentaireAgentSurEntretien()
    {
        return $this->commentaireAgentSurEntretien;
    }

    public function setCommentaireAgentSurEntretien($commentaireAgentSurEntretien)
    {
        $this->commentaireAgentSurEntretien = $commentaireAgentSurEntretien;

        return $this;
    }

    public function getCommentaireAgentCarriereMobilite()
    {
        return $this->commentaireAgentCarriereMobilite;
    }

    public function setCommentaireAgentCarriereMobilite($commentaireAgentCarriereMobilite)
    {
        $this->commentaireAgentCarriereMobilite = $commentaireAgentCarriereMobilite;

        return $this;
    }

    public function getDureeEntretien()
    {
        return $this->dureeEntretien;
    }

    public function setDureeEntretien($dureeEntretien)
    {
        $this->dureeEntretien = $dureeEntretien;

        return $this;
    }

    public function getAttributionPartVariable()
    {
        return $this->attributionPartVariable;
    }

    public function setAttributionPartVariable($attributionPartVariable)
    {
        $this->attributionPartVariable = $attributionPartVariable;

        return $this;
    }

    public function getAvisAttributionPartVariable()
    {
        return $this->avisAttributionPartVariable;
    }

    public function setAvisAttributionPartVariable($avisAttributionPartVariable)
    {
        $this->avisAttributionPartVariable = $avisAttributionPartVariable;

        return $this;
    }

    public function getAvancement()
    {
        return $this->avancement;
    }

    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;

        return $this;
    }

    public function getExplicationAvancement()
    {
        return $this->explicationAvancement;
    }

    public function setExplicationAvancement($explicationAvancement)
    {
        $this->explicationAvancement = $explicationAvancement;

        return $this;
    }

    public function getAttributionCia()
    {
        return $this->attributionCia;
    }

    public function setAttributionCia($attributionCia)
    {
        $this->attributionCia = $attributionCia;

        return $this;
    }

    public function getExplicationAttributionCia()
    {
        return $this->explicationAttributionCia;
    }

    public function setExplicationAttributionCia($explicationAttributionCia)
    {
        $this->explicationAttributionCia = $explicationAttributionCia;

        return $this;
    }

    public function getAvancementGrade()
    {
        return $this->avancementGrade;
    }

    public function setAvancementGrade($avancementGrade)
    {
        $this->avancementGrade = $avancementGrade;

        return $this;
    }

    public function getGradeConcerne()
    {
        return $this->gradeConcerne;
    }

    public function setGradeConcerne($gradeConcerne)
    {
        $this->gradeConcerne = $gradeConcerne;

        return $this;
    }

    public function getAvisSurAvancementGrade()
    {
        return $this->avisSurAvancementGrade;
    }

    public function setAvisSurAvancementGrade($avisSurAvancementGrade)
    {
        $this->avisSurAvancementGrade = $avisSurAvancementGrade;

        return $this;
    }

    public function getExplicationAvancementGrade()
    {
        return $this->explicationAvancementGrade;
    }

    public function setExplicationAvancementGrade($explicationAvancementGrade)
    {
        $this->explicationAvancementGrade = $explicationAvancementGrade;

        return $this;
    }

    public function getAvancementCorps()
    {
        return $this->avancementCorps;
    }

    public function setAvancementCorps($avancementCorps)
    {
        $this->avancementCorps = $avancementCorps;

        return $this;
    }

    public function getCorpsConcerne()
    {
        return $this->corpsConcerne;
    }

    public function setCorpsConcerne($corpsConcerne)
    {
        $this->corpsConcerne = $corpsConcerne;

        return $this;
    }

    public function getAvisSurAvancementCorps()
    {
        return $this->avisSurAvancementCorps;
    }

    public function setAvisSurAvancementCorps($avisSurAvancementCorps)
    {
        $this->avisSurAvancementCorps = $avisSurAvancementCorps;

        return $this;
    }

    public function getExplicationAvancementCorps()
    {
        return $this->explicationAvancementCorps;
    }

    public function setExplicationAvancementCorps($explicationAvancementCorps)
    {
        $this->explicationAvancementCorps = $explicationAvancementCorps;

        return $this;
    }

    public function getObservationsAgentNotif()
    {
        return $this->observationsAgentNotif;
    }

    public function setObservationsAgentNotif($observationsAgentNotif)
    {
        $this->observationsAgentNotif = $observationsAgentNotif;

        return $this;
    }

    /**
     * @return the text
     */
    public function getObservationsNotifAgent()
    {
        return $this->observationsNotifAgent;
    }

    /**
     * @param
     *            $observationsNotifAgent
     */
    public function setObservationsNotifAgent($observationsNotifAgent)
    {
        $this->observationsNotifAgent = $observationsNotifAgent;

        return $this;
    }

    /**
     * Add formationsAdaptationPosteTravail.
     *
     * @param CrepMccFormationAVenir $formationsAdaptationPosteTravail
     *
     * @return CrepMcc
     */
    public function addFormationsAdaptationPosteTravail(CrepMccFormationAVenir $formationsAdaptationPosteTravail)
    {
        $this->formationsAdaptationPosteTravail[] = $formationsAdaptationPosteTravail;
        $formationsAdaptationPosteTravail->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAdaptationPosteTravail.
     *
     * @param CrepMccFormationAVenir $formationsAdaptationPosteTravail
     */
    public function removeFormationsAdaptationPosteTravail(CrepMccFormationAVenir $formationsAdaptationPosteTravail)
    {
        $this->formationsAdaptationPosteTravail->removeElement($formationsAdaptationPosteTravail);
        $formationsAdaptationPosteTravail->setCrep(null);
    }

    /**
     * Add formationsAutresAction.
     *
     * @param CrepMccFormationAVenir $formationAutreAction
     *
     * @return CrepMcc
     */
    public function addFormationsAutresAction(CrepMccFormationAVenir $formationAutreAction)
    {
        $this->formationsAutresActions[] = $formationAutreAction;
        $formationAutreAction->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAutresAction.
     *
     * @param CrepMccFormationAVenir $formationAutreAction
     */
    public function removeFormationsAutresAction(CrepMccFormationAVenir $formationAutreAction)
    {
        $this->formationsAutresActions->removeElement($formationAutreAction);
        $formationAutreAction->setCrep(null);
    }

    /**
     * Add formationsPrepaConcoursExamen.
     *
     * @param CrepMccFormationAVenir $formationPrepaConcoursExamen
     *
     * @return CrepMcc
     */
    public function addFormationsPrepaConcoursExamen(CrepMccFormationAVenir $formationPrepaConcoursExamen)
    {
        $this->formationsPrepaConcoursExamens[] = $formationPrepaConcoursExamen;
        $formationPrepaConcoursExamen->setCrep($this);

        return $this;
    }

    /**
     * Remove formationPrepaConcoursExamen.
     *
     * @param CrepMccFormationAVenir $formationPrepaConcoursExamen
     */
    public function removeFormationsPrepaConcoursExamen(CrepMccFormationAVenir $formationPrepaConcoursExamen)
    {
        $this->formationsPrepaConcoursExamens->removeElement($formationPrepaConcoursExamen);
        $formationPrepaConcoursExamen->setCrep(null);
    }

    /**
     * Add formationDevQualif.
     *
     * @param CrepMccFormationAVenir $formationDevQualif
     *
     * @return CrepMcc
     */
    public function addFormationsDevQualif(CrepMccFormationAVenir $formationDevQualif)
    {
        $this->formationsDevQualifs[] = $formationDevQualif;
        $formationDevQualif->setCrep($this);

        return $this;
    }

    /**
     * Remove formationDevQualif.
     *
     * @param CrepMccFormationAVenir $formationDevQualif
     */
    public function removeFormationsDevQualif(CrepMccFormationAVenir $formationDevQualif)
    {
        $this->formationsDevQualifs->removeElement($formationDevQualif);
        $formationDevQualif->setCrep(null);
    }

    /**
     * Add formationsEvolutionMetier.
     *
     * @param CrepMccFormationAVenir $formationsEvolutionMetier
     *
     * @return CrepMcc
     */
    public function addFormationsEvolutionMetier(CrepMccFormationAVenir $formationsEvolutionMetier)
    {
        $this->formationsEvolutionMetiers[] = $formationsEvolutionMetier;
        $formationsEvolutionMetier->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsEvolutionMetier.
     *
     * @param CrepMccFormationAVenir $formationsEvolutionMetier
     */
    public function removeFormationsEvolutionMetier(CrepMccFormationAVenir $formationsEvolutionMetier)
    {
        $this->formationsEvolutionMetiers->removeElement($formationsEvolutionMetier);
        $formationsEvolutionMetier->setCrep(null);
    }

    public function getFormationsAdaptationPosteTravail()
    {
        return $this->formationsAdaptationPosteTravail;
    }

    public function getFormationsEvolutionMetiers()
    {
        return $this->formationsEvolutionMetiers;
    }

    public function getFormationsDevQualifs()
    {
        return $this->formationsDevQualifs;
    }

    public function getFormationsPrepaConcoursExamens()
    {
        return $this->formationsPrepaConcoursExamens;
    }

    public function getFormationsAutresActions()
    {
        return $this->formationsAutresActions;
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);
        $this->setNomPatronymique($agent->getNomNaissance());
        $this->setNomUsage($agent->getNom());
        $this->setPrenom($agent->getPrenom());

        $this->setAffectation($agent->getAffectationClairAgent());
        $this->setDirection($agent->getEtablissement());
        $this->setCorps($agent->getCorps());
        $this->setDateEntreeCorps($agent->getDateEntreeCorps());
        $this->setGrade($agent->getGrade());
        $this->setDateEntreeGrade($agent->getDateEntreeGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDateEntreeEchelon($agent->getDateEntreeEchelon());
        $this->setIntitulePoste($agent->getPosteOccupe());
        $this->setDateEntreePoste($agent->getDateEntreePosteOccupe());

        $this->setTitulaire($agent->isTitulaire());

        if ('cdd' == Util::twig_lower($agent->getContrat())) {
            $contrat = 0;
        } elseif ('cdi' == Util::twig_lower($agent->getContrat())) {
            $contrat = 1;
        } else {
            $contrat = $agent->getContrat();
        }

        $this->setContrat($contrat);

        $this->setDateDebutContrat($agent->getDateDebutContrat());
        $this->setDateEntreeMinistere($agent->getDateEntreeMinistere());

        $competencesTransverses = $em->getRepository('AppBundle:CompetenceTransverse')->findByModeleCrep(Util::getClassName($this));

        foreach ($competencesTransverses as $competenceTransverse) {
            switch ($competenceTransverse->getTypeCompetence()) {
                case "Critères d'appréciation":
                    $critereAppreciation = new CrepMccCritereAppreciation();
                    $critereAppreciation->setCompetenceTransverse($competenceTransverse);
                    $this->addCriteresAppreciation($critereAppreciation);
                    break;

                case "Responsabilité d'encadrement":
                    $respEncadrement = new CrepMccRespEncadrement();
                    $respEncadrement->setCompetenceTransverse($competenceTransverse);
                    $this->addResponsabilitesEncadrement($respEncadrement);
                    break;
            }
        }
    }

    public function confidentialisationChampsShd()
    {
        $this->setDescriptionPosteMission(null);
        $this->getObjectifsEvalues()->clear();
        $this->setObservationsObjectifsPasses(null);
        foreach ($this->getCriteresAppreciations() as $critereAppreciation) {
            $critereAppreciation->setNiveauAcquis(null);
        }
        foreach ($this->getResponsabilitesEncadrements() as $responsabiliteEncadrement) {
            $responsabiliteEncadrement->setNiveauAcquis(null);
        }
        $this->setNbAgentsEncadres(null);
        $this->setNbAgentsAEvaluer(null);
        $this->setNbAgentsEvaluesAnneePrec(null);
        $this->setAvisCriteresAppreciations(null);
        $this->setAppreciationsManiereServir(null);
        $this->setAcquisExperiencePro(null);
        $this->setActionsFormationFormateur(null);
        $this->setObjectifsCollectifsService(null);
        $this->setContextePrevisibleAnnee(null);
        $this->getObjectifsFuturs()->clear();
        $this->setEvolutionPosteActuel(null);
        $this->setMobilite(null);
        $this->getFormationsSuivies()->clear();
        $this->getFormationsAdaptationPosteTravail()->clear();
        $this->getFormationsEvolutionMetiers()->clear();
        $this->getFormationsDevQualifs()->clear();
        $this->getFormationsPrepaConcoursExamens()->clear();
        $this->getFormationsAutresActions()->clear();
        $this->setDateEntretien(null);
        $this->setDureeEntretien(null);
        $this->setQualiteShd(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setCommentaireAgentSurEntretien(null);
        $this->setCommentaireAgentCarriereMobilite(null);
    }

    public function confidentialisationChampsAh()
    {
        $this->setAttributionCia(null);
        $this->setExplicationAttributionCia(null);
        $this->setAvancementGrade(null);
        $this->setGradeConcerne(null);
        $this->setAvisSurAvancementGrade(null);
        $this->setExplicationAvancementGrade(null);
        $this->setAvancementCorps(null);
        $this->setCorpsConcerne(null);
        $this->setAvisSurAvancementCorps(null);
        $this->setExplicationAvancementCorps(null);
        $this->setAttributionPartVariable(null);
        $this->setAvisAttributionPartVariable(null);
        $this->setAvancement(null);
        $this->setExplicationAvancement(null);
        $this->setQualiteAh(null);
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
        $this->setObservationsNotifAgent(null);
    }

    public function actualiserDonneesShd()
    {
        // Ce modèle de CREP ne contient aucun champs lié au N+1
    }

    /**
     * @Assert\Callback
     */
    public function validateCrepMcc(ExecutionContextInterface $context)
    {
        // Si le champ titulaire n'est pas renseigné, on affiche un message d'erreur
        if (null === $this->getTitulaire()) {
            $context->buildViolation('Champ obligatoire')
            ->atPath('titulaire')
            ->addViolation();
        }

        // Si une date d'entrée dans le corps est renseignée, il faut renseigner le corps aussi
        if (true == $this->titulaire && $this->getDateEntreeCorps() && !$this->getCorps()) {
            $context->buildViolation("Veuillez renseigner le corps associé à la date d'entrée saisie")
            ->atPath('corps')
            ->addViolation();
        }

        // Si une date d'entrée dans le grade est renseignée, il faut renseigner le grade aussi
        if (true == $this->titulaire && $this->getDateEntreeGrade() && !$this->getGrade()) {
            $context->buildViolation("Veuillez renseigner le grade associé à la date d'entrée saisie")
            ->atPath('grade')
            ->addViolation();
        }

        // Si une date d'entrée dans l'échelon est renseignée, il faut renseigner l'échelon aussi
        if (true == $this->titulaire && $this->getDateEntreeEchelon() && !$this->getEchelon()) {
            $context->buildViolation("Veuillez renseigner l'échelon associé à la date d'entrée saisie")
            ->atPath('echelon')
            ->addViolation();
        }

        // Si une date de début du contrat est renseignée, il faut renseigner le type aussi
        if (false == $this->titulaire && $this->getDateDebutContrat() && null === $this->getContrat()) {
            $context->buildViolation("Veuillez préciser le type du contrat associé à la date d'entrée saisie")
            ->atPath('contrat')
            ->addViolation();
        }
    }

    public function getQualiteShd()
    {
        return $this->qualiteShd;
    }

    public function setQualiteShd($qualiteShd)
    {
        $this->qualiteShd = $qualiteShd;

        return $this;
    }

    public function getQualiteAh()
    {
        return $this->qualiteAh;
    }

    public function setQualiteAh($qualiteAh)
    {
        $this->qualiteAh = $qualiteAh;

        return $this;
    }

    /**
     * Add criteresAppreciation.
     *
     * @param CrepMccCompetenceTransverse $criteresAppreciation
     *
     * @return CrepMcc
     */
    public function addCriteresAppreciation(CrepMccCompetenceTransverse $criteresAppreciation)
    {
        $this->criteresAppreciations[] = $criteresAppreciation;
        $criteresAppreciation->setCrepMcc($this);

        return $this;
    }

    /**
     * Remove criteresAppreciation.
     *
     * @param CrepMccCompetenceTransverse $criteresAppreciation
     */
    public function removeCriteresAppreciation(CrepMccCompetenceTransverse $criteresAppreciation)
    {
        $this->criteresAppreciations->removeElement($criteresAppreciation);
        $criteresAppreciation->setCrepMcc(null);
    }

    public function getCriteresAppreciations()
    {
        return $this->criteresAppreciations;
    }

    /**
     * Add responsabilitesEncadrement.
     *
     * @param CrepMccCompetenceTransverse $responsabilitesEncadrement
     *
     * @return CrepMcc
     */
    public function addResponsabilitesEncadrement(CrepMccCompetenceTransverse $responsabilitesEncadrement)
    {
        $this->responsabilitesEncadrements[] = $responsabilitesEncadrement;
        $responsabilitesEncadrement->setCrepMcc($this);

        return $this;
    }

    /**
     * Remove responsabilitesEncadrement.
     *
     * @param CrepMccCompetenceTransverse $responsabilitesEncadrement
     */
    public function removeResponsabilitesEncadrement(CrepMccCompetenceTransverse $responsabilitesEncadrement)
    {
        $this->responsabilitesEncadrements->removeElement($responsabilitesEncadrement);
        $responsabilitesEncadrement->setCrepMcc(null);
    }

    public function getResponsabilitesEncadrements()
    {
        return $this->responsabilitesEncadrements;
    }
}
