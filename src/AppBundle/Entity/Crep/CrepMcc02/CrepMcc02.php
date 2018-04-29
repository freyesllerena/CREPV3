<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use AppBundle\Entity\MobiliteGeographique;
use AppBundle\Util\Converter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02AutreObjectif;

/**
 * CrepMcc02
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository")
 */
class CrepMcc02 extends Crep
{
    public static $echelleObjectifEvalue = [
        'Atteint' => 0,
        'Partiellement Atteint' => 1,
        'Non atteint' => 2,
        'Devenu sans objet' => 3,
    ];

    public static $niveauCompetence = [
        'exceptionnelle' => 0,
        'forte' => 1,
        'assez forte' => 2,
        'à développer' => 3,
        'non observée' => 4,
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
     */
    protected $serviceShd;

    /**
     * @var
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
     * @var integer
     * @ORM\Column(type="integer", name="marge_evol_comp_pro")
     */
    protected $margeEvolutionCompetencesProfessionnelles;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="marge_evol_aptitudes_pro")
     */
    protected $margeEvolutionAptitudesProfessionnelles;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="marge_evol_qualites_pro")
     */
    protected $margeEvolutionQualitesProfessionnelles;

    /**
     * @var integer
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
     * Grade du Supérieur hierarchique direct
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $gradeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $corpsShd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le poste non valide")
     */
    protected $dateEntreePosteOccupeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     */
    protected $groupeRifseep;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $fonctionsExercees;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $emploiFonctionnel;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $libelleEmploiFonctionnel;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $groupeEmploiFonctionnel;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     */
    protected $groupeFonctions;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $fichePosteAdaptee;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $docAnnexeObjectifsAvenir;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $docAnnexeBilan;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02AutreObjectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $autresObjectifs;


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
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $natureDossiersTravaux;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $resultatsObtenusParAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $contexteResultats;

    /**
     * @var
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $acquisExperiencePro;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères", groups={"EnregistrementShd"})
     */
    protected $pointsActualisesFichePoste;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02CompetenceAction", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesActions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02CompetenceRelation", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected c;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02CompetenceSituation", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesSituations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02CompetenceRequise", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesRequises;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMcc02\CrepMcc02CompetenceDemontree", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesDemontrees;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_actions")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesActions;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_relations")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesRelations;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_situations")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesSituations;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_requises")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesRequises;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_demontrees")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesDemontrees;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreePosteOccupe;

    /**
     * @ORM\OneToOne(targetEntity="CrepMcc02MobilitePoste", orphanRemoval=true, cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Valid
     */
    protected $mobilitePoste;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $souhaitEvolutionCarriere;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="evol_pro_envisagee", nullable=true)
     *
     */
    protected $evolutionProfessionnelleEnvisagee;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_shd_projet_pro")
     *
     */
    protected $observationsShdProjetProfessionnel;

    /**
     * @var
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
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $attributionCia;

    /**
     * @var
     *
     * @ORM\Column(type="text", name = "explication_attr_cia")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $explicationAttributionCia;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     *
     */
    protected $propositionAvancement;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_projet_pro")
     *
     */
    protected $observationsAgentProjetProfessionnel;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_objectifs_passes")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $observationsObjectifsPasses;

//    /**
//     * @ORM\OneToMany(targetEntity="ObjectifFuturCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
//     * @Assert\Valid
//     */
//    protected $objectifsFutursCollectifs;







    public function __construct()
    {
        parent::init();
        $this->competencesActions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesRelations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesSituations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesRequises = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesDemontrees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->autresObjectifs = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->objectifsFutursCollectifs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     *
     * @param $nomUsage
     * @return CrepMcc02
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     *
     * @param $lieu
     * @return CrepMcc02
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomNaissance()
    {
        return $this->nomNaissance;
    }

    /**
     *
     * @param $nomNaissance
     * @return CrepMcc02
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     *
     * @param $prenom
     * @return CrepMcc02
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     * @return CrepMcc02
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param $grade
     * @return $this
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
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
     * @param $corps
     * @return $this
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;
        return $this;
    }

    /**
     * @return string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * @param $echelon
     * @return $this
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    /**
     * @param $posteOccupe
     * @return $this
     */
    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;
        return $this;
    }

    /**
     * @return string
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * @param $affectation
     * @return $this
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
     * @param \DateTime|null $dateEntreePoste
     * @return $this
     */
    public function setDateEntreePoste(\DateTime $dateEntreePoste = null)
    {
        $this->dateEntreePoste = $dateEntreePoste;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomUsageShd()
    {
        return $this->nomUsageShd;
    }

    /**
     * @param $nomUsageShd
     * @return $this
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     * @param $prenomShd
     * @return $this
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;
        return $this;
    }

    /**
     * @return string
     */
    public function getAffectationShd()
    {
        return $this->affectationShd;
    }

    /**
     * @param $affectationShd
     * @return $this
     */
    public function setAffectationShd($affectationShd)
    {
        $this->affectationShd = $affectationShd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosteOccupeShd()
    {
        return $this->posteOccupeShd;
    }

    /**
     * @param $posteOccupeShd
     * @return $this
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;
        return $this;
    }


    /**
     * @param Agent $agent
     * @param $em
     */
    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $this->setPrenom($agent->getPrenom());
        $defaultNomAgent = $agent->getNom() ?? $agent->getNomNaissance();
        $this->setNomUsage($defaultNomAgent);

        $this->setDateNaissance($agent->getDateNaissance());
        $this->setCorps($agent->getCorps());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setPrenomShd($agent->getShd()->getPrenom());
        $defaultNomShd = $agent->getShd()->getNom() ?? $agent->getShd()->getNomNaissance();
        $this->setNomUsageShd($defaultNomShd);
        $this->setCorpsShd($agent->getShd()->getCorps());
        $this->setGradeShd($agent->getShd()->getGrade());
        $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
        $this->setDateEntreePosteOccupeShd($agent->getShd()->getDateEntreePosteOccupe());
        $this->setAffectation($agent->getAffectation());
        $this->setPosteOccupe($agent->getPosteOccupe());
        $this->setDateEntreePoste($agent->getDateEntreePosteOccupe());
        $this->setFonctionsExercees($this->getFonctionsExercees());

        // Initialisatiuon des compétences liées à l'action
        $competenceAction = new CrepMcc02CompetenceAction();
        $competenceAction->setLibelle('Capacité à décider en situation complexe');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepMcc02CompetenceAction();
        $competenceAction->setLibelle('Implication personnelle et engagement');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepMcc02CompetenceAction();
        $competenceAction->setLibelle('Adaptabilité');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepMcc02CompetenceAction();
        $competenceAction->setLibelle('Résistance au stress');
        $this->addCompetencesAction($competenceAction);

        // Initialisatiuon des compétences liées à la relation
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Force de conviction (leadership)');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Capacité à conduire le changement');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Écoute');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Capacité à développer les compétences et à déléguer');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Capacité à communiquer');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Capacité à coopérer avec l’environnement');
        $this->addCompetencesRelation($competenceRelation);
        $competenceRelation = new CrepMcc02CompetenceRelation();
        $competenceRelation->setLibelle('Capacité à conseiller');
        $this->addCompetencesRelation($competenceRelation);

        // Initialisatiuon des compétences liées à l'intelligences des situations
        $competenceSituation = new CrepMcc02CompetenceSituation();
        $competenceSituation->setLibelle('Sens de l’intérêt général');
        $this->addCompetencesSituation($competenceSituation);
        $competenceSituation = new CrepMcc02CompetenceSituation();
        $competenceSituation->setLibelle('Capacité à développer une vision stratégique et à anticiper');
        $this->addCompetencesSituation($competenceSituation);
        $competenceSituation = new CrepMcc02CompetenceSituation();
        $competenceSituation->setLibelle('Ouverture d’esprit et capacité à se remettre en question');
        $this->addCompetencesSituation($competenceSituation);
        $competenceSituation = new CrepMcc02CompetenceSituation();
        $competenceSituation->setLibelle('Imagination et goût pour l’innovation');
        $this->addCompetencesSituation($competenceSituation);

    }

    /**
     *
     */
    public function actualiserDonneesShd()
    {
    }

    /**
     *
     */
    public function confidentialisationChampsShd()
    {
    }

    /**
     *
     */
    public function confidentialisationChampsAgent()
    {
    }

    /**
     *
     */
    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    /**
     *
     */
    public function confidentialisationChampsAh()
    {
    }

    /**
     * @return string
     */
    public function getGradeShd()
    {
        return $this->gradeShd;
    }

    /**
     * @param $gradeShd
     * @return $this
     */
    public function setGradeShd($gradeShd)
    {
        $this->gradeShd = $gradeShd;
        return $this;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getDateEntreePosteOccupeShd()
    {
        return $this->dateEntreePosteOccupeShd;
    }

    /**
     * @param \DateTime $dateEntreePosteOccupeShd
     * @return $this
     */
    public function setDateEntreePosteOccupeShd($dateEntreePosteOccupeShd)
    {
        $this->dateEntreePosteOccupeShd = $dateEntreePosteOccupeShd;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeRifseep()
    {
        return $this->groupeRifseep;
    }


    /**
     * @param $GroupeRifseep
     * @return $this
     */
    public function setGroupeRifseep($GroupeRifseep)
    {
        $this->groupeRifseep = $GroupeRifseep;
        return $this;
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
     * Get fonctionsExercees
     *
     * @return string
     */
    public function getFonctionsExercees()
    {
        return $this->fonctionsExercees;
    }

    /**
     * @return bool
     */
    public function getEmploiFonctionnel()
    {
        return $this->emploiFonctionnel;
    }

    /**
     * @param $emploiFonctionnel
     * @return $this
     */
    public function setEmploiFonctionnel($emploiFonctionnel)
    {
        $this->emploiFonctionnel = $emploiFonctionnel;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleEmploiFonctionnel()
    {
        return $this->libelleEmploiFonctionnel;
    }

    /**
     * @param string $libelleEmploiFonctionnel
     * @return $this
     */
    public function setLibelleEmploiFonctionnel(string $libelleEmploiFonctionnel)
    {
        $this->libelleEmploiFonctionnel = $libelleEmploiFonctionnel;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeEmploiFonctionnel()
    {
        return $this->groupeEmploiFonctionnel;
    }

    /**
     * @param string $groupeEmploiFonctionnel
     * @return $this
     */
    public function setGroupeEmploiFonctionnel(string $groupeEmploiFonctionnel)
    {
        $this->groupeEmploiFonctionnel = $groupeEmploiFonctionnel;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeFonctions()
    {
        return $this->groupeFonctions;
    }

    /**
     * @param $groupeFonctions
     * @return $this
     */
    public function setGroupeFonctions($groupeFonctions)
    {
        $this->groupeFonctions = $groupeFonctions;
        return $this;
    }

    /**
     * Set fichePosteAdaptee
     *
     * @param $fichePosteAdaptee
     * @return $this
     */
    public function setFichePosteAdaptee($fichePosteAdaptee)
    {
        $this->fichePosteAdaptee = $fichePosteAdaptee;

        return $this;
    }

    /**
     * Get fichePosteAdaptee
     *
     * @return bool
     */
    public function getFichePosteAdaptee()
    {
        return $this->fichePosteAdaptee;
    }

    /**
     * @return bool
     */
    public function getDocAnnexeBilan()
    {
        return $this->docAnnexeBilan;
    }


    /**
     * @param $docAnnexeBilan
     * @return $this
     */
    public function setDocAnnexeBilan($docAnnexeBilan)
    {
        $this->docAnnexeBilan = $docAnnexeBilan;
        return $this;
    }

    /**
     * Get Renvoi à un document annexe (lettre de mission ou d’objectifs) :
     *
     * @return bool
     */
    public function getDocAnnexeObjectifsAvenir()
    {
        return $this->docAnnexeObjectifsAvenir;
    }

    /**
     * Set Renvoi à un document annexe (lettre de mission ou d’objectifs) :
     *
     * @param $docAnnexeObjectifsAvenir
     * @return $this
     */
    public function setDocAnnexeObjectifsAvenir($docAnnexeObjectifsAvenir)
    {
        $this->docAnnexeObjectifsAvenir = $docAnnexeObjectifsAvenir;
        return $this;
    }


    /**
     * Add autresObjectif
     *
     * @param CrepMcc02AutreObjectif $objectif
     *
     * @return CrepMcc02
     */
    public function addAutresObjectif(CrepMcc02AutreObjectif $objectif)
    {
        $this->autresObjectifs[] = $objectif;
        $objectif->setCrep($this);

        return $this;
    }

    /**
     * Remove autresObjectif
     *
     * @param CrepMcc02AutreObjectif $objectif
     */
    public function removeAutresObjectif(CrepMcc02AutreObjectif $objectif)
    {
        $this->autresObjectifs->removeElement($objectif);
        $objectif->setCrep(null);
    }

    /**
     * Get getAutresObjectifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresObjectifs()
    {
        return $this->autresObjectifs;
    }


    /**
     * Set natureDossiersTravaux
     *
     * @param $natureDossiersTravaux
     * @return $this
     */
    public function setNatureDossiersTravaux($natureDossiersTravaux)
    {
        $this->natureDossiersTravaux = $natureDossiersTravaux;

        return $this;
    }

    /**
     * Get natureDossiersTravaux
     *
     * @return string
     */
    public function getNatureDossiersTravaux()
    {
        return $this->natureDossiersTravaux;
    }


    /**
     * Set resultatsObtenusParAgent
     *
     * @param $resultatsObtenusParAgent
     * @return $this
     */
    public function setResultatsObtenusParAgent($resultatsObtenusParAgent)
    {
        $this->resultatsObtenusParAgent = $resultatsObtenusParAgent;

        return $this;
    }

    /**
     * Get resultatsObtenusParAgent
     *
     * @return string
     */
    public function getResultatsObtenusParAgent()
    {
        return $this->resultatsObtenusParAgent;
    }

    /**
     * Set contexteResultats
     *
     * @param $contexteResultats
     * @return $this
     */
    public function setContexteResultats($contexteResultats)
    {
        $this->contexteResultats = $contexteResultats;

        return $this;
    }

    /**
     * Get contexteResultats
     *
     * @return string
     */
    public function getContexteResultats()
    {
        return $this->contexteResultats;
    }

    /**
     * @return mixed
     */
    public function getAcquisExperiencePro()
    {
        return $this->acquisExperiencePro;
    }

    /**
     * @param $acquisExperiencePro
     * @return $this
     */
    public function setAcquisExperiencePro($acquisExperiencePro)
    {
        $this->acquisExperiencePro = $acquisExperiencePro;
        return $this;
    }

    /**
     * @return string
     */
    public function getPointsActualisesFichePoste()
    {
        return $this->pointsActualisesFichePoste;
    }

    /**
     * @param $pointsActualisesFichePoste
     * @return $this
     */
    public function setPointsActualisesFichePoste($pointsActualisesFichePoste)
    {
        $this->pointsActualisesFichePoste = $pointsActualisesFichePoste;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContexteObjectifsAvenir()
    {
        return $this->contexteObjectifsAvenir;
    }

    /**
     * @param $contexteObjectifsAvenir
     * @return $this
     */
    public function setContexteObjectifsAvenir($contexteObjectifsAvenir)
    {
        $this->contexteObjectifsAvenir = $contexteObjectifsAvenir;
        return $this;
    }

    /**
     * Add competenceAction
     *
     * @param CrepMcc02CompetenceAction $competenceAction
     *
     * @return CrepMcc02
     */
    public function addCompetencesAction(CrepMcc02CompetenceAction $competenceAction)
    {
        $this->competencesActions[] = $competenceAction;
        $competenceAction->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceAction
     *
     * @param CrepMcc02CompetenceAction $competenceAction
     */
    public function removeCompetencesAction(CrepMcc02CompetenceAction $competenceAction)
    {
        $this->competencesActions->removeElement($competenceAction);
        $competenceAction->setCrep(null);
    }

    /**
     * Get competencesActions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesActions()
    {
        return $this->competencesActions;
    }

    /**
     * Get observationsCompetencesActions
     *
     * @return string
     */
    public function getObservationsCompetencesActions()
    {
        return $this->observationsCompetencesActions;
    }

    /**
     * Set observationsCompetencesActions
     *
     * @param string $observationsCompetencesActions
     *
     * @return CrepMcc02
     */
    public function setObservationsCompetencesActions($observationsCompetencesActions)
    {
        $this->observationsCompetencesActions = $observationsCompetencesActions;

        return $this;
    }

    /**
     * Add competenceRelation
     *
     * @param CrepMcc02CompetenceRelation $competenceRelation
     *
     * @return CrepMcc02
     */
    public function addCompetencesRelation(CrepMcc02CompetenceRelation $competenceRelation)
    {
        $this->competencesRelations[] = $competenceRelation;
        $competenceRelation->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceRelation
     *
     * @param CrepMcc02CompetenceRelation $competenceRelation
     */
    public function removeCompetencesRelation(CrepMcc02CompetenceRelation $competenceRelation)
    {
        $this->competencesRelations->removeElement($competenceRelation);
        $competenceRelation->setCrep(null);
    }

    /**
     * Get competencesRelations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesRelations()
    {
        return $this->competencesRelations;
    }

    /**
     * Get observationsCompetencesRelations
     *
     * @return string
     */
    public function getObservationsCompetencesRelations()
    {
        return $this->observationsCompetencesRelations;
    }

    /**
     * Set observationsCompetencesRelations
     *
     * @param string $observationsCompetencesRelations
     *
     * @return CrepMcc02
     */
    public function setObservationsCompetencesRelations($observationsCompetencesRelations)
    {
        $this->observationsCompetencesRelations = $observationsCompetencesRelations;

        return $this;
    }

    /**
     * Add competenceSituation
     *
     * @param CrepMcc02CompetenceSituation $competenceSituation
     *
     * @return CrepMcc02
     */
    public function addCompetencesSituation(CrepMcc02CompetenceSituation $competenceSituation)
    {
        $this->competencesSituations[] = $competenceSituation;
        $competenceSituation->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceSituation
     *
     * @param CrepMcc02CompetenceSituation $competenceSituation
     */
    public function removeCompetencesSituation(CrepMcc02CompetenceSituation $competenceSituation)
    {
        $this->competencesSituations->removeElement($competenceSituation);
        $competenceSituation->setCrep(null);
    }

    /**
     * Get competencesSituations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesSituations()
    {
        return $this->competencesSituations;
    }

    /**
     * Get observationsCompetencesSituations
     *
     * @return string
     */
    public function getObservationsCompetencesSituations()
    {
        return $this->observationsCompetencesSituations;
    }

    /**
     * Set observationsCompetencesSituations
     *
     * @param string $observationsCompetencesSituations
     *
     * @return CrepMcc02
     */
    public function setObservationsCompetencesSituations($observationsCompetencesSituations)
    {
        $this->observationsCompetencesSituations = $observationsCompetencesSituations;

        return $this;
    }

    /**
     * Add competenceRequise
     *
     * @param CrepMcc02CompetenceRequise $competenceRequise
     *
     * @return CrepMcc02
     */
    public function addCompetencesRequise(CrepMcc02CompetenceRequise $competenceRequise)
    {
        $this->competencesRequises[] = $competenceRequise;
        $competenceRequise->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceRequise
     *
     * @param CrepMcc02CompetenceRequise $competenceRequise
     */
    public function removeCompetencesRequise(CrepMcc02CompetenceRequise $competenceRequise)
    {
        $this->competencesRequises->removeElement($competenceRequise);
        $competenceRequise->setCrep(null);
    }

    /**
     * Get competencesRequises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesRequises()
    {
        return $this->competencesRequises;
    }

    /**
     * Get observationsCompetencesRequises
     *
     * @return string
     */
    public function getObservationsCompetencesRequises()
    {
        return $this->observationsCompetencesRequises;
    }

    /**
     * Set observationsCompetencesRequises
     *
     * @param string $observationsCompetencesRequises
     *
     * @return CrepMcc02
     */
    public function setObservationsCompetencesRequises($observationsCompetencesRequises)
    {
        $this->observationsCompetencesRequises = $observationsCompetencesRequises;

        return $this;
    }

    /**
     * Add competenceDemontree
     *
     * @param CrepMcc02CompetenceDemontree $competenceDemontree
     *
     * @return CrepMcc02
     */
    public function addCompetencesDemontree(CrepMcc02CompetenceDemontree $competenceDemontree)
    {
        $this->competencesDemontrees[] = $competenceDemontree;
        $competenceDemontree->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceDemontree
     *
     * @param CrepMcc02CompetenceDemontree $competenceDemontree
     */
    public function removeCompetencesDemontree(CrepMcc02CompetenceDemontree $competenceDemontree)
    {
        $this->competencesDemontrees->removeElement($competenceDemontree);
        $competenceDemontree->setCrep(null);
    }

    /**
     * Get competencesDemontrees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesDemontrees()
    {
        return $this->competencesDemontrees;
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
     * @return CrepMcc02
     */
    public function setObservationsCompetencesDemontrees($observationsCompetencesDemontrees)
    {
        $this->observationsCompetencesDemontrees = $observationsCompetencesDemontrees;

        return $this;
    }

    public function getDateEntreePosteOccupe()
    {
        return $this->dateEntreePosteOccupe;
    }

    public function setDateEntreePosteOccupe($dateEntreePosteOccupe)
    {
        $this->dateEntreePosteOccupe = Converter::convertDate($dateEntreePosteOccupe);
        return $this;
    }

    /**
     * @return CrepMcc02MobilitePoste
     */
    public function getMobilitePoste()
    {
        return $this->mobilitePoste;
    }

    /**
     * @param $mobilitePoste
     * @return $this
     */
    public function setMobilitePoste($mobilitePoste)
    {
        $this->mobilitePoste = $mobilitePoste;
        return $this;
    }

    /**
     * Get souhait évolution carriere
     *
     * @return bool
     */
    public function getSouhaitEvolutionCarriere()
    {
        return $this->souhaitEvolutionCarriere;
    }

    /**
     * Set souhait évolution carriere
     *
     * @param $souhaitEvolutionCarriere
     * @return $this
     */
    public function setSouhaitEvolutionCarriere($souhaitEvolutionCarriere)
    {
        $this->souhaitEvolutionCarriere = $souhaitEvolutionCarriere;
        return $this;
    }

    /**
     * @return string
     */
    public function getEvolutionProfessionnelleEnvisagee() {
        return $this->evolutionProfessionnelleEnvisagee;
    }

    /**
     * @param $evolutionProfessionnelleEnvisagee
     * @return $this
     */
    public function setEvolutionProfessionnelleEnvisagee($evolutionProfessionnelleEnvisagee) {
        $this->evolutionProfessionnelleEnvisagee = $evolutionProfessionnelleEnvisagee;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSouhaitEntretienCarriere()
    {
        return $this->souhaitEntretienCarriere;
    }

    /**
     *
     * @param $souhaitEntretienCarriere
     * @return $this
     */
    public function setSouhaitEntretienCarriere($souhaitEntretienCarriere)
    {
        $this->souhaitEntretienCarriere = $souhaitEntretienCarriere;
        return $this;
    }

    /**
     * Set contexteAnneeEcoulee
     *
     * @param $contexteAnneeEcoulee
     * @return $this
     */
    public function setContexteAnneeEcoulee($contexteAnneeEcoulee)
    {
        $this->contexteAnneeEcoulee = $contexteAnneeEcoulee;

        return $this;
    }

    /**
     * Get contexteAnneeEcoulee
     *
     * @return string
     */
    public function getContexteAnneeEcoulee()
    {
        return $this->contexteAnneeEcoulee;
    }

    /**
     * Set observationsShdProjetProfessionnel
     *
     * @param $observationsShdProjetProfessionnel
     * @return $this
     */
    public function setObservationsShdProjetProfessionnel($observationsShdProjetProfessionnel)
    {
        $this->observationsShdProjetProfessionnel = $observationsShdProjetProfessionnel;

        return $this;
    }

    /**
     * Get observationsShdProjetProfessionnel
     *
     * @return string
     */
    public function getObservationsShdProjetProfessionnel()
    {
        return $this->observationsShdProjetProfessionnel;
    }

    /**
     * @return mixed
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
     * Get AttributionCia
     *
     * @return bool
     */
    public function getAttributionCia() {
        return $this->attributionCia;
    }

    /**
     * Set AttributionCia
     *
     * @param $attributionCia
     * @return $this
     */
    public function setAttributionCia($attributionCia) {
        $this->attributionCia = $attributionCia;
        return $this;
    }

    /**
     * Get ExplicationAttributionCia
     *
     * @return mixed
     */
    public function getExplicationAttributionCia() {
        return $this->explicationAttributionCia;
    }

    /**
     * Set ExplicationAttributionCia
     *
     * @param $explicationAttributionCia
     * @return $this
     */
    public function setExplicationAttributionCia($explicationAttributionCia) {
        $this->explicationAttributionCia = $explicationAttributionCia;
        return $this;
    }

    /**
     * Get PropositionAvancement
     *
     * @return int
     */
    public function getPropositionAvancement()
    {
        return $this->propositionAvancement;
    }

    /**
     * Set PropositionAvancement
     *
     * @param $propositionAvancement
     * @return $this
     */
    public function setPropositionAvancement($propositionAvancement)
    {
        $this->propositionAvancement = $propositionAvancement;
        return $this;
    }

    /**
     * Set observationsAgentProjetProfessionnel
     *
     * @param $observationsAgentProjetProfessionnel
     * @return $this
     */
    public function setObservationsAgentProjetProfessionnel($observationsAgentProjetProfessionnel)
    {
        $this->observationsAgentProjetProfessionnel = $observationsAgentProjetProfessionnel;

        return $this;
    }

    /**
     * Get observationsAgentProjetProfessionnel
     *
     * @return string
     */
    public function getObservationsAgentProjetProfessionnel()
    {
        return $this->observationsAgentProjetProfessionnel;
    }

    /**
     * Get ObservationsObjectifsPasses
     *
     * @return string
     */
    public function getObservationsObjectifsPasses() {
        return $this->observationsObjectifsPasses;
    }

    /**
     * Set ObservationsObjectifsPasses
     *
     * @param $observationsObjectifsPasses
     * @return $this
     */
    public function setObservationsObjectifsPasses($observationsObjectifsPasses) {
        $this->observationsObjectifsPasses = $observationsObjectifsPasses;
        return $this;
    }


//    /**
//     * Add objectifsFuturCollectif
//     *
//     * @param ObjectifFuturCollectif $objectifsFuturCollectif
//     *
//     * @return Crep
//     */
//    public function addObjectifsFutursCollectif(ObjectifFuturCollectif $objectifsFuturCollectif)
//    {
//        $this->objectifsFutursCollectifs[] = $objectifsFuturCollectif;
//        $objectifsFuturCollectif->setCrep($this);
//
//        return $this;
//    }
//
//    /**
//     * Remove $objectifsFuturCollectif
//     *
//     * @param ObjectifFuturCollectif $objectifsFuturCollectif
//     */
//    public function removeObjectifsFutursCollectif(ObjectifFuturCollectif $objectifsFuturCollectif)
//    {
//        $this->objectifsFutursCollectifs->removeElement($objectifsFuturCollectif);
//        $objectifsFuturCollectif->setCrep(null);
//    }
//
//    /**
//     * Get objectifsFutursCollectifs
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getObjectifsFutursCollectifs()
//    {
//        return $this->objectifsFutursCollectifs;
//    }
}
