<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Converter;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;


/**
 * CrepEdd.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository")
 */
class CrepEdd extends Crep
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"m.", "mme"}, message = "Civilité non valide. Valeurs acceptées : 'M.', 'Mme'")
     */
    protected $civilite;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom obligatoire")
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
     * @Assert\Date(message = "Date de naissance non valide")
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
     */
    protected $posteOccupeAgent;

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
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    protected $echelon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $direction;

    /**
     * @var string
     *
     * @ORM\Column(name="corps", type="string", nullable=true)
     */
    protected $corps;

    // 	/**
    // 	 * @var string
    // 	 *
    // 	 * @ORM\Column(type="string", nullable=true)
    // 	 */
    // 	protected $cadreEmploi;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $grade;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    protected $echelonOrigine;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"m.", "mme"}, message = "Civilité non valide. Valeurs acceptées : 'M.', 'Mme'")
     */
    protected $civiliteShd;

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
    protected $prenomShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsageShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupeShd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le poste non valide")
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2999-12-31",
     *      minMessage = "Date non valide",
     *      maxMessage = "Date non valide"
     * )
     */
    protected $dateEntreePosteOccupeShd;

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
     * @var \DateTime @ORM\Column(type="date")
     *
     * @Assert\Date(message = "Date non valide")
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2999-12-31",
     *      minMessage = "Date non valide",
     *      maxMessage = "Date non valide"
     * )
     */
    protected $datePriseFonctions;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $groupeFonctions;

    /**
     * @var integer
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
    protected $nbBureauxDirection;

    /**
     * @var integer
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
    protected $nbCadresEncadresA;

    /**
     * @var integer
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
    protected $nbTotalAgentsEncadres;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $presenceAdjoints;

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
    protected $observationsEffectifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddContraintePoste", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $contraintesPostes;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddAutreContraintePoste", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresContraintesPostes;

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
    protected $commentaireAgentFonction;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $contexteAnneeEcoulee;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $docAnnexeBilan;

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
    protected $contexteObjectifsPasses;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddObjectifEvalueCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddObjectifEvalueIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesIndividuels;

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
    protected $autresDossiers;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $docAnnexeObjectifsAvenir;

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
    protected $contexteObjectifsAvenir;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddObjectifFuturCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsFutursCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddObjectifFuturIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsFutursIndividuels;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddCompetenceTransverseRequise", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesTransversesRequises;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_comp_trans_requises")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesTransversesRequises;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddAutreCompetenceTransverseRequise", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresCompetencesTransversesRequises;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_aut_comp_transverses")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAutresCompetencesTransversesRequises;

    /**
     * =====================================================================================================
     *                                      collections des techniques
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="CrepEddTechnique", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $techniques;

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
    protected $observationsTechniques;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddCompetenceManageriale", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesManageriales;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_comp_manageriales")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddAutreCompetenceManageriale", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresCompetencesManageriales;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_aut_comp_manageriales")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAutresCompetencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddCompetenceTransverseDetenue", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesTransversesDetenues;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="obs_comp_trans_detenues")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesTransversesDetenues;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitEvolutionCarriere;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $typeEvolutionCarriere;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitMobilite;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $typeMobilite;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $apptitudeNiveauSup;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $observationShdEvolution;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="comm_agent_evolution")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $commentaireAgentEvolution;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $docAnnexeBesoinsFormation;

    /**
     * @ORM\OneToMany(targetEntity="CrepEddFormationSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsSuivies;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $appreciationGenerale;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $evolutionIndemnitaire;

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

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setCivilite($civilite)
    {
        $this->civilite = $civilite ? strtolower($civilite) : $civilite;

        return $this;
    }

    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     * @param
     *            $nomUsage
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param unknown_type $prenom
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
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get posteOccupeAgent.
     *
     * @return string
     */
    public function getPosteOccupeAgent()
    {
        return $this->posteOccupeAgent;
    }

    /**
     * Set posteOccupeAgent.
     *
     * @param string $posteOccupeAgent
     *
     * @return CrepEdd
     */
    public function setPosteOccupeAgent($posteOccupeAgent)
    {
        $this->posteOccupeAgent = $posteOccupeAgent;

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
     * @return CrepEdd
     */
    public function setDateEntreePoste(\DateTime $dateEntreePoste = null)
    {
        $this->dateEntreePoste = $dateEntreePoste;

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
     * @param
     *            $echelon
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

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

    /**
     * Get corps.
     *
     * @return string
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * Set corps.
     *
     * @param string $corps
     *
     * @return CrepEdd
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;

        return $this;
    }

    /**
     * Get grade.
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set grade.
     *
     * @param string $grade
     *
     * @return CrepEdd
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return the string
     */
    public function getEchelonOrigine()
    {
        return $this->echelonOrigine;
    }

    /**
     * @param
     *            $echelonOrigine
     */
    public function setEchelonOrigine($echelonOrigine)
    {
        $this->echelonOrigine = $echelonOrigine;

        return $this;
    }

    public function getCiviliteShd()
    {
        return $this->civiliteShd;
    }

    public function setCiviliteShd($civiliteShd)
    {
        $this->civiliteShd = $civiliteShd ? strtolower($civiliteShd) : $civiliteShd;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     * @param unknown_type $prenomShd
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;

        return $this;
    }

    public function getNomUsageShd()
    {
        return $this->nomUsageShd;
    }

    /**
     * @param
     *            $nomUsageShd
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;

        return $this;
    }

    /**
     * Get posteOccupeShd.
     *
     * @return string
     */
    public function getPosteOccupeShd()
    {
        return $this->posteOccupeShd;
    }

    /**
     * Set posteOccupeShd.
     *
     * @param string $posteOccupeShd
     *
     * @return CrepEdd
     */
    public function setposteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;

        return $this;
    }

    /**
     * @return the DateTime
     */
    public function getDateEntreePosteOccupeShd()
    {
        return $this->dateEntreePosteOccupeShd;
    }

    /**
     * @param \DateTime $dateEntreePosteOccupeShd
     */
    public function setDateEntreePosteOccupeShd($dateEntreePosteOccupeShd)
    {
        $this->dateEntreePosteOccupeShd = $dateEntreePosteOccupeShd;

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
     * @return the DateTime
     */
    public function getDatePriseFonctions()
    {
        return $this->datePriseFonctions;
    }

    /**
     * @param \DateTime $datePriseFonctions
     */
    public function setDatePriseFonctions($datePriseFonctions)
    {
        $this->datePriseFonctions = $datePriseFonctions;

        return $this;
    }

    /**
     * @return the string
     */
    public function getGroupeFonctions()
    {
        return $this->groupeFonctions;
    }

    /**
     * @param
     *            $groupeFonctions
     */
    public function setGroupeFonctions($groupeFonctions)
    {
        $this->groupeFonctions = $groupeFonctions;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getNbBureauxDirection()
    {
        return $this->nbBureauxDirection;
    }

    /**
     * @param
     *            $nbBureauxDirection
     */
    public function setNbBureauxDirection($nbBureauxDirection)
    {
        $this->nbBureauxDirection = $nbBureauxDirection;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getNbCadresEncadresA()
    {
        return $this->nbCadresEncadresA;
    }

    /**
     * @param
     *            $nbCadresEncadresA
     */
    public function setNbCadresEncadresA($nbCadresEncadresA)
    {
        $this->nbCadresEncadresA = $nbCadresEncadresA;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getNbTotalAgentsEncadres()
    {
        return $this->nbTotalAgentsEncadres;
    }

    /**
     * @param
     *            $nbTotalAgentsEncadres
     */
    public function setNbTotalAgentsEncadres($nbTotalAgentsEncadres)
    {
        $this->nbTotalAgentsEncadres = $nbTotalAgentsEncadres;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getPresenceAdjoints()
    {
        return $this->presenceAdjoints;
    }

    /**
     * @param
     *            $presenceAdjoints
     */
    public function setPresenceAdjoints($presenceAdjoints)
    {
        $this->presenceAdjoints = $presenceAdjoints;

        return $this;
    }

    /**
     * @return the text
     */
    public function getObservationsEffectifs()
    {
        return $this->observationsEffectifs;
    }

    /**
     * @param
     *            $observationsEffectifs
     */
    public function setObservationsEffectifs($observationsEffectifs)
    {
        $this->observationsEffectifs = $observationsEffectifs;

        return $this;
    }

    /**
     * Add contraintesPoste.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddContraintePoste $contraintePoste
     *
     * @return CrepEdd
     */
    public function addContraintesPostes(\AppBundle\Entity\Crep\CrepEdd\CrepEddContraintePoste $contraintePoste)
    {
        $this->contraintesPostes[] = $contraintePoste;
        $contraintePoste->setCrep($this);

        return $this;
    }

    /**
     * Remove contraintePoste.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddContraintePoste $contraintePoste
     */
    public function removeContraintesPoste(\AppBundle\Entity\Crep\CrepEdd\CrepEddContraintePoste $contraintePoste)
    {
        $this->contraintesPostes->removeElement($contraintePoste);
        $contraintePoste->setCrep(null);
    }

    /**
     * Get contraintesPostes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContraintesPostes()
    {
        return $this->contraintesPostes;
    }

    /**
     * Add autreContraintePoste.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddAutreContraintePoste $contraintePoste
     *
     * @return CrepEdd
     */
    public function addAutresContraintesPoste(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreContraintePoste $contraintePoste)
    {
        $this->autresContraintesPostes[] = $contraintePoste;
        $contraintePoste->setCrep($this);

        return $this;
    }

    /**
     * Remove autreContraintePoste.
     *
     * @param \AppBundle\Entity\CrepEddAutreContraintePoste $contraintePoste
     */
    public function removeAutresContraintesPoste(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreContraintePoste $contraintePoste)
    {
        $this->autresContraintesPostes->removeElement($contraintePoste);
        $contraintePoste->setCrep(null);
    }

    /**
     * Get autresContraintesPoste.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresContraintesPostes()
    {
        return $this->autresContraintesPostes;
    }

    /**
     * Get commentaireAgentFonction.
     *
     * @return string
     */
    public function getCommentaireAgentFonction()
    {
        return $this->commentaireAgentFonction;
    }

    /**
     * Set commentaireAgentFonction.
     *
     * @param string $commentaireAgentFonction
     *
     * @return CrepEdd
     */
    public function setCommentaireAgentFonction($commentaireAgentFonction)
    {
        $this->commentaireAgentFonction = $commentaireAgentFonction;

        return $this;
    }

    /**
     * Get contexteAnneeEcoulee.
     *
     * @return string
     */
    public function getContexteAnneeEcoulee()
    {
        return $this->contexteAnneeEcoulee;
    }

    /**
     * Set contexteAnneeEcoulee.
     *
     * @param string $contexteAnneeEcoulee
     *
     * @return CrepEdd
     */
    public function setContexteAnneeEcoulee($contexteAnneeEcoulee)
    {
        $this->contexteAnneeEcoulee = $contexteAnneeEcoulee;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getDocAnnexeBilan()
    {
        return $this->docAnnexeBilan;
    }

    /**
     * @param
     *            $docAnnexeBilan
     */
    public function setDocAnnexeBilan($docAnnexeBilan)
    {
        $this->docAnnexeBilan = $docAnnexeBilan;

        return $this;
    }

    /**
     * @return the text
     */
    public function getContexteObjectifsPasses()
    {
        return $this->contexteObjectifsPasses;
    }

    /**
     * @param
     *            $contexteObjectifsPasses
     */
    public function setContexteObjectifsPasses($contexteObjectifsPasses)
    {
        $this->contexteObjectifsPasses = $contexteObjectifsPasses;

        return $this;
    }

    /**
     * Add objectifsEvalueCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueCollectif $objectifsEvalueCollectif
     *
     * @return Crep
     */
    public function addObjectifsEvaluesCollectif(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueCollectif $objectifsEvalueCollectif)
    {
        $this->objectifsEvaluesCollectifs[] = $objectifsEvalueCollectif;
        $objectifsEvalueCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueCollectif $objectifsEvalueCollectif
     */
    public function removeObjectifsEvaluesCollectif(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueCollectif $objectifsEvalueCollectif)
    {
        $this->objectifsEvaluesCollectifs->removeElement($objectifsEvalueCollectif);
        $objectifsEvalueCollectif->setCrep(null);
    }

    /**
     * Get objectifsEvaluesCollectifs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsEvaluesCollectifs()
    {
        return $this->objectifsEvaluesCollectifs;
    }

    /**
     * Add objectifsEvalueIndividuel.
     *
     * @param \AppBundle\Entity\ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     *
     * @return Crep
     */
    public function addObjectifsEvaluesIndividuel(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueIndividuel $objectifsEvalueIndividuel)
    {
        $this->objectifsEvaluesIndividuels[] = $objectifsEvalueIndividuel;
        $objectifsEvalueIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueIndividuel.
     *
     * @param \AppBundle\Entity\ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     */
    public function removeObjectifsEvaluesIndividuel(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueIndividuel $objectifsEvalueIndividuel)
    {
        $this->objectifsEvaluesIndividuels->removeElement($objectifsEvalueIndividuel);
        $objectifsEvalueIndividuel->setCrep(null);
    }

    /**
     * Get objectifsEvaluesIndividuels.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsEvaluesIndividuels()
    {
        return $this->objectifsEvaluesIndividuels;
    }

    /**
     * @return the text
     */
    public function getAutresDossiers()
    {
        return $this->autresDossiers;
    }

    /**
     * @param
     *            $autresDossiers
     */
    public function setAutresDossiers($autresDossiers)
    {
        $this->autresDossiers = $autresDossiers;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getDocAnnexeObjectifsAvenir()
    {
        return $this->docAnnexeObjectifsAvenir;
    }

    /**
     * @param
     *            $docAnnexeObjectifsAvenir
     */
    public function setDocAnnexeObjectifsAvenir($docAnnexeObjectifsAvenir)
    {
        $this->docAnnexeObjectifsAvenir = $docAnnexeObjectifsAvenir;

        return $this;
    }

    /**
     * @return the text
     */
    public function getContexteObjectifsAvenir()
    {
        return $this->contexteObjectifsAvenir;
    }

    /**
     * @param
     *            $contexteObjectifsAvenir
     */
    public function setContexteObjectifsAvenir($contexteObjectifsAvenir)
    {
        $this->contexteObjectifsAvenir = $contexteObjectifsAvenir;

        return $this;
    }

    /**
     * Add objectifsFuturCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturCollectif $objectifsFuturCollectif
     *
     * @return Crep
     */
    public function addObjectifsFutursCollectif(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturCollectif $objectifsFuturCollectif)
    {
        $this->objectifsFutursCollectifs[] = $objectifsFuturCollectif;
        $objectifsFuturCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturCollectif $objectifsFuturCollectif
     */
    public function removeObjectifsFutursCollectif(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturCollectif $objectifsFuturCollectif)
    {
        $this->objectifsFutursCollectifs->removeElement($objectifsFuturCollectif);
        $objectifsFuturCollectif->setCrep(null);
    }

    /**
     * Get objectifsFutursCollectifs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsFutursCollectifs()
    {
        return $this->objectifsFutursCollectifs;
    }

    /**
     * Add objectifsFuturIndividuel.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturIndividuel $objectifsFuturIndividuel
     *
     * @return Crep
     */
    public function addObjectifsFutursIndividuel(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturIndividuel $objectifsFuturIndividuel)
    {
        $this->objectifsFutursIndividuels[] = $objectifsFuturIndividuel;
        $objectifsFuturIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturIndividuel.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturIndividuel $objectifsFuturIndividuel
     */
    public function removeObjectifsFutursIndividuel(\AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifFuturIndividuel $objectifsFuturIndividuel)
    {
        $this->objectifsFutursIndividuels->removeElement($objectifsFuturIndividuel);
        $objectifsFuturIndividuel->setCrep(null);
    }

    /**
     * Get objectifsFutursIndividuels.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsFutursIndividuels()
    {
        return $this->objectifsFutursIndividuels;
    }

    /**
     * Add competencesTransverseRequise.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseRequise $competencesTransverseRequise
     *
     * @return CrepEdd
     */
    public function addCompetencesTransversesRequise(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseRequise $competencesTransverseRequise)
    {
        $this->competencesTransversesRequises[] = $competencesTransverseRequise;
        $competencesTransverseRequise->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesTransverseRequise.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseRequise $competencesTransverseRequise
     */
    public function removeCompetencesTransversesRequise(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseRequise $competencesTransverseRequise)
    {
        $this->competencesTransversesRequises->removeElement($competencesTransverseRequise);
    }

    /**
     * Get competencesTransversesRequises.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesTransversesRequises()
    {
        return $this->competencesTransversesRequises;
    }

    /**
     * Get observationsCompetencesTransversesRequises.
     *
     * @return string
     */
    public function getObservationsCompetencesTransversesRequises()
    {
        return $this->observationsCompetencesTransversesRequises;
    }

    /**
     * Set observationsCompetencesTransversesRequises.
     *
     * @param string $observationsCompetencesTransversesRequises
     *
     * @return CrepEdd
     */
    public function setObservationsCompetencesTransversesRequises($observationsCompetencesTransversesRequises)
    {
        $this->observationsCompetencesTransversesRequises = $observationsCompetencesTransversesRequises;

        return $this;
    }

    /**
     * Add autresCompetencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepEddAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise
     *
     * @return CrepEdd
     */
    public function addAutresCompetencesTransversesRequise(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise)
    {
        $this->autresCompetencesTransversesRequises[] = $autresCompetencesTransverseRequise;
        $autresCompetencesTransverseRequise->setCrep($this);

        return $this;
    }

    /**
     * Remove autresCompetencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepEddAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise
     */
    public function removeAutresCompetencesTransversesRequise(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise)
    {
        $this->autresCompetencesTransversesRequises->removeElement($autresCompetencesTransverseRequise);
        $autresCompetencesTransverseRequise->setCrep(null);
    }

    /**
     * Get autresCompetencesTransversesRequises.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresCompetencesTransversesRequises()
    {
        return $this->autresCompetencesTransversesRequises;
    }

    /**
     * Get observationsAutresCompetencesTransversesRequises.
     *
     * @return string
     */
    public function getObservationsAutresCompetencesTransversesRequises()
    {
        return $this->observationsAutresCompetencesTransversesRequises;
    }

    /**
     * Set observationsAutresCompetencesTransversesRequises.
     *
     * @param string $observationsAutresCompetencesTransversesRequises
     *
     * @return CrepEdd
     */
    public function setObservationsAutresCompetencesTransversesRequises($observationsAutresCompetencesTransversesRequises)
    {
        $this->observationsAutresCompetencesTransversesRequises = $observationsAutresCompetencesTransversesRequises;

        return $this;
    }

    /**
     * Add technique.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddTechnique $techniques
     *
     * @return CrepEdd
     */
    public function addTechnique(\AppBundle\Entity\Crep\CrepEdd\CrepEddTechnique $techniques)
    {
        $this->techniques[] = $techniques;
        $techniques->setCrep($this);

        return $this;
    }

    /**
     * Remove technique.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddTechnique $techniques
     */
    public function removeTechnique(\AppBundle\Entity\Crep\CrepEdd\CrepEddTechnique $techniques)
    {
        $this->techniques->removeElement($techniques);
        $techniques->setCrep(null);
    }

    /**
     * Get techniques.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Get observationsTechniques.
     *
     * @return string
     */
    public function getObservationsTechniques()
    {
        return $this->observationsTechniques;
    }

    /**
     * Set observationsTechniques.
     *
     * @param string observationsTechniques
     *
     * @return CrepEdd
     */
    public function setObservationsTechniques($observationsTechniques)
    {
        $this->observationsTechniques = $observationsTechniques;

        return $this;
    }

    /**
     * Add competencesManageriale.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceManageriale $competencesManageriale
     *
     * @return CrepEdd
     */
    public function addCompetencesManageriale(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales[] = $competencesManageriale;
        $competencesManageriale->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesManageriale.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceManageriale $competencesManageriale
     */
    public function removeCompetencesManageriale(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales->removeElement($competencesManageriale);
    }

    /**
     * Get competencesManageriales.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesManageriales()
    {
        return $this->competencesManageriales;
    }

    /**
     * Get observationsCompetencesManageriales.
     *
     * @return string
     */
    public function getObservationsCompetencesManageriales()
    {
        return $this->observationsCompetencesManageriales;
    }

    /**
     * Set observationsCompetencesManageriales.
     *
     * @param string observationsCompetencesManageriales
     *
     * @return CrepEdd
     */
    public function setObservationsCompetencesManageriales($observationsCompetencesManageriales)
    {
        $this->observationsCompetencesManageriales = $observationsCompetencesManageriales;

        return $this;
    }

    /**
     * Add autresCompetencesManageriale.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceManageriale $autresCompetencesManageriale
     *
     * @return CrepEdd
     */
    public function addAutresCompetencesManageriale(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceManageriale $autresCompetencesManageriale)
    {
        $this->autresCompetencesManageriales[] = $autresCompetencesManageriale;
        $autresCompetencesManageriale->setCrep($this);

        return $this;
    }

    /**
     * Remove autresCompetencesManageriale.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceManageriale $autresCompetencesManageriale
     */
    public function removeAutresCompetencesManageriale(\AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceManageriale $autresCompetencesManageriale)
    {
        $this->autresCompetencesManageriales->removeElement($autresCompetencesManageriale);
        $autresCompetencesManageriale->setCrep(null);
    }

    /**
     * Get autresCompetencesManageriales.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresCompetencesManageriales()
    {
        return $this->autresCompetencesManageriales;
    }

    /**
     * Get observationsAutresCompetencesManageriales.
     *
     * @return string
     */
    public function getObservationsAutresCompetencesManageriales()
    {
        return $this->observationsAutresCompetencesManageriales;
    }

    /**
     * Set observationsAutresCompetencesManageriales.
     *
     * @param string observationsAutresCompetencesManageriales
     *
     * @return CrepEdd
     */
    public function setObservationsAutresCompetencesManageriales($observationsAutresCompetencesManageriales)
    {
        $this->observationsAutresCompetencesManageriales = $observationsAutresCompetencesManageriales;

        return $this;
    }

    /**
     * Add competencesTransverseDetenue.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseDetenue $competencesTransverseDetenue
     *
     * @return CrepEdd
     */
    public function addCompetencesTransversesDetenue(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseDetenue $competencesTransverseDetenue)
    {
        $this->competencesTransversesDetenues[] = $competencesTransverseDetenue;
        $competencesTransverseDetenue->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesTransverseDetenue.
     *
     * @param \AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseDetenue $competencesTransverseDetenue
     */
    public function removeCompetencesTransversesDetenue(\AppBundle\Entity\Crep\CrepEdd\CrepEddCompetenceTransverseDetenue $competencesTransverseDetenue)
    {
        $this->competencesTransversesDetenues->removeElement($competencesTransverseDetenue);
        $competencesTransverseDetenue->setCrep(null);
    }

    /**
     * Get competencesTransversesDetenue.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesTransversesDetenues()
    {
        return $this->competencesTransversesDetenues;
    }

    /**
     * Get observationsCompetencesTransversesDetenues.
     *
     * @return string
     */
    public function getObservationsCompetencesTransversesDetenues()
    {
        return $this->observationsCompetencesTransversesDetenues;
    }

    /**
     * Set observationsCompetencesTransversesDetenues.
     *
     * @param string observationsCompetencesTransversesDetenues
     *
     * @return CrepEdd
     */
    public function setObservationsCompetencesTransversesDetenues($observationsCompetencesTransversesDetenues)
    {
        $this->observationsCompetencesTransversesDetenues = $observationsCompetencesTransversesDetenues;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getSouhaitEvolutionCarriere()
    {
        return $this->souhaitEvolutionCarriere;
    }

    /**
     * @param
     *            $souhaitEvolutionCarriere
     */
    public function setSouhaitEvolutionCarriere($souhaitEvolutionCarriere)
    {
        $this->souhaitEvolutionCarriere = $souhaitEvolutionCarriere;

        return $this;
    }

    /**
     * @return the text
     */
    public function getTypeEvolutionCarriere()
    {
        return $this->typeEvolutionCarriere;
    }

    /**
     * @param
     *            $typeEvolutionCarriere
     */
    public function setTypeEvolutionCarriere($typeEvolutionCarriere)
    {
        $this->typeEvolutionCarriere = $typeEvolutionCarriere;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getSouhaitMobilite()
    {
        return $this->souhaitMobilite;
    }

    /**
     * @param
     *            $souhaitMobilite
     */
    public function setSouhaitMobilite($souhaitMobilite)
    {
        $this->souhaitMobilite = $souhaitMobilite;

        return $this;
    }

    /**
     * @return the text
     */
    public function getTypeMobilite()
    {
        return $this->typeMobilite;
    }

    /**
     * @param
     *            $typeMobilite
     */
    public function setTypeMobilite($typeMobilite)
    {
        $this->typeMobilite = $typeMobilite;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getSouhaitEntretienCarriere()
    {
        return $this->souhaitEntretienCarriere;
    }

    /**
     * @param
     *            $souhaitEntretienCarriere
     */
    public function setSouhaitEntretienCarriere($souhaitEntretienCarriere)
    {
        $this->souhaitEntretienCarriere = $souhaitEntretienCarriere;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getApptitudeNiveauSup()
    {
        return $this->apptitudeNiveauSup;
    }

    /**
     * @param
     *            $apptitudeNiveauSup
     */
    public function setApptitudeNiveauSup($apptitudeNiveauSup)
    {
        $this->apptitudeNiveauSup = $apptitudeNiveauSup;

        return $this;
    }

    /**
     * @return the text
     */
    public function getObservationShdEvolution()
    {
        return $this->observationShdEvolution;
    }

    /**
     * @param
     *            $observationShdEvolution
     */
    public function setObservationShdEvolution($observationShdEvolution)
    {
        $this->observationShdEvolution = $observationShdEvolution;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCommentaireAgentEvolution()
    {
        return $this->commentaireAgentEvolution;
    }

    /**
     * @param
     *            $commentaireAgentEvolution
     */
    public function setCommentaireAgentEvolution($commentaireAgentEvolution)
    {
        $this->commentaireAgentEvolution = $commentaireAgentEvolution;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getDocAnnexeBesoinsFormation()
    {
        return $this->docAnnexeBesoinsFormation;
    }

    /**
     * @param
     *            $docAnnexeBesoinsFormation
     */
    public function setDocAnnexeBesoinsFormation($docAnnexeBesoinsFormation)
    {
        $this->docAnnexeBesoinsFormation = $docAnnexeBesoinsFormation;

        return $this;
    }


//    /**
//     * Add formationsSuivy.
//     *
//     * @param \AppBundle\Entity\FormationSuivie $formationsSuivy
//     *
//     * @return Crep
//     */
//    public function addFormationsSuivy(\AppBundle\Entity\FormationSuivie $formationsSuivy)
//    {
//        $this->formationsSuivies[] = $formationsSuivy;
//        $formationsSuivy->setCrep($this);
//
//        return $this;
//    }

//    /**
//     * Remove formationsSuivy.
//     *
//     * @param \AppBundle\Entity\FormationSuivie $formationsSuivy
//     */
//    public function removeFormationsSuivy(\AppBundle\Entity\FormationSuivie $formationsSuivy)
//    {
//        $this->formationsSuivies->removeElement($formationsSuivy);
//        $formationsSuivy->setCrep(null);
//    }
//
//    /**
//     * Get formationsSuivies.
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getFormationsSuivies()
//    {
//        return $this->formationsSuivies;
//    }


    /**
     * @return text
     */
    public function getAppreciationGenerale()
    {
        return $this->appreciationGenerale;
    }

    /**
     * @param $appreciationGenerale
     * @return $this
     */
    public function setAppreciationGenerale($appreciationGenerale)
    {
        $this->appreciationGenerale = $appreciationGenerale;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getEvolutionIndemnitaire()
    {
        return $this->evolutionIndemnitaire;
    }

    /**
     * @param $evolutionIndemnitaire
     * @return $this
     */
    public function setEvolutionIndemnitaire($evolutionIndemnitaire)
    {
        $this->evolutionIndemnitaire = $evolutionIndemnitaire;

        return $this;
    }

    public static $selectTypologieFormation = [
            'Adaptation immédiate au poste de travail (T1)' => 0,
            'Evolution prévisible du métier (T2)' => 1,
            'Développement ou acquisition de nouvelles compétences s’inscrivant dans un projet professionnel (T3)' => 2,
    ];

    public static $echelleObjectifEvalue = [
            'Atteint' => 0,
            'Partiellement Atteint' => 1,
            'Non atteint' => 2,
            'Devenu sans objet' => 3,
    ];

    public static $echelleNiveauDifficulte = [
            'Faibles' => 0,
            'Moyennes' => 1,
            'Fortes' => 2,
            'Très fortes' => 3,
            'Non pertinent' => 4,
    ];

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
     * @return $this
     */
    public function setMotifAbsenceEntretien($motifAbsenceEntretien)
    {
        $this->motifAbsenceEntretien = $motifAbsenceEntretien;

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

    public function __construct()
    {
        parent::init();
        $this->objectifsEvaluesCollectifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsEvaluesIndividuels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsFutursCollectifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsFutursIndividuels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function initialiser(Agent $agent, $em)
    {
        //Initialisation du référentiel des contraintes du poste
        $this->addContraintesPostes(new CrepEddContraintePoste('Besoin d’accompagnement des agents aux missions de la structure'));
        $this->addContraintesPostes(new CrepEddContraintePoste('Relations avec des partenaires extérieurs'));
        $this->addContraintesPostes(new CrepEddContraintePoste('Tâches de gestion lourdes'));
        $this->addContraintesPostes(new CrepEddContraintePoste('Délais impératifs'));
        $this->addContraintesPostes(new CrepEddContraintePoste('Gestion des ressources humaines'));
        $this->addContraintesPostes(new CrepEddContraintePoste('Gestion budgétaire et comptable'));

        //test
        //$objectif=new CrepEddObjectifEvalueCollectif();
        //$objectif->setLibelle("obj1");
        //$objectif->setResultatObtenu(1);
        //$this->addObjectifsEvaluesCollectif($objectif);

        // Initialisation du référentiel connaissances professionnelles requises sur le poste
        $this->addCompetencesTransversesRequise(new CrepEddCompetenceTransverseRequise('Juridique'));
        $this->addCompetencesTransversesRequise(new CrepEddCompetenceTransverseRequise('Budgétaires et financières'));
        $this->addCompetencesTransversesRequise(new CrepEddCompetenceTransverseRequise('Ressources humaines'));
        $this->addCompetencesTransversesRequise(new CrepEddCompetenceTransverseRequise('Internationales et européennes'));

        //Initialisation du référentiel compétences managériales
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à décider en situation complexe'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Implication personnelle et engagement'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Adaptabilité'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Contrôle de soi et exemplarité comportementale'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Force de conviction'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à conduire le changement'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Ecoute'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à développer les compétences et à déléguer'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à communiquer'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à coopérer avec l’environnement'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à conseiller'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Sens de l’intérêt général'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Capacité à développer une vision stratégique et à anticiper'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Ouverture d’esprit et capacité à se remettre en question'));
        $this->addCompetencesManageriale(new CrepEddCompetenceManageriale('Imagination et goût pour l’innovation'));

        $this->initialiserParent($agent, $em);
        $this->setNomUsage($agent->getNom());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setGrade($agent->getGrade());
        $this->setCorps($agent->getCorps());
        $this->setEchelon($agent->getEchelon());
        $this->setPosteOccupeAgent($agent->getPosteOccupe());
        $this->setDirection($agent->getAffectation());

        $shd = $this->getAgent()->getShd();
        if ($shd) {
            $this
                ->setNomUsageShd($shd->getNom())
                ->setPrenomShd($shd->getPrenom())
                ->setPosteOccupeShd($shd->getPosteOccupe());
        } else {
            $this
                ->setNomUsageShd(null)
                ->setPrenomShd(null)
                ->setPosteOccupeShd(null);
        }
    }

    public function actualiserDonneesShd()
    {
    }

    //Fonction qui définit la règle de nommage du CREP pdf
    public function getPdfFileName()
    {
        if ($this->agent->getMatricule()) {
            $anneeEvaluation = $this->agent->getCampagnePnc()->getAnneeEvaluee();
            $filename = $this->agent->getMatricule().'_'.strtoupper(Converter::convertStringToProgressio($this->nomUsage)).'_CREP'.$anneeEvaluation.'.pdf';
        } else {
            $this->agent->getPdfFileName();
        }

        return $filename;
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
    }

    public function confidentialisationChampsAgent()
    {
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    public function confidentialisationChampsAh()
    {
        $this->setObservationsAh(null);
    }

    /**
     * @Assert\Callback
     */
    public function validateCrepEdd(ExecutionContextInterface $context, $autreCompetenceDetenue)
    {
        // Cette variable calucle le nombre de compétences (requises, professionnelles et manageriales) dont le niveau acquis est exceptionnelle
        $nbCompetenceNiveauExceptionnelle = 0;
        /* @var $competenceRequise CrepEddCompetenceTransverseRequise  */
        foreach ($this->competencesTransversesRequises as $competenceRequise) {
            if (null !== $competenceRequise->getNiveauAcquis()
                && 0 == $competenceRequise->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $autreCompetenceRequise CrepEddAutreCompetenceTransverseRequise  */
        foreach ($this->autresCompetencesTransversesRequises as $autreCompetenceRequise) {
            if ($autreCompetenceRequise->getLibelle()
                && null !== $autreCompetenceRequise->getNiveauAcquis()
                && 0 == $autreCompetenceRequise->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $competenceManageriale CrepEddCompetenceManageriale  */
        foreach ($this->competencesManageriales as $competenceManageriale) {
            if (null !== $competenceManageriale->getNiveauAcquis()
                && 0 == $competenceManageriale->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $autreCompetenceManageriale CrepEddAutreCompetenceManagerialeExclu  */
        foreach ($this->autresCompetencesManageriales as $autreCompetenceManageriale) {
            if ($autreCompetenceManageriale->getLibelle()
                && null !== $autreCompetenceManageriale->getNiveauAcquis()
                && 0 == $autreCompetenceManageriale->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $technique CrepEddTechnique */
        foreach ($this->techniques as $technique) {
            if ($technique->getLibelle()
                && null !== $technique->getNiveauAcquis()
                && 0 == $technique->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /*  *****   VALIDATION: Nombre de compétences dont le niveau acquis est à Exceptionnel ne doit pas dépasser 5  ***** */
        if ($nbCompetenceNiveauExceptionnelle > 5) {
            $context->buildViolation('Le nombre de coches figurant dans la colonne "Exceptionnelle" des tableaux de cette rubrique ne doit pas dépasser 5')
                ->setParameter('cause', 'nbCompetenceNiveauExceptionnelle')
                ->addViolation();
        }

        /*  *****   VALIDATION: nbBureauxDirection   ***** */
        if (null !== $this->nbBureauxDirection && !preg_match('/^[0-9][0-9]*$/', $this->nbBureauxDirection)) {
            $context->buildViolation('Veuillez saisir un nombre')
                ->atPath('nbBureauxDirection')
                ->addViolation();
        }

        /*  *****   VALIDATION: nbCadresEncadresA   ***** */
        if (null !== $this->nbCadresEncadresA && !preg_match('/^[0-9][0-9]*$/', $this->nbCadresEncadresA)) {
            $context->buildViolation('Veuillez saisir un nombre')
                ->atPath('nbCadresEncadresA')
                ->addViolation();
        }

        /*  *****   VALIDATION: nbTotalAgentsEncadres   ***** */
        if (null !== $this->nbTotalAgentsEncadres && !preg_match('/^[0-9][0-9]*$/', $this->nbTotalAgentsEncadres)) {
            $context->buildViolation('Veuillez saisir un nombre')
                ->atPath('nbTotalAgentsEncadres')
                ->addViolation();
        }
    }
}
