<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Entity\ObjectifEvalue;
use AppBundle\Entity\ObjectifFutur;

/**
 * CrepMj01.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository")
 */
class CrepMj01 extends Crep
{
    public static $echelleObjectifEvalue = [
            'Atteint' => 3,
            'Partiellement Atteint' => 2,
            'Non atteint' => 1,
            'Devenu sans objet' => 0,
    ];

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsage;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom de naissance obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom de naissance doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom de naissance ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissance;

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
     * @var \DateTime @ORM\Column(type="date")
     *
     * @Assert\Date(message = "Date non valide")
     *
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2999-12-31",
     *      minMessage = "Date non valide",
     *      maxMessage = "Date non valide"
     * )
     */
    protected $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $grade;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $corps;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(
     *    max = 30,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $echelon;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupe;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $service;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $affectation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable = true)
     * @Assert\Date(message = "Date non valide")
     *
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2999-12-31",
     *      minMessage = "Date non valide",
     *      maxMessage = "Date non valide"
     * )
     */
    protected $dateEntreePoste;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsageShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenomShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $affectationShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $serviceShd;

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
    protected $descriptionFonctions;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_shd_objectifs_evalues")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsShdObjectifsEvalues;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_objectifs_evalues")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAgentObjectifsEvalues;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01CompetenceProfessionnelle", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesProfessionnelles;

    /**
     * @var int
     * @ORM\Column(type="integer", name="marge_evol_comp_pro")
     */
    protected $margeEvolutionCompetencesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01AptitudeProfessionnelle", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $aptitudesProfessionnelles;

    /**
     * @var int
     * @ORM\Column(type="integer", name="marge_evol_aptitudes_pro")
     */
    protected $margeEvolutionAptitudesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01QualiteProfessionnelle", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $qualitesProfessionnelles;

    /**
     * @var int
     * @ORM\Column(type="integer", name="marge_evol_qualites_pro")
     */
    protected $margeEvolutionQualitesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01CapaciteEncadrement", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $capacitesEncadrements;

    /**
     * @var int
     * @ORM\Column(type="integer", name="marge_evol_capacite_encad")
     */
    protected $margeEvolutionCapacitesEncadrement;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $margeEvolutionGlobale;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $niveauPerformanceGlobale;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_pro")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesProfessionnelles;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_aptitudes_pro")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAptitudesesProfessionnelles;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_qualites_relationnelles")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsQualitesRelationnelles;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_capacites_encadrement")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCapacitesEncadrement;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsGlobale;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $noteAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Ce champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Ce champ ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $lieu; // Pour le champ " fait à ... "

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $objectifsService;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="perspectives_evol_service")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $perspectivesEvolutionService;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="perspectives_evol_fonction")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $perspectivesEvolutionFonction;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01FormationSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $crepMj01FormationsSuivies;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01FormationSollicitee", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsSollicitees;

    /**
     * @ORM\OneToMany(targetEntity="CrepMj01FormationEnvisagee", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsEnvisagees;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsShdFormation;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $connaissancesInstitution;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $connaissancesProfessionnelles;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $experienceEncadrement;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $capacitesDecisions;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="mobilite_fonct_ou_geo")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $mobiliteFonctionnelleOuGeographique;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_deroul_entretien")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAgentDeroulementEntretien;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_apprec_portees")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAgentAppreciationsPortees;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifAbsenceEntretien;

    public function __construct()
    {
        parent::init();
        // 		$this->competencesProfessionnelles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return the string
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     * @param $nomUsage
     *
     * @return CrepMj01
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * @return the string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param $lieu
     *
     * @return CrepMj01
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return the string
     */
    public function getNomNaissance()
    {
        return $this->nomNaissance;
    }

    /**
     * @param $nomNaissance
     *
     * @return CrepMj01
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    /**
     * @return the string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param $prenom
     *
     * @return CrepMj01
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return the DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     *
     * @return CrepMj01
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return the string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param $grade
     *
     * @return CrepMj01
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * @param $corps
     *
     * @return CrepMj01
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;

        return $this;
    }

    /**
     * @return the string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * @param $echelon
     *
     * @return CrepMj01
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * @return the string
     */
    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    /**
     * @param $posteOccupe
     */
    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;

        return $this;
    }

    /**
     * @return the string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param $service
     *
     * @return CrepMj01
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return the string
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * @param $affectation
     *
     * @return CrepMj01
     */
    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEntreePoste()
    {
        return $this->dateEntreePoste;
    }

    /**
     * @param $dateEntreePoste
     *
     * @return CrepMj01
     */
    public function setDateEntreePoste(\DateTime $dateEntreePoste = null)
    {
        $this->dateEntreePoste = $dateEntreePoste;

        return $this;
    }

    /**
     * @return the string
     */
    public function getNomUsageShd()
    {
        return $this->nomUsageShd;
    }

    /**
     * @param $nomUsageShd
     *
     * @return CrepMj01
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     * @param $prenomShd
     *
     * @return CrepMj01
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getAffectationShd()
    {
        return $this->affectationShd;
    }

    /**
     * @param $affectationShd
     *
     * @return CrepMj01
     */
    public function setAffectationShd($affectationShd)
    {
        $this->affectationShd = $affectationShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getPosteOccupeShd()
    {
        return $this->posteOccupeShd;
    }

    /**
     * @param $posteOccupeShd
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getServiceShd()
    {
        return $this->serviceShd;
    }

    /**
     * @param $serviceShd
     *
     * @return CrepMj01
     */
    public function setServiceShd($serviceShd)
    {
        $this->serviceShd = $serviceShd;

        return $this;
    }

    /**
     * @return the text
     */
    public function getDescriptionFonctions()
    {
        return $this->descriptionFonctions;
    }

    /**
     * @param
     *            $descriptionFonctions
     */
    public function setDescriptionFonctions($descriptionFonctions)
    {
        $this->descriptionFonctions = $descriptionFonctions;

        return $this;
    }

    /**
     * Get observationsShdObjectifsEvalues.
     *
     * @return string
     */
    public function getObservationsShdObjectifsEvalues()
    {
        return $this->observationsShdObjectifsEvalues;
    }

    /**
     * Set observationsShdObjectifsEvalues.
     *
     * @param string $observationsShdObjectifsEvalues
     *
     * @return CrepMj01
     */
    public function setObservationsShdObjectifsEvalues($observationsShdObjectifsEvalues)
    {
        $this->observationsShdObjectifsEvalues = $observationsShdObjectifsEvalues;

        return $this;
    }

    /**
     * Get observationsAgentObjectifsEvalues.
     *
     * @return string
     */
    public function getObservationsAgentObjectifsEvalues()
    {
        return $this->observationsAgentObjectifsEvalues;
    }

    /**
     * Set observationsAgentObjectifsEvalues.
     *
     * @param string $observationsAgentObjectifsEvalues
     *
     * @return CrepMj01
     */
    public function setObservationsAgentObjectifsEvalues($observationsAgentObjectifsEvalues)
    {
        $this->observationsAgentObjectifsEvalues = $observationsAgentObjectifsEvalues;

        return $this;
    }

    /**
     * Add competenceProfessionnelle.
     *
     * @param CrepMj01CompetenceProfessionnelle $competencesProfessionnelle
     *
     * @return CrepMj01
     */
    public function addCompetencesProfessionnelle(CrepMj01CompetenceProfessionnelle $competenceProfessionnelle)
    {
        $this->competencesProfessionnelles[] = $competenceProfessionnelle;
        $competenceProfessionnelle->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceProfessionnelle.
     *
     * @param CrepMj01CompetenceProfessionnelle $competenceProfessionnelle
     */
    public function removeCompetencesProfessionnelle(CrepMj01CompetenceProfessionnelle $competenceProfessionnelle)
    {
        $this->competencesProfessionnelles->removeElement($competenceProfessionnelle);
        $competenceProfessionnelle->setCrep(null);
    }

    /**
     * Get competencesProfessionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesProfessionnelles()
    {
        return $this->competencesProfessionnelles;
    }

    /**
     * Add aptitudeProfessionnelle.
     *
     * @param CrepMj01AptitudeProfessionnelle $aptitudeProfessionnelle
     *
     * @return CrepMj01
     */
    public function addAptitudesProfessionnelle(CrepMj01AptitudeProfessionnelle $aptitudeProfessionnelle)
    {
        $this->aptitudesProfessionnelles[] = $aptitudeProfessionnelle;
        $aptitudeProfessionnelle->setCrep($this);

        return $this;
    }

    /**
     * Remove aptitudeProfessionnelle.
     *
     * @param CrepMj01AptitudeProfessionnelle $aptitudeProfessionnelle
     */
    public function removeAptitudesProfessionnelle(CrepMj01AptitudeProfessionnelle $aptitudeProfessionnelle)
    {
        $this->aptitudesProfessionnelles->removeElement($aptitudeProfessionnelle);
        $aptitudeProfessionnelle->setCrep(null);
    }

    /**
     * Get aptitudesProfessionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAptitudesProfessionnelles()
    {
        return $this->aptitudesProfessionnelles;
    }

    /**
     * Add qualiteProfessionnelle.
     *
     * @param CrepMj01QualiteProfessionnelle $qualiteProfessionnelle
     *
     * @return CrepMj01
     */
    public function addQualitesProfessionnelle(CrepMj01QualiteProfessionnelle $qualiteProfessionnelle)
    {
        $this->qualitesProfessionnelles[] = $qualiteProfessionnelle;
        $qualiteProfessionnelle->setCrep($this);

        return $this;
    }

    /**
     * Remove qualiteProfessionnelle.
     *
     * @param CrepMj01QualiteProfessionnelle $qualiteProfessionnelle
     */
    public function removeQualitesProfessionnelle(CrepMj01QualiteProfessionnelle $qualiteProfessionnelle)
    {
        $this->qualitesProfessionnelles->removeElement($qualiteProfessionnelle);
        $qualiteProfessionnelle->setCrep(null);
    }

    /**
     * Get qualitesProfessionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualitesProfessionnelles()
    {
        return $this->qualitesProfessionnelles;
    }

    /**
     * @param $margeEvolutionCompetencesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setMargeEvolutionCompetencesProfessionnelles($margeEvolutionCompetencesProfessionnelles)
    {
        $this->margeEvolutionCompetencesProfessionnelles = $margeEvolutionCompetencesProfessionnelles;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getMargeEvolutionCompetencesProfessionnelles()
    {
        return $this->margeEvolutionCompetencesProfessionnelles;
    }

    /**
     * @param $margeEvolutionAptitudesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setMargeEvolutionAptitudesProfessionnelles($margeEvolutionAptitudesProfessionnelles)
    {
        $this->margeEvolutionAptitudesProfessionnelles = $margeEvolutionAptitudesProfessionnelles;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getMargeEvolutionAptitudesProfessionnelles()
    {
        return $this->margeEvolutionAptitudesProfessionnelles;
    }

    /**
     * @param $margeEvolutionQualitesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setMargeEvolutionQualitesProfessionnelles($margeEvolutionQualitesProfessionnelles)
    {
        $this->margeEvolutionQualitesProfessionnelles = $margeEvolutionQualitesProfessionnelles;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getMargeEvolutionQualitesProfessionnelles()
    {
        return $this->margeEvolutionQualitesProfessionnelles;
    }

    /**
     * Add capacitesEncadrement.
     *
     * @param CrepMj01CapaciteEncadrement $capaciteEncadrement
     *
     * @return CrepMj01
     */
    public function addCapacitesEncadrement(CrepMj01CapaciteEncadrement $capaciteEncadrement)
    {
        $this->capacitesEncadrements[] = $capaciteEncadrement;
        $capaciteEncadrement->setCrep($this);

        return $this;
    }

    /**
     * Remove capaciteEncadrement.
     *
     * @param CrepMj01CapaciteEncadrement $capaciteEncadrement
     */
    public function removeCapacitesEncadrement(CrepMj01QualiteProfessionnelle $capaciteEncadrement)
    {
        $this->capacitesEncadrements->removeElement($capaciteEncadrement);
        $capaciteEncadrement->setCrep(null);
    }

    /**
     * Get capacitesEncadrements.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapacitesEncadrements()
    {
        return $this->capacitesEncadrements;
    }

    /**
     * @param $margeEvolutionCapacitesEncadrement
     *
     * @return CrepMj01
     */
    public function setMargeEvolutionCapacitesEncadrement($margeEvolutionCapacitesEncadrement)
    {
        $this->margeEvolutionCapacitesEncadrement = $margeEvolutionCapacitesEncadrement;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getMargeEvolutionCapacitesEncadrement()
    {
        return $this->margeEvolutionCapacitesEncadrement;
    }

    /**
     * @param $margeEvolutionGlobale
     *
     * @return CrepMj01
     */
    public function setMargeEvolutionGlobale($margeEvolutionGlobale)
    {
        $this->margeEvolutionGlobale = $margeEvolutionGlobale;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getMargeEvolutionGlobale()
    {
        return $this->margeEvolutionGlobale;
    }

    /**
     * @param $niveauPerformanceGlobale
     *
     * @return CrepMj01
     */
    public function setNiveauPerformanceGlobale($niveauPerformanceGlobale)
    {
        $this->niveauPerformanceGlobale = $niveauPerformanceGlobale;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getNiveauPerformanceGlobale()
    {
        return $this->niveauPerformanceGlobale;
    }

    /**
     * Set observationsCompetencesProfessionnelles.
     *
     * @param string $observationsCompetencesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setObservationsCompetencesProfessionnelles($observationsCompetencesProfessionnelles)
    {
        $this->observationsCompetencesProfessionnelles = $observationsCompetencesProfessionnelles;

        return $this;
    }

    /**
     * Get observationsCompetencesProfessionnelles.
     *
     * @return string
     */
    public function getObservationsCompetencesProfessionnelles()
    {
        return $this->observationsCompetencesProfessionnelles;
    }

    /**
     * Set observationsAptitudesesProfessionnelles.
     *
     * @param string $observationsAptitudesesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setObservationsAptitudesesProfessionnelles($observationsAptitudesesProfessionnelles)
    {
        $this->observationsAptitudesesProfessionnelles = $observationsAptitudesesProfessionnelles;

        return $this;
    }

    /**
     * Get observationsAptitudesesProfessionnelles.
     *
     * @return string
     */
    public function getObservationsAptitudesesProfessionnelles()
    {
        return $this->observationsAptitudesesProfessionnelles;
    }

    /**
     * Set observationsQualitesRelationnelles.
     *
     * @param string $observationsQualitesRelationnelles
     *
     * @return CrepMj01
     */
    public function setObservationsQualitesRelationnelles($observationsQualitesRelationnelles)
    {
        $this->observationsQualitesRelationnelles = $observationsQualitesRelationnelles;

        return $this;
    }

    /**
     * Get observationsQualitesRelationnelles.
     *
     * @return string
     */
    public function getObservationsQualitesRelationnelles()
    {
        return $this->observationsQualitesRelationnelles;
    }

    /**
     * Set observationsCapacitesEncadrement.
     *
     * @param string $observationsCapacitesEncadrement
     *
     * @return CrepMj01
     */
    public function setObservationsCapacitesEncadrement($observationsCapacitesEncadrement)
    {
        $this->observationsCapacitesEncadrement = $observationsCapacitesEncadrement;

        return $this;
    }

    /**
     * Get observationsCapacitesEncadrement.
     *
     * @return string
     */
    public function getObservationsCapacitesEncadrement()
    {
        return $this->observationsCapacitesEncadrement;
    }

    /**
     * Set observationsGlobale.
     *
     * @param string $observationsGlobale
     *
     * @return CrepMj01
     */
    public function setObservationsGlobale($observationsGlobale)
    {
        $this->observationsGlobale = $observationsGlobale;

        return $this;
    }

    /**
     * Get observationsGlobale.
     *
     * @return string
     */
    public function getObservationsGlobale()
    {
        return $this->observationsGlobale;
    }

    /**
     * @param $noteAgent
     *
     * @return CrepMj01
     */
    public function setNoteAgent($noteAgent)
    {
        $this->noteAgent = $noteAgent;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getNoteAgent()
    {
        return $this->noteAgent;
    }

    /**
     * Set observationsShd.
     *
     * @param string $observationsShd
     *
     * @return CrepMj01
     */
    public function setObservationsShd($observationsShd)
    {
        $this->observationsShd = $observationsShd;

        return $this;
    }

    /**
     * Get observationsShd.
     *
     * @return string
     */
    public function getObservationsShd()
    {
        return $this->observationsShd;
    }

    /**
     * Set objectifsService.
     *
     * @param string $objectifsService
     *
     * @return CrepMj01
     */
    public function setObjectifsService($objectifsService)
    {
        $this->objectifsService = $objectifsService;

        return $this;
    }

    /**
     * Get objectifsService.
     *
     * @return string
     */
    public function getObjectifsService()
    {
        return $this->objectifsService;
    }

    /**
     * Set perspectivesEvolutionService.
     *
     * @param string $perspectivesEvolutionService
     *
     * @return CrepMj01
     */
    public function setPerspectivesEvolutionService($perspectivesEvolutionService)
    {
        $this->perspectivesEvolutionService = $perspectivesEvolutionService;

        return $this;
    }

    /**
     * Get perspectivesEvolutionService.
     *
     * @return string
     */
    public function getPerspectivesEvolutionService()
    {
        return $this->perspectivesEvolutionService;
    }

    /**
     * Set perspectivesEvolutionFonction.
     *
     * @param string $perspectivesEvolutionFonction
     *
     * @return CrepMj01
     */
    public function setPerspectivesEvolutionFonction($perspectivesEvolutionFonction)
    {
        $this->perspectivesEvolutionFonction = $perspectivesEvolutionFonction;

        return $this;
    }

    /**
     * Get perspectivesEvolutionFonction.
     *
     * @return string
     */
    public function getPerspectivesEvolutionFonction()
    {
        return $this->perspectivesEvolutionFonction;
    }

    /**
     * Add formationSuivie.
     *
     * @param CrepMj01FormationSuivie $formation
     *
     * @return CrepMj01
     */
    public function addCrepMj01FormationsSuivy(CrepMj01FormationSuivie $formation)
    {
        $this->crepMj01FormationsSuivies[] = $formation;
        $formation->setCrep($this);

        return $this;
    }

    /**
     * Remove formationSuivie.
     *
     * @param CrepMj01FormationSuivie $formation
     */
    public function removeCrepMj01FormationsSuivy(CrepMj01FormationSuivie $formation)
    {
        $this->crepMj01FormationsSuivies->removeElement($formation);
        $formation->setCrep(null);
    }

    /**
     * Get formationsSuivies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCrepMj01FormationsSuivies()
    {
        return $this->crepMj01FormationsSuivies;
    }

    /**
     * Add formationSollicitee.
     *
     * @param CrepMj01FormationSollicitee $formation
     *
     * @return CrepMj01
     */
    public function addFormationsSollicitee(CrepMj01FormationSollicitee $formation)
    {
        $this->formationsSollicitees[] = $formation;
        $formation->setCrep($this);

        return $this;
    }

    /**
     * Remove formationSollicitee.
     *
     * @param CrepMj01FormationSollicitee $formation
     */
    public function removeFormationsSollicitee(CrepMj01FormationSollicitee $formation)
    {
        $this->formationsSollicitees->removeElement($formation);
        $formation->setCrep(null);
    }

    /**
     * Get formationsSollicitees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsSollicitees()
    {
        return $this->formationsSollicitees;
    }

    /**
     * Add formationEnvisagee.
     *
     * @param CrepMj01FormationEnvisagee $formation
     *
     * @return CrepMj01
     */
    public function addFormationsEnvisagee(CrepMj01FormationEnvisagee $formation)
    {
        $this->formationsEnvisagees[] = $formation;
        $formation->setCrep($this);

        return $this;
    }

    /**
     * Remove formationEnvisagee.
     *
     * @param CrepMj01FormationEnvisagee $formation
     */
    public function removeFormationsEnvisagee(CrepMj01FormationEnvisagee $formation)
    {
        $this->formationsEnvisagees->removeElement($formation);
        $formation->setCrep(null);
    }

    /**
     * Get formationsEnvisagees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsEnvisagees()
    {
        return $this->formationsEnvisagees;
    }

    /**
     * Set observationsShdFormation.
     *
     * @param string $observationsShdFormation
     *
     * @return CrepMj01
     */
    public function setObservationsShdFormation($observationsShdFormation)
    {
        $this->observationsShdFormation = $observationsShdFormation;

        return $this;
    }

    /**
     * Get observationsShdFormation.
     *
     * @return string
     */
    public function getObservationsShdFormation()
    {
        return $this->observationsShdFormation;
    }

    /**
     * Set connaissancesInstitution.
     *
     * @param string $connaissancesInstitution
     *
     * @return CrepMj01
     */
    public function setConnaissancesInstitution($connaissancesInstitution)
    {
        $this->connaissancesInstitution = $connaissancesInstitution;

        return $this;
    }

    /**
     * Get connaissancesInstitution.
     *
     * @return string
     */
    public function getConnaissancesInstitution()
    {
        return $this->connaissancesInstitution;
    }

    /**
     * Set connaissancesProfessionnelles.
     *
     * @param string $connaissancesProfessionnelles
     *
     * @return CrepMj01
     */
    public function setConnaissancesProfessionnelles($connaissancesProfessionnelles)
    {
        $this->connaissancesProfessionnelles = $connaissancesProfessionnelles;

        return $this;
    }

    /**
     * Get connaissancesProfessionnelles.
     *
     * @return string
     */
    public function getConnaissancesProfessionnelles()
    {
        return $this->connaissancesProfessionnelles;
    }

    /**
     * Set experienceEncadrement.
     *
     * @param string $experienceEncadrement
     *
     * @return CrepMj01
     */
    public function setExperienceEncadrement($experienceEncadrement)
    {
        $this->experienceEncadrement = $experienceEncadrement;

        return $this;
    }

    /**
     * Get experienceEncadrement.
     *
     * @return string
     */
    public function getExperienceEncadrement()
    {
        return $this->experienceEncadrement;
    }

    /**
     * Get capacitesDecisions.
     *
     * @return string
     */
    public function getCapacitesDecisions()
    {
        return $this->capacitesDecisions;
    }

    /**
     * Set capacitesDecisions.
     *
     * @param string $capacitesDecisions
     *
     * @return CrepMj01
     */
    public function setCapacitesDecisions($capacitesDecisions)
    {
        $this->capacitesDecisions = $capacitesDecisions;

        return $this;
    }

    /**
     * Get mobiliteFonctionnelleOuGeographique.
     *
     * @return string
     */
    public function getMobiliteFonctionnelleOuGeographique()
    {
        return $this->mobiliteFonctionnelleOuGeographique;
    }

    /**
     * Set mobiliteFonctionnelleOuGeographique.
     *
     * @param string $mobiliteFonctionnelleOuGeographique
     *
     * @return CrepMj01
     */
    public function setMobiliteFonctionnelleOuGeographique($mobiliteFonctionnelleOuGeographique)
    {
        $this->mobiliteFonctionnelleOuGeographique = $mobiliteFonctionnelleOuGeographique;

        return $this;
    }

    /**
     * Get observationsAgentDeroulementEntretien.
     *
     * @return string
     */
    public function getObservationsAgentDeroulementEntretien()
    {
        return $this->observationsAgentDeroulementEntretien;
    }

    /**
     * Set observationsAgentDeroulementEntretien.
     *
     * @param string $observationsAgentDeroulementEntretien
     *
     * @return CrepMj01
     */
    public function setObservationsAgentDeroulementEntretien($observationsAgentDeroulementEntretien)
    {
        $this->observationsAgentDeroulementEntretien = $observationsAgentDeroulementEntretien;

        return $this;
    }

    /**
     * Get observationsAgentAppreciationsPortees.
     *
     * @return string
     */
    public function getObservationsAgentAppreciationsPortees()
    {
        return $this->observationsAgentAppreciationsPortees;
    }

    /**
     * Set observationsAgentAppreciationsPortees.
     *
     * @param string $observationsAgentAppreciationsPortees
     *
     * @return CrepMj01
     */
    public function setObservationsAgentAppreciationsPortees($observationsAgentAppreciationsPortees)
    {
        $this->observationsAgentAppreciationsPortees = $observationsAgentAppreciationsPortees;

        return $this;
    }

    /**
     * Get motifAbsenceEntretien.
     *
     * @return string
     */
    public function getMotifAbsenceEntretien()
    {
        return $this->motifAbsenceEntretien;
    }

    /**
     * Set motifAbsenceEntretien.
     *
     * @param string $motifAbsenceEntretien
     *
     * @return CrepMj01
     */
    public function setMotifAbsenceEntretien($motifAbsenceEntretien)
    {
        $this->motifAbsenceEntretien = $motifAbsenceEntretien;

        return $this;
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $dernierCrep = $em->getRepository(Crep::class)->getDernierCrep($agent);
        
        // Reprise des données du CREP N-1
        if($dernierCrep && $dernierCrep instanceof $this){
        
        	// Reprise des formations
        	foreach ($dernierCrep->getFormationsEnvisagees() as $formation){
        		$formationSuivie = new CrepMj01FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addCrepMj01FormationsSuivy($formation);
        	}
        	
        	// Reprise des fonctions exercees
        	$this->setDescriptionFonctions($dernierCrep->getDescriptionFonctions());
        	
        	// Reprise des acquis de l'expérience professionnelle
        	$this->setConnaissancesInstitution($dernierCrep->getConnaissancesInstitution());
        	$this->setConnaissancesProfessionnelles($dernierCrep->getConnaissancesProfessionnelles());
        	$this->setExperienceEncadrement($dernierCrep->getExperienceEncadrement());
        }
        
        $this->setNomUsage($agent->getNom());
        $this->setNomNaissance($agent->getNomNaissance());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setPosteOccupe($agent->getPosteOccupe());
        $this->setAffectation($agent->getAffectation());
        $this->setDateEntreePoste($agent->getDateEntreePosteOccupe());
        $this->setCorps($agent->getCorps());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());

        if ($agent->getShd()) {
            $this->setNomUsageShd($agent->getShd()->getNom());
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
            $this->setAffectationShd($agent->getShd()->getAffectation());
        }

        // initialisation des compétences professionnelles
        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Connaissances techniques spécifiques à la fonction');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Connaissance de l’environnement professionnel');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Aptitude à actualiser et à perfectionner ses connaissances et ses méthodes de travail');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Expression écrite et orale (*)');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Maîtrise et adaptabilité aux nouvelles technologies');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        $competenceProfessionnelle = new CrepMj01CompetenceProfessionnelle();
        $competenceProfessionnelle->setLibelle('Qualité d’analyse et de synthèse (*)');
        $this->addCompetencesProfessionnelle($competenceProfessionnelle);

        // initialisation des aptitudes professionnelles
        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Sens du service public');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Conscience professionnelle');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Esprit d\'initiative et dynamisme');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Capacité d\'adaptation aux changements et anticipation');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Capacité de travail');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        $aptitudeProfessionnelle = new CrepMj01AptitudeProfessionnelle();
        $aptitudeProfessionnelle->setLibelle('Qualités du travail fourni');
        $this->addAptitudesProfessionnelle($aptitudeProfessionnelle);

        // initialisation des qualités professionnelles
        $qualiteProfessionnelle = new CrepMj01QualiteProfessionnelle();
        $qualiteProfessionnelle->setLibelle('Capacité de travail en équipe');
        $this->addQualitesProfessionnelle($qualiteProfessionnelle);

        $qualiteProfessionnelle = new CrepMj01QualiteProfessionnelle();
        $qualiteProfessionnelle->setLibelle('Sens des relations professionnelles');
        $this->addQualitesProfessionnelle($qualiteProfessionnelle);

        // initialisation des capacités d'encadrement
        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Conduite et animation d\'une équipe');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Capacité d\'écoute et d\'organisation');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Capacité à déléguer et à contrôler');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Capacité à organiser le service');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Aptitude à la prise de décision');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        $capaciteEncadrement = new CrepMj01CapaciteEncadrement();
        $capaciteEncadrement->setLibelle('Aptitude à former des collaborateurs');
        $this->addCapacitesEncadrement($capaciteEncadrement);

        // 		// TODO : à supprimer
// 		for($i=0 ; $i<4 ; $i++){
// 			$objectifEvalue = new ObjectifEvalue();
// 			$objectifEvalue->setLibelle("Mon objectif ".$i);
// 			$objectifEvalue->setIndicateurs("Mon indicateur ".$i);
// 			$objectifEvalue->setResultatObtenu(1);
// 			$objectifEvalue->setResultat("Mon résultat ".$i);

// 			$this->addObjectifsEvalue($objectifEvalue);
// 		}

// 		// TODO : à supprimer
// 		for($i=0 ; $i<3 ; $i++){
// 			$objectifFutur = new ObjectifFutur();
// 			$objectifFutur->setLibelle("Mon objectif futur".$i);
// 			$objectifFutur->setIndicateurs("Mon contexte ".$i);
// 			$this->addObjectifsFutur($objectifFutur);
// 		}

// 		// TODO : à supprimer
// 		for($i=0 ; $i<3 ; $i++){
// 			$formationSuivie = new CrepMj01FormationSuivie();
// 			$formationSuivie->setLibelle("Formation suivie ".$i);
// 			$formationSuivie->setDuree("Durée ".$i);
// 			$this->addCrepMj01FormationsSuivy($formationSuivie);

// 			$formationSollicitee = new CrepMj01FormationSollicitee();
// 			$formationSollicitee->setLibelle("Formation sollicitée ".$i);
// 			$formationSollicitee->setOrigine($i);
// 			$this->addFormationsSollicitee($formationSollicitee);

// 			$formationEnvisagee = new CrepMj01FormationEnvisagee();
// 			$formationEnvisagee->setLibelle("Formation envisagée ".$i);
// 			$formationEnvisagee->setOrigine($i);
// 			$this->addFormationsEnvisagee($formationEnvisagee);
// 		}
    }

    /**
     * Méthode appelée lors d'un rattachement d'un nouveau N+1.
     */
    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this
            ->setNomUsageShd($shd->getNom())
            ->setPrenomShd($shd->getPrenom())
            ->setPosteOccupeShd($shd->getPosteOccupe())
            ->setServiceShd(null)
            ->setAffectationShd($shd->getAffectation());
        } else {
            $this
            ->setNomUsageShd(null)
            ->setPrenomShd(null)
            ->setPosteOccupeShd(null)
            ->setServiceShd(null)
            ->setAffectationShd(null);
        }
    }

    public function confidentialisationChampsShd()
    {
        $this->setDescriptionFonctions(null);

        /* @var $objectif ObjectifEvalue */
        foreach ($this->getObjectifsEvalues() as $objectif) {
            $this->removeObjectifsEvalue($objectif);
        }

        $this->setMotifAbsenceEntretien(null)
        ->setObservationsShdObjectifsEvalues(null);

        /* @var $competence CrepMj01CompetenceProfessionnelle */
        foreach ($this->competencesProfessionnelles as $competence) {
            $competence->setNiveau(null);
        }
        $this->setMargeEvolutionCompetencesProfessionnelles(null);

        /* @var $aptitude CrepMj01AptitudeProfessionnelle */
        foreach ($this->aptitudesProfessionnelles as $aptitude) {
            $aptitude->setNiveau(null);
        }
        $this->setMargeEvolutionAptitudesProfessionnelles(null);

        /* @var $qualite CrepMj01QualiteProfessionnelle */
        foreach ($this->qualitesProfessionnelles as $qualite) {
            $qualite->setNiveau(null);
        }
        $this->setMargeEvolutionQualitesProfessionnelles(null);

        /* @var $capacite CrepMj01CapaciteEncadrement */
        foreach ($this->capacitesEncadrements as $capacite) {
            $capacite->setNiveau(null);
        }
        $this->setMargeEvolutionCapacitesEncadrement(null);

        $this->setMargeEvolutionGlobale(null)
        ->setNiveauPerformanceGlobale(null)
        ->setObservationsCompetencesProfessionnelles(null)
        ->setObservationsAptitudesesProfessionnelles(null)
        ->setObservationsQualitesRelationnelles(null)
        ->setObservationsCapacitesEncadrement(null)
        ->setObservationsGlobale(null)
        ->setNoteAgent(null)
        ->setObservationsShd(null)
        ->setObjectifsService(null);

        /* @var $objectif ObjectifFutur */
        foreach ($this->objectifsFuturs as $objectif) {
            $this->removeObjectifsFutur($objectif);
        }

        $this->setPerspectivesEvolutionService(null)
        ->setPerspectivesEvolutionFonction(null)
        ->setObservationsShdFormation(null)
        ->setConnaissancesInstitution(null)
        ->setConnaissancesProfessionnelles(null)
        ->setExperienceEncadrement(null)
        ->setCapacitesDecisions(null)
        ->setMobiliteFonctionnelleOuGeographique(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setObservationsAgentObjectifsEvalues(null)
        ->setObservationsVisaAgent(null)
        ->setObservationsAgentDeroulementEntretien(null)
        ->setObservationsAgentAppreciationsPortees(null);
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    public function confidentialisationChampsAh()
    {
        $this->setObservationsAh(null);
    }
}
