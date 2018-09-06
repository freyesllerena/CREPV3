<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Util\Util;

/**
 * CrepMso5.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository")
 */
class CrepMso5 extends Crep
{

    public static $echelleObjectifEvalue = [
        'Atteint' => 0,
        'Partiellement Atteint' => 1,
        'Non atteint' => 2,
        'Devenu sans objet' => 3,
    ];

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA")
     */
    protected $dateEntretien;

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
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $categorie;

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
     * @ORM\Column(type="string", length=30)
     */
    protected $echelon;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $directionAffectation;

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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    protected $telephoneShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    protected $emailShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupeAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $fonctionsExercees;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $postionDansStructure;

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
    protected $commentaireFonctionAgent;

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
    protected $agentsEncadres;

    /**
     * @var text
     *
     * @ORM\Column(type="text", name="perspectives_evol_fonction")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $perspectivesEvolutionFonction;

    /**
     * @var text
     *
     * @ORM\Column(name="obs_agent_sur_son_activite",type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $observationsAgentSurSonActivite;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsShd;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5ObjectifEvalueCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5ObjectifEvalueIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesIndividuels;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5AutresObjectifsEvalue", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresObjectifsEvalues;

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
    protected $appreciationEvaluateur;

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
    protected $elementsParticuliers;

    /**
     * @var text
     *
     * @ORM\Column(name="Obs_agent_objectifs_passses", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $observationsAgentObjectifsPasses;

    /**
     * @var text
     *
     * @ORM\Column(name="obs_objectifs_passes", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $observationsObjectifsPasses;

    /**
     * @var string
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
     * @ORM\OneToMany(targetEntity="CrepMso5ObjectifFuturCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsFutursCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5ObjectifFuturIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsFutursIndividuels;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5AutresObjectifsFutur", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresObjectifsFuturs;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_demontrees")
     * @Assert\Length(
     *
     *
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesDemontrees;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_aut_comp_transverses")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $autresCompetencesPro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="comm_agent_evolution")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $evolutionsPro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="echeance_evol_pro")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $echeanceEvolutionsPro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="observation_shd_evolution")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsEvolutionsPro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="echeance_observations_evol_pro")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $echeanceObservationsEvolutionsPro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="avis_shd_avancement_grade")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $avisShdAvancementGrade;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_requises")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $competencesRequisesImmediatement;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_actions")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $competencesRequisesFutur;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5FormationSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsSuivies;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationT1", mappedBy="crep", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsT1;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationT2", mappedBy="crep", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsT2;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationT3", mappedBy="crep", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsT3;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5FormationPreparationConcours", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsPreparationConcours;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5FormationAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAutres;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso5CompetenceTransverse", mappedBy="crepMso5", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransverses;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciationShd;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciationAh;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $propositionPromotion;

    public function __construct()
    {
        parent::init();

        $this->objectifsEvaluesCollectifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsEvaluesIndividuels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->autresObjectifsEvalues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsFutursCollectifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsFutursIndividuels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->autresObjectifsFuturs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsSuivies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsPreparationConcours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesTransverses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $this->setPrenom($agent->getPrenom());
        $this->setNomUsage($agent->getNom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setCategorie($agent->getCategorieAgent());
        $this->setCorps($agent->getCorps());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDirectionAffectation($agent->getAffectation());
        $this->setPosteOccupeAgent($agent->getPosteOccupe());
        $this->setDatePriseFonctions($agent->getDateEntreePosteOccupe());

        if ($agent->getShd()) {
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setNomUsageShd($agent->getShd()->getNom());
            $this->setCorpsShd($agent->getShd()->getCorps());
            $this->setGradeShd($agent->getShd()->getGrade());
        }

        // initialisation des competences transverses (VI – VALEUR PROFESSIONNELLE - Appréciation de la valeur professionnelle de l’agent)
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Résultats obtenus par rapport aux objectifs assignés initialement ou révisés", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Compétences techniques", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Efficacité", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Qualités relationnelles dans l’exercice des fonctions", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Capacités d’initiative", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Capacités d’adaptation", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Capacités d’organisation du travail", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Sens du service public", "Générale"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Capacités à animer, à gérer, et contrôler une équipe", "Fonction d'encadrement"));
        $this->addCompetencesTransverse(new CrepMso5CompetenceTransverse("Capacités à exercer des responsabilités de niveau supérieur", "Catégories d'agents"));
    }

    /**
     * @return \DateTime
     */
    public function getDateEntretien()
    {
        return $this->dateEntretien;
    }

    /**
     * @param \DateTime $dateEntretien
     */
    public function setDateEntretien($dateEntretien)
    {
        $this->dateEntretien = $dateEntretien;
    }

    /**
     * @return  string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param $prenom
     *
     * @return CrepMso5
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
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
     * @return CrepMso5
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * Get dateNaissance.
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateNaissance.
     *
     * @param \DateTime $dateNaissance
     *
     * @return CrepMso5
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get categorie.
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set categorie.
     *
     * @param string $categorie
     *
     * @return CrepMso5
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * @param string $corps
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * Get echelon
     *
     * @return   string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * @param   $echelon
     *
     * @return  $echelon
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get DirectionAffectation
     * @return   string
     */
    public function getDirectionAffectation()
    {
        return $this->directionAffectation;
    }

    /**
     * @param   $directionAffectation
     *
     * return   $directionAffectation
     */
    public function setDirectionAffectation($directionAffectation)
    {
        $this->directionAffectation = $directionAffectation;

        return $this;
    }

    /**
     * @return \DateTime
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
     * @return string
     */
    public function getNomUsageShd()
    {
        return $this->nomUsageShd;
    }

    /**
     * @param $nomUsageShd
     *
     * @return CrepMso5
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;

        return $this;
    }

    /**
     * @return   string
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     *
     * @param $prenomShd
     *
     * @return $prenomShd
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;

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
     *
     * @param $posteOccupeShd
     *
     * @return $posteOccupeShd
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;

        return $this;
    }

    /**
     * Get emailShd.
     *
     * @return string
     */
    public function getEmailShd()
    {
        return $this->emailShd;
    }

    /**
     * Set emailShd.
     *
     * @param string $emailShd
     *
     * @return CrepMso5
     */
    public function setEmailShd($emailShd)
    {
        $this->emailShd = $emailShd;

        return $this;
    }

    /**
     * @return  integer
     */
    public function getTelephoneShd()
    {
        return $this->telephoneShd;
    }

    /**
     * @param  integer $telephoneShd
     *
     * @return CrepMso5
     */
    public function setTelephoneShd($telephoneShd)
    {
        $this->telephoneShd = $telephoneShd;

        return $this;
    }


    /**
     * @return string
     */
    public function getCorpsShd()
    {
        return $this->corpsShd;
    }

    /**
     * @param $corpsShd
     * @return $this
     */
    public function setCorpsShd($corpsShd)
    {
        $this->corpsShd = $corpsShd;
        return $this;
    }

    /**
     * @param   $gradeShd
     * @return $this
     */
    public function setGradeShd($gradeShd)
    {
        $this->gradeShd = $gradeShd;

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
     * @return CrepMso5
     */
    public function setPosteOccupeAgent($posteOccupeAgent)
    {
        $this->posteOccupeAgent = $posteOccupeAgent;

        return $this;
    }

    /**
     * Get fonctionsExercees
     *
     * @return string
     */
    public function getFonctionsExercees()
    {
        return $this->fonctionsExercees;
    }

    /**
     * Set fonctionsExercees
     *
     * @param string $fonctionsExercees
     * @return $this
     */
    public function setFonctionsExercees($fonctionsExercees)
    {
        $this->fonctionsExercees = $fonctionsExercees;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostionDansStructure()
    {
        return $this->postionDansStructure;
    }

    /**
     * @param $postionDansStructure
     *
     * @return CrepMso5
     */
    public function setPostionDansStructure($postionDansStructure)
    {
        $this->postionDansStructure = $postionDansStructure;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommentaireFonctionAgent()
    {
        return $this->commentaireFonctionAgent;
    }

    /**
     * @param   $commentaireFonctionAgent
     *
     * @return CrepMso5
     */
    public function setCommentaireFonctionAgent($commentaireFonctionAgent)
    {
        $this->commentaireFonctionAgent = $commentaireFonctionAgent;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgentsEncadres()
    {
        return $this->agentsEncadres;
    }

    /**
     * @param   $agentsEncadres
     *
     * @return CrepMso5
     */
    public function setAgentsEncadres($agentsEncadres)
    {
        $this->agentsEncadres = $agentsEncadres;

        return $this;
    }

    /**
     * Get perspectivesEvolutionFonction
     *
     * @return string
     */
    public function getperspectivesEvolutionFonction()
    {
        return $this->perspectivesEvolutionFonction;
    }

    /**
     * Set perspectivesEvolutionFonction
     *
     * @param string $perspectivesEvolutionFonction
     *
     * @return CrepMso5
     */
    public function setPerspectivesEvolutionFonction($perspectivesEvolutionFonction)
    {
        $this->perspectivesEvolutionFonction = $perspectivesEvolutionFonction;

        return $this;
    }

    /**
     * Get observationsAgentSurSonActivite
     *
     * @return string
     */
    public function getobservationsAgentSurSonActivite()
    {
        return $this->observationsAgentSurSonActivite;
    }

    /**
     * Set observationsAgentSurSonActivite.
     *
     * @param string $observationsAgentSurSonActivite
     *
     * @return CrepMso5
     */
    public function setObservationsAgentSurSonActivite($observationsAgentSurSonActivite)
    {
        $this->observationsAgentSurSonActivite = $observationsAgentSurSonActivite;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservationsShd()
    {
        return $this->observationsShd;
    }

    /**
     * @param string $observationsShd
     */
    public function setObservationsShd($observationsShd)
    {
        $this->observationsShd = $observationsShd;
    }

    /**
     * Add objectifsEvalueCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueCollectif $objectifsEvalueCollectif
     *
     * @return CrepMso5
     */
    public function addObjectifsEvaluesCollectif(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueCollectif $objectifsEvalueCollectif)
    {
        $this->objectifsEvaluesCollectifs[] = $objectifsEvalueCollectif;
        $objectifsEvalueCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueCollectif $objectifsEvalueCollectif
     */
    public function removeObjectifsEvaluesCollectif(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueCollectif $objectifsEvalueCollectif)
    {
        $this->objectifsEvaluesCollectifs->removeElement($objectifsEvalueCollectif);
        $objectifsEvalueCollectif->setCrep(null);
    }

    /**
     * Get objectifsEvalues.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsEvaluesCollectifs()
    {
        return $this->objectifsEvaluesCollectifs;
    }

    /**
     * Add autresObjectifsEvalue.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsEvalue $autresObjectifsEvalue
     *
     * @return CrepMso5
     */
    public function addAutresObjectifsEvalue(\AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsEvalue $autresObjectifsEvalue)
    {
        $this->autresObjectifsEvalues[] = $autresObjectifsEvalue;
        $autresObjectifsEvalue->setCrep($this);

        return $this;
    }

    /**
     * Remove autresObjectifsEvalue.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsEvalue $autresObjectifsEvalue
     */
    public function removeAutresObjectifsEvalue(\AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsEvalue $autresObjectifsEvalue)
    {
        $this->autresObjectifsEvalues->removeElement($autresObjectifsEvalue);
        $autresObjectifsEvalue->setCrep(null);
    }

    /**
     * Get autresObjectifsEvalues.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresObjectifsEvalues()
    {
        return $this->autresObjectifsEvalues;
    }

    /**
     * Add objectifsEvalueIndividuel.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     *
     * @return CrepMso5
     */
    public function addObjectifsEvaluesIndividuel(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueIndividuel $objectifsEvalueIndividuel)
    {
        $this->objectifsEvaluesIndividuels[] = $objectifsEvalueIndividuel;
        $objectifsEvalueIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueIndividuel.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     */
    public function removeObjectifsEvaluesIndividuel(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueIndividuel $objectifsEvalueIndividuel)
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
     * Add objectifsFuturCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturCollectif $objectifsFuturCollectif
     *
     * @return CrepMso5
     */
    public function addObjectifsFutursCollectif(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturCollectif $objectifsFuturCollectif)
    {
        $this->objectifsFutursCollectifs[] = $objectifsFuturCollectif;
        $objectifsFuturCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturCollectif.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturCollectif $objectifsFuturCollectif
     */
    public function removeObjectifsFutursCollectif(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturCollectif $objectifsFuturCollectif)
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
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturIndividuel $objectifsFuturIndividuel
     *
     * @return CrepMso5
     */
    public function addObjectifsFutursIndividuel(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturIndividuel $objectifsFuturIndividuel)
    {
        $this->objectifsFutursIndividuels[] = $objectifsFuturIndividuel;
        $objectifsFuturIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturIndividuel.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturIndividuel $objectifsFuturIndividuel
     */
    public function removeObjectifsFutursIndividuel(\AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifFuturIndividuel $objectifsFuturIndividuel)
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
     * Add autresObjectifsFutur.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsFutur $autresObjectifsFutur
     *
     * @return CrepMso5
     */
    public function addAutresObjectifsFutur(\AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsFutur $autresObjectifsFutur)
    {
        $this->autresObjectifsFuturs[] = $autresObjectifsFutur;
        $autresObjectifsFutur->setCrep($this);

        return $this;
    }

    /**
     * Remove autresObjectifsFutur.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsFutur $autresObjectifsFutur
     */
    public function removeAutresObjectifsFutur(\AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsFutur $autresObjectifsFutur)
    {
        $this->autresObjectifsFuturs->removeElement($autresObjectifsFutur);
        $autresObjectifsFutur->setCrep(null);
    }

    /**
     * Get autresObjectifsFuturs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresObjectifsFuturs()
    {
        return $this->autresObjectifsFuturs;
    }

    /**
     * Get appreciationEvaluateur
     *
     * @return string
     */
    public function getAppreciationEvaluateur()
    {
        return $this->appreciationEvaluateur;
    }

    /**
     * Set appreciationEvaluateur
     *
     * @param string $appreciationEvaluateur
     * @return $this
     */
    public function setAppreciationEvaluateur($appreciationEvaluateur)
    {
        $this->appreciationEvaluateur = $appreciationEvaluateur;

        return $this;
    }

    /**
     * Get elementsParticuliers
     *
     * @return string
     */
    public function getelementsParticuliers()
    {
        return $this->elementsParticuliers;
    }

    /**
     * Set elementsParticuliers
     *
     * @param string $elementsParticuliers
     * @return $this
     */
    public function setElementsParticuliers($elementsParticuliers)
    {
        $this->elementsParticuliers = $elementsParticuliers;

        return $this;
    }

    /**
     * Get observationsAgentObjectifsPasses
     *
     * @return string
     */
    public function getObservationsAgentObjectifsPasses()
    {
        return $this->observationsAgentObjectifsPasses;
    }

    /**
     * Set observationsAgentObjectifsPasses
     *
     * @param string $observationsAgentObjectifsPasses
     * @return $this
     */
    public function setObservationsAgentObjectifsPasses($observationsAgentObjectifsPasses)
    {
        $this->observationsAgentObjectifsPasses = $observationsAgentObjectifsPasses;

        return $this;
    }

    /**
     * Get observationsObjectifsPasses
     *
     * @return string
     */
    public function getObservationsObjectifsPasses()
    {
        return $this->observationsObjectifsPasses;
    }

    /**
     * Set observationsObjectifsPasses
     *
     * @param string $observationsObjectifsPasses
     * @return $this
     */
    public function setObservationsObjectifsPasses($observationsObjectifsPasses)
    {
        $this->observationsObjectifsPasses = $observationsObjectifsPasses;

        return $this;
    }

    /**
     * Get evolutionsPro
     *
     * @return string
     */
    public function getEvolutionsPro()
    {
        return $this->evolutionsPro;
    }

    /**
     * Set evolutionsPro
     *
     * @param string $evolutionsPro
     *
     * @return CrepMso5
     */
    public function setEvolutionsPro($evolutionsPro)
    {
        $this->evolutionsPro = $evolutionsPro;

        return $this;
    }

    /**
     * Get echeanceEvolutionsPro
     *
     * @return string
     */
    public function getEcheanceEvolutionsPro()
    {
        return $this->echeanceEvolutionsPro;
    }

    /**
     * Set echeanceEvolutionsPro
     *
     * @param string $echeanceEvolutionsPro
     *
     * @return CrepMso5
     */
    public function setEcheanceEvolutionsPro($echeanceEvolutionsPro)
    {
        $this->echeanceEvolutionsPro = $echeanceEvolutionsPro;

        return $this;
    }

    /**
     * Get observationsEvolutionsPro
     *
     * @return string
     */
    public function getObservationsEvolutionsPro()
    {
        return $this->observationsEvolutionsPro;
    }

    /**
     * Set observationsEvolutionsPro
     *
     * @param string $observationsEvolutionsPro
     *
     * @return CrepMso5
     */
    public function setObservationsEvolutionsPro($observationsEvolutionsPro)
    {
        $this->observationsEvolutionsPro = $observationsEvolutionsPro;

        return $this;
    }

    /**
     * Get echeanceObservationsEvolutionsPro
     *
     * @return string
     */
    public function getEcheanceObservationsEvolutionsPro()
    {
        return $this->echeanceObservationsEvolutionsPro;
    }

    /**
     * Set echeanceObservationsEvolutionsPro
     *
     * @param string $echeanceObservationsEvolutionsPro
     *
     * @return CrepMso5
     */
    public function setEcheanceObservationsEvolutionsPro($echeanceObservationsEvolutionsPro)
    {
        $this->echeanceObservationsEvolutionsPro = $echeanceObservationsEvolutionsPro;

        return $this;
    }

    /**
     * Get avisShdAvancementGrade
     *
     * @return string
     */
    public function getAvisShdAvancementGrade()
    {
        return $this->avisShdAvancementGrade;
    }

    /**
     * Set avisShdAvancementGrade
     *
     * @param string $avisShdAvancementGrade
     *
     * @return CrepMso5
     */
    public function setAvisShdAvancementGrade($avisShdAvancementGrade)
    {
        $this->avisShdAvancementGrade = $avisShdAvancementGrade;

        return $this;
    }

    /**
     * Get competencesRequisesImmediatement
     *
     * @return string
     */
    public function getCompetencesRequisesImmediatement()
    {
        return $this->competencesRequisesImmediatement;
    }

    /**
     * Set competencesRequisesImmediatement
     *
     * @param string $competencesRequisesImmediatement
     *
     * @return CrepMso5
     */
    public function setCompetencesRequisesImmediatement($competencesRequisesImmediatement)
    {
        $this->competencesRequisesImmediatement = $competencesRequisesImmediatement;

        return $this;
    }

    /**
     * Get competencesRequisesImmediatement
     *
     * @return string
     */
    public function getCompetencesRequisesFutur()
    {
        return $this->competencesRequisesFutur;
    }

    /**
     * Set competencesRequisesFutur
     *
     * @param string $competencesRequisesFutur
     *
     * @return CrepMso5
     */
    public function setCompetencesRequisesFutur($competencesRequisesFutur)
    {
        $this->competencesRequisesFutur = $competencesRequisesFutur;

        return $this;
    }

    /**
     * Get observationsCompetencesDemontrees
     *
     * @return string
     */
    public function getObservationsCompetencesDemontrees()
    {
        return $this->observationsCompetencesDemontrees;
    }

    /**
     * Set observationsCompetencesDemontrees
     *
     * @param string $observationsCompetencesDemontrees
     *
     * @return CrepMso5
     */
    public function setobservationsCompetencesDemontrees($observationsCompetencesDemontrees)
    {
        $this->observationsCompetencesDemontrees = $observationsCompetencesDemontrees;

        return $this;
    }

    /**
     * Get autresCompetencesPro
     *
     * @return string
     */
    public function getAutresCompetencesPro()
    {
        return $this->autresCompetencesPro;
    }

    /**
     * Set autresCompetencesPro
     *
     * @param string $autresCompetencesPro
     *
     * @return CrepMso5
     */
    public function setAutresCompetencesPro($autresCompetencesPro)
    {
        $this->autresCompetencesPro = $autresCompetencesPro;

        return $this;
    }

    /**
     * Add formationsT1.
     *
     * @param CrepMso5FormationT1 $formationsT1
     *
     * @return $this
     */
    public function addFormationsT1(CrepMso5FormationT1 $formationsT1)
    {
        $this->formationsT1[] = $formationsT1;

        $formationsT1->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT1.
     *
     * @param CrepMso5FormationT1 $formationsT1
     */
    public function removeFormationsT1(CrepMso5FormationT1 $formationsT1)
    {
        $this->formationsT1->removeElement($formationsT1);

        $formationsT1->setCrep(null);
    }

    /**
     * Get formationsT1.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsT1()
    {
        return $this->formationsT1;
    }

    /**
     * Add formationsT2.
     *
     * @param CrepMso5FormationT2 $formationsT2
     *
     * @return $this
     */
    public function addFormationsT2(CrepMso5FormationT2 $formationsT2)
    {
        $this->formationsT2[] = $formationsT2;

        $formationsT2->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT2.
     *
     * @param CrepMso5FormationT2 $formationsT2
     */
    public function removeFormationsT2(CrepMso5FormationT2 $formationsT2)
    {
        $this->formationsT2->removeElement($formationsT2);

        $formationsT2->setCrep(null);
    }

    /**
     * Get formationsT2.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsT2()
    {
        return $this->formationsT2;
    }

    /**
     * Add formationsT3.
     *
     * @param CrepMso5FormationT3 $formationsT3
     *
     * @return $this
     */
    public function addFormationsT3(CrepMso5FormationT3 $formationsT3)
    {
        $this->formationsT3[] = $formationsT3;

        $formationsT3->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT3.
     *
     * @param CrepMso5FormationT3 $formationsT3
     */
    public function removeFormationsT3(CrepMso5FormationT3 $formationsT3)
    {
        $this->formationsT3->removeElement($formationsT3);

        $formationsT3->setCrep(null);
    }

    /**
     * Get formationsT3.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsT3()
    {
        return $this->formationsT3;
    }

    /**
     * Add formationsPreparationConcour.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationPreparationConcours $formationsPreparationConcour
     *
     * @return CrepMso5
     */
    public function addFormationsPreparationConcour(\AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationPreparationConcours $formationsPreparationConcour)
    {
        $this->formationsPreparationConcours[] = $formationsPreparationConcour;

        $formationsPreparationConcour->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsPreparationConcour.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationPreparationConcours $formationsPreparationConcour
     */
    public function removeFormationsPreparationConcour(\AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationPreparationConcours $formationsPreparationConcour)
    {
        $this->formationsPreparationConcours->removeElement($formationsPreparationConcour);

        $formationsPreparationConcour->setCrep(null);
    }

    /**
     * Get formationsPreparationConcours.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsPreparationConcours()
    {
        return $this->formationsPreparationConcours;
    }

    /**
     * Add formationsAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationAutre $formationsAutre
     *
     * @return CrepMso5
     */
    public function addFormationsAutre(\AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationAutre $formationsAutre)
    {
        $this->formationsAutres[] = $formationsAutre;

        $formationsAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationAutre $formationsAutre
     */
    public function removeFormationsAutre(\AppBundle\Entity\Crep\CrepMso5\CrepMso5FormationAutre $formationsAutre)
    {
        $this->formationsAutres->removeElement($formationsAutre);

        $formationsAutre->setCrep(null);
    }

    /**
     * Get formationsAutres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsAutres()
    {
        return $this->formationsAutres;
    }

    /**
     * Add competenceProfessionnelle.
     *
     * @param CrepMso5CompetenceProfessionnelle $competencesProfessionnelle
     *
     * @return CrepMso5
     */
    public function addCompetencesProfessionnelle(CrepMso5CompetenceProfessionnelle $competenceProfessionnelle)
    {
        $this->competencesProfessionnelles[] = $competenceProfessionnelle;
        $competenceProfessionnelle->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceProfessionnelle.
     *
     * @param CrepMso5CompetenceProfessionnelle $competenceProfessionnelle
     */
    public function removeCompetencesProfessionnelle(CrepMso5CompetenceProfessionnelle $competenceProfessionnelle)
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
     * Add competencesTransverse
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5CompetenceTransverse $competencesTransverse
     *
     * @return CrepMso5
     */
    public function addCompetencesTransverse(\AppBundle\Entity\Crep\CrepMso5\CrepMso5CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepMso5($this);

        return $this;
    }

    /**
     * Remove competencesTransverse
     *
     * @param \AppBundle\Entity\Crep\CrepMso5\CrepMso5CompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(\AppBundle\Entity\Crep\CrepMso5\CrepMso5CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepMso5(null);
    }

    /**
     * Get competencesTransverses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesTransverses()
    {
        return $this->competencesTransverses;
    }

    /**
     * Get appreciationShd
     *
     * @return string
     */
    public function getAppreciationShd()
    {
        return $this->appreciationShd;
    }

    /**
     * Set appreciationShd.
     *
     * @param string $appreciationShd
     *
     * @return CrepMso5
     */
    public function setAppreciationShd($appreciationShd)
    {
        $this->appreciationShd = $appreciationShd;

        return $this;
    }

    /**
     * Get appreciationAh
     *
     * @return string
     */
    public function getAppreciationAh()
    {
        return $this->appreciationAh;
    }

    /**
     * Set appreciationAh
     *
     * @param string $appreciationAh
     *
     * @return CrepMso5
     */
    public function setAppreciationAh($appreciationAh)
    {
        $this->appreciationAh = $appreciationAh;

        return $this;
    }

    /**
     * Get propositionPromotion
     *
     * @return string
     */
    public function getPropositionPromotion()
    {
        return $this->propositionPromotion;
    }

    /**
     * Set propositionPromotion
     *
     * @param string $propositionPromotion
     *
     * @return CrepMso5
     */
    public function setPropositionPromotion($propositionPromotion)
    {
        $this->propositionPromotion = $propositionPromotion;

        return $this;
    }

    /**
     * Méthode appelée lors d'un rattachement d'un nouveau N+1.
     */
    public function actualiserDonneesShd()
    {

    }

    public function confidentialisationChampsShd()
    {
        $this
            ->setPosteOccupeAgent(null)
            ->setposteOccupeShd(null)
            ->setFonctionsExercees(null)
            ->setPostionDansStructure(null)
            ->setCommentaireFonctionAgent(null)
            ->setAgentsEncadres(null)
            ->setPerspectivesEvolutionFonction(null)
            ->setObservationsAgentSurSonActivite(null)
            ->setObservationsShd(null);

        $this->objectifsEvaluesIndividuels->clear();
        $this->objectifsEvaluesCollectifs->clear();
        $this->autresObjectifsEvalues->clear();

        $this
            ->setAppreciationEvaluateur(null)
            ->setElementsParticuliers(null)
            ->setObservationsAgentObjectifsPasses(null)
            ->setObservationsObjectifsPasses(null);

        $this->objectifsFutursIndividuels->clear();
        $this->objectifsFutursCollectifs->clear();
        $this->autresObjectifsFuturs->clear();

        $this
            ->setobservationsCompetencesDemontrees(null)
            ->setAutresCompetencesPro(null)
            ->setEvolutionsPro(null)
            ->setEcheanceEvolutionsPro(null)
            ->setObservationsEvolutionsPro(null)
            ->setEcheanceObservationsEvolutionsPro(null)
            ->setAvisShdAvancementGrade(null)
            ->setCompetencesRequisesImmediatement(null)
            ->setCompetencesRequisesFutur(null);

        $this->formationsSuivies->clear();
        $this->formationsT1->clear();
        $this->formationsT2->clear();
        $this->formationsT3->clear();
        $this->formationsPreparationConcours->clear();
        $this->formationsAutres->clear();

        /** @var $competencesTransverse CrepMso5CompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $competencesTransverse) {
            $competencesTransverse->setNiveauAcquis(null);
        }

        $this
            ->setAppreciationShd(null)
            ->setAppreciationAh(null)
            ->setPropositionPromotion(null)
            ->setDateEntretien(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setObservationsVisaAgent(null);
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    public function confidentialisationChampsAh()
    {
        $this
            ->setAppreciationAh(null)
            ->setPropositionPromotion(null);

    }

    /**
     * Validation sur CrepMso5
     *
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validateCrepMso5(ExecutionContextInterface $context)
    {
        /*  *****   VALIDATION: année   ***** */
        $anneeEvaluation = parent::getAgent()->getCampagnePnc()->getAnneeEvaluee();
        //L'année doit être soit N, N-1 ou N-2 (N : l'année d'évaluation)
        /** @var FormationSuivie $formation */
        foreach ($this->formationsSuivies as $formation) {
            if (is_null($formation->getAnnee()) || ($formation->getAnnee() && !in_array($formation->getAnnee(), array($anneeEvaluation, $anneeEvaluation - 1, $anneeEvaluation - 2)))) {
                $context->buildViolation('Veuillez saisir une année valide')
                    ->setParameter('cause_formation', 'annee')
                    ->addViolation();
            }
        }

        if (!preg_match("#^([-/+,;. ]?[0-9]{1}){6,12}$#", $this->telephoneShd) && isset($this->telephoneShd)) {
            $context->buildViolation("Le champ Téléphone n'est pas au bon format")
                ->atPath('telephoneShd')
                ->addViolation();
        }

        if (isset($this->emailShd) && !Util::validerEmail($this->emailShd)) {
            $context->buildViolation('L\'email n\'est pas valide')
                ->atPath('emailShd')
                ->addViolation();
        }
    }
}
