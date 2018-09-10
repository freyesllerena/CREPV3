<?php

namespace AppBundle\Entity\Crep\CrepDgac;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Util\Util;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CrepDgac.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository")
 */
class CrepDgac extends Crep
{
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
	 * @ORM\Column(type="string")
	 * @Assert\Length(
	 *    max = 255,
	 *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
	 * )
	 */
	protected $matricule;
	
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
	 * @Assert\Length(
	 *    max = 255,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $fonctionExerceeShd;	
	
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
	protected $posteOccupe;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $contexteAnneeEcoulee;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $descriptionPosteMission;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsObservesShd;	

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsObservesAgent;
	
	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacComposantePoste", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $composantesPostes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreComposantePoste", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
	protected $autresComposantesPostes;
	
	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacCompetenceProfessionnelle", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $competencesProfessionnelles;	

	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacAutreCompetenceProfessionnelle", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $autresCompetencesProfessionnelles;	

	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacCompetenceManageriale", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $competencesManageriales;	

	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacAutreCompetenceManageriale", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $autresCompetencesManageriales;	
	
	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacCompetenceSynthese", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $competencesSyntheses;	
	
	/**
	 * @ORM\OneToMany(targetEntity="CrepDgacAutreCompetenceSynthese", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\OrderBy({"id" = "ASC"})
	 * @Assert\Valid
	 */
	protected $autresCompetencesSyntheses;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $contextePrevisibleAnnee;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsParticuliers;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsPermanents;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $resultatsObtenusParAgent;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $resultatAutresActivites;	

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $obsShdObjectifsEvalues;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $obsAgentObjectifsEvalues;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $autresObservationsAgent;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $commentaireResultatsAgent;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $obsCompetencesRequises;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsObsCompShd;	

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $elementsObsCompAgent;	

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $appreciationGenerale;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $objectifsPermanentsAvenir;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $objectifsParticuliersAvenir;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $observationShdEvolution;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $typeEvolutionCarriere;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $mobilite;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $priseDeResponsabilites;	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $observationsNotifAgent;	

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true, length=4096)
	 * @Assert\Length(
	 *    max = 4096,
	 *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
	 */
	protected $contributionsCompPrevues;

//	/**
//	 * @ORM\OneToMany(targetEntity="CrepDgacFormationSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
//	 * @ORM\OrderBy({"id" = "ASC"})
//	 * @Assert\Valid
//	 */
//	protected $crepDgacFormationsSuivies;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepDgac\CrepDgacFormationSuivie", mappedBy="crep",
     *     orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $crepDgacFormationsSuivies;


    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitMobilite;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     *
     */
    protected $demarrageMobiliteSouhaitee;

    /**
     * @ORM\OneToOne(targetEntity="CrepDgacMobilitePoste", orphanRemoval=true, cascade={"persist", "remove"},
     *     fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Valid
     */
    protected $mobilitePoste;

    /**
     * @ORM\OneToOne(targetEntity="CrepDgacPerspectives", orphanRemoval=true, cascade={"persist", "remove"},
     *     fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Valid
     */
    protected $perspectives;

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


	//##########################################################################################
	
	public function __construct(){
		parent::init();
		
		$this->composantesPostes = new ArrayCollection();
		$this->autresComposantesPostes = new ArrayCollection();
		$this->competencesProfessionnelles = new ArrayCollection();
		$this->autresCompetencesProfessionnelles = new ArrayCollection();
		$this->competencesManageriales = new ArrayCollection();
		$this->autresCompetencesManageriales = new ArrayCollection();
		$this->competencesSyntheses = new ArrayCollection();
		$this->autresCompetencesSyntheses = new ArrayCollection();
		$this->crepDgacFormationsSuivies = new ArrayCollection();
	}
	
	/**
	 * @return string
	 */
	public function getNomUsage() {
		return $this->nomUsage;
	}
	
	/**
	 * @param string $nomUsage
	 *   
	 * @return CrepDgac       	
	 */
	public function setNomUsage($nomUsage) {
		$this->nomUsage = Util::twig_upper($nomUsage);
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPrenom()
	{
		return $this->prenom;
	}
	
	/**
	 * @param string $prenom
	 *
	 * @return CrepDgac
	 */
	public function setPrenom($prenom)
	{
		$this->prenom = Util::twig_title($prenom);
	
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
	 *
	 * @return CrepDgac
	 */
	public function setCorps($corps)
	{
		$this->corps = $corps;
	
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
	 * @param string $grade
	 *
	 * @return CrepDgac
	 */
	public function setGrade($grade)
	{
		$this->grade = $grade;
	
		return $this;
	}	

	/**
	 * @return string
	 */
	public function getMatricule()
	{
		return $this->matricule;
	}
	
	/**
	 * @param string $matricule
	 * 
	 * @return CrepDgac         
	 */
	public function setMatricule($matricule)
	{
		$this->matricule = $matricule;
	
		return $this;
	}

	/**
	 * @return string
	 */
	public function getService()
	{
		return $this->service;
	}
	
	/**
	 * @param string $service
	 *
	 * @return CrepDgac
	 */
	public function setService($service)
	{
		$this->service = $service;
	
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
	 * @param string $posteOccupe
	 *
	 * @return CrepDgac
	 */
	public function setPosteOccupe($posteOccupe)
	{
		$this->posteOccupe = $posteOccupe;
	
		return $this;
	}
	
	/**
	 * @return String 
	 */
	public function getNomUsageShd()
	{
		return $this->nomUsageShd;
	}
	
	/**
	 * @param string $nomUsageShd
	 *
	 * @return CrepDgac
	 */
	public function setNomUsageShd($nomUsageShd)
	{
		$this->nomUsageShd = Util::twig_upper($nomUsageShd);
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPrenomShd()
	{
		return $this->prenomShd;
	}
	
	/**
	 * @param string $prenomShd
	 *
	 * @return CrepDgac
	 */
	public function setPrenomShd($prenomShd)
	{
		$this->prenomShd = Util::twig_title($prenomShd);
	
		return $this;
	}	

	/**
	 *
	 * @return string
	 */
	public function getFonctionExerceeShd()
	{
		return $this->fonctionExerceeShd;
	}
	
	/**
	 *
	 * @param string $fonctionExerceeShd
	 *
	 * @return CrepDgac
	 */
	public function setFonctionExerceeShd($fonctionExerceeShd)
	{
		$this->fonctionExerceeShd = $fonctionExerceeShd;
	
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContexteAnneeEcoulee()
	{
		return $this->contexteAnneeEcoulee;
	}

	/**
	 * @param string $contexteAnneeEcoulee
	 *
	 * @return CrepDgac
	 */
	public function setContexteAnneeEcoulee($contexteAnneeEcoulee)
	{
		$this->contexteAnneeEcoulee = $contexteAnneeEcoulee;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getDescriptionPosteMission()
	{
		return $this->descriptionPosteMission;
	}
	
	/**
	 * @param string $descriptionPosteMission
	 *
	 * @return CrepDgac
	 */
	public function setDescriptionPosteMission($descriptionPosteMission)
	{
		$this->descriptionPosteMission = $descriptionPosteMission;
	
		return $this;
	}	

	/**
	 * @return string
	 */
	public function getElementsObservesShd()
	{
		return $this->elementsObservesShd;
	}
	
	/**
	 * @param string $elementsObservesShd
	 *
	 * @return CrepDgac
	 */
	public function setElementsObservesShd($elementsObservesShd)
	{
		$this->elementsObservesShd = $elementsObservesShd;
	
		return $this;
	}	

	/**
	 * @return string
	 */
	public function getElementsObservesAgent()
	{
		return $this->elementsObservesAgent;
	}
	
	/**
	 * @param string $elementsObservesAgent
	 *
	 * @return CrepDgac
	 */
	public function setElementsObservesAgent($elementsObservesAgent)
	{
		$this->elementsObservesAgent = $elementsObservesAgent;
	
		return $this;
	}	

	/**
	 * @return string
	 */
	public function getContextePrevisibleAnnee()
	{
		return $this->contextePrevisibleAnnee;
	}
	
	/**
	 * @param string $contextePrevisibleAnnee
	 *
	 * @return CrepDgac
	 */
	public function setContextePrevisibleAnnee($contextePrevisibleAnnee)
	{
		$this->contextePrevisibleAnnee = $contextePrevisibleAnnee;
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getElementsParticuliers()
	{
		return $this->elementsParticuliers;
	}
	
	/**
	 * @param string $elementsParticuliers
	 *
	 * @return CrepDgac
	 */
	public function setElementsParticuliers($elementsParticuliers)
	{
		$this->elementsParticuliers = $elementsParticuliers;
	
		return $this;
	}

	/**
	 * @return string
	 */
	public function getElementsPermanents()
	{
		return $this->elementsPermanents;
	}
	
	/**
	 * @param string $elementsPermanents
	 *
	 * @return CrepDgac
	 */
	public function setElementsPermanents($elementsPermanents)
	{
		$this->elementsPermanents = $elementsPermanents;
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getResultatsObtenusParAgent()
	{
		return $this->resultatsObtenusParAgent;
	}
	
	/**
	 * @param string $resultatsObtenusParAgent
	 *
	 * @return CrepDgac
	 */
	public function setResultatsObtenusParAgent($resultatsObtenusParAgent)
	{
		$this->resultatsObtenusParAgent = $resultatsObtenusParAgent;
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getResultatAutresActivites()
	{
		return $this->resultatAutresActivites;
	}
	
	/**
	 * @param string $resultatAutresActivites
	 *
	 * @return CrepDgac
	 */
	public function setResultatAutresActivites($resultatAutresActivites)
	{
		$this->resultatAutresActivites = $resultatAutresActivites;
	
		return $this;
	}	

	/**
	 * @return string
	 */
	public function getObsShdObjectifsEvalues()
	{
		return $this->obsShdObjectifsEvalues;
	}
	
	/**
	 * @param string $obsShdObjectifsEvalues
	 *
	 * @return CrepDgac
	 */
	public function setObsShdObjectifsEvalues($obsShdObjectifsEvalues)
	{
		$this->obsShdObjectifsEvalues = $obsShdObjectifsEvalues;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getObsAgentObjectifsEvalues()
	{
		return $this->obsAgentObjectifsEvalues;
	}
	
	/**
	 * @param string $obsAgentObjectifsEvalues
	 *
	 * @return CrepDgac
	 */
	public function setObsAgentObjectifsEvalues($obsAgentObjectifsEvalues)
	{
		$this->obsAgentObjectifsEvalues = $obsAgentObjectifsEvalues;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getAutresObservationsAgent()
	{
		return $this->autresObservationsAgent;
	}
	
	/**
	 * @param string $autresObservationsAgent
	 *
	 * @return CrepDgac
	 */
	public function setAutresObservationsAgent($autresObservationsAgent)
	{
		$this->autresObservationsAgent = $autresObservationsAgent;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getCommentaireResultatsAgent()
	{
		return $this->commentaireResultatsAgent;
	}
	
	/**
	 * @param string $commentaireResultatsAgent
	 *
	 * @return CrepDgac
	 */
	public function setCommentaireResultatsAgent($commentaireResultatsAgent)
	{
		$this->commentaireResultatsAgent = $commentaireResultatsAgent;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getObsCompetencesRequises()
	{
		return $this->obsCompetencesRequises;
	}
	
	/**
	 * @param string $obsCompetencesRequises
	 *
	 * @return CrepDgac
	 */
	public function setObsCompetencesRequises($obsCompetencesRequises)
	{
		$this->obsCompetencesRequises = $obsCompetencesRequises;
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getElementsObsCompShd()
	{
		return $this->elementsObsCompShd;
	}
	
	/**
	 * @param string $elementsObsCompShd
	 *
	 * @return CrepDgac
	 */
	public function setElementsObsCompShd($elementsObsCompShd)
	{
		$this->elementsObsCompShd = $elementsObsCompShd;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getElementsObsCompAgent()
	{
		return $this->elementsObsCompAgent;
	}
	
	/**
	 * @param string $elementsObsCompAgent
	 *
	 * @return CrepDgac
	 */
	public function setElementsObsCompAgent($elementsObsCompAgent)
	{
		$this->elementsObsCompAgent = $elementsObsCompAgent;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getAppreciationGenerale()
	{
		return $this->appreciationGenerale;
	}
	
	/**
	 * @param string appreciationGenerale
	 *
	 * @return CrepDgac
	 */
	public function setAppreciationGenerale($appreciationGenerale)
	{
		$this->appreciationGenerale = $appreciationGenerale;
	
		return $this;
	}

	/**
	 * @return string
	 */
	public function getObjectifsPermanentsAvenir()
	{
		return $this->objectifsPermanentsAvenir;
	}
	
	/**
	 * @param string $objectifsPermanentsAvenir
	 *
	 * @return CrepDgac
	 */
	public function setObjectifsPermanentsAvenir($objectifsPermanentsAvenir)
	{
		$this->objectifsPermanentsAvenir = $objectifsPermanentsAvenir;
	
		return $this;
	}

	/**
	 * @return string
	 */
	public function getObjectifsParticuliersAvenir()
	{
		return $this->objectifsParticuliersAvenir;
	}
	
	/**
	 * @param string $objectifsParticuliersAvenir
	 *
	 * @return CrepDgac
	 */
	public function setObjectifsParticuliersAvenir($objectifsParticuliersAvenir)
	{
		$this->objectifsParticuliersAvenir = $objectifsParticuliersAvenir;
	
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getObservationShdEvolution()
	{
		return $this->observationShdEvolution;
	}
	
	/**
	 * @param string $observationShdEvolution
	 *
	 * @return CrepDgac
	 */
	public function setObservationShdEvolution($observationShdEvolution)
	{
		$this->observationShdEvolution = $observationShdEvolution;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getTypeEvolutionCarriere()
	{
		return $this->typeEvolutionCarriere;
	}
	
	/**
	 * @param string $typeEvolutionCarriere
	 *
	 * @return CrepDgac
	 */
	public function setTypeEvolutionCarriere($typeEvolutionCarriere)
	{
		$this->typeEvolutionCarriere = $typeEvolutionCarriere;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getMobilite()
	{
		return $this->mobilite;
	}
	
	/**
	 * @param string $mobilite
	 *
	 * @return CrepDgac
	 */
	public function setMobilite($mobilite)
	{
		$this->mobilite = $mobilite;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getPriseDeResponsabilites()
	{
		return $this->priseDeResponsabilites;
	}
	
	/**
	 * @param string $priseDeResponsabilites
	 *
	 * @return CrepDgac
	 */
	public function setPriseDeResponsabilites($priseDeResponsabilites)
	{
		$this->priseDeResponsabilites = $priseDeResponsabilites;
	
		return $this;
	}	
	
	/**
	 * @return string
	 */
	public function getObservationsNotifAgent()
	{
		return $this->observationsNotifAgent;
	}
	
	/**
	 * @param string $observationsNotifAgent
	 *
	 * @return CrepDgac
	 */
	public function setObservationsNotifAgent($observationsNotifAgent)
	{
		$this->observationsNotifAgent = $observationsNotifAgent;
	
		return $this;
	}	
	
	
	
	/**
	 * @return string
	 */
	public function getContributionsCompPrevues()
	{
		return $this->contributionsCompPrevues;
	}
	
	/**
	 * @param string $contributionsCompPrevues
	 *
	 * @return CrepDgac
	 */
	public function setContributionsCompPrevues($contributionsCompPrevues)
	{
		$this->contributionsCompPrevues = $contributionsCompPrevues;
	
		return $this;
	}	
//#################################################################	
	public function initialiser(Agent $agent, $em){
		
	    $this->initialiserParent($agent, $em);

        $this->setNomUsage($agent->getNom())
            ->setPrenom($agent->getPrenom())
            ->setCorps($agent->getCorps())
            ->setGrade($agent->getGrade())
            ->setMatricule($agent->getMatricule())
            ->setService($agent->getAffectationClairAgent())
            ->setPosteOccupe($agent->getPosteOccupe())
            ->setNomUsageShd($agent->getShd()->getNom())
            ->setPrenomShd($agent->getShd()->getPrenom())
            ->setFonctionExerceeShd($agent->getShd()->getPosteOccupe())
            ->setAffectation($agent->getAffectation());
        
        // Initialisation du référentiel composante poste
	       $this->addComposantesPoste(new CrepDgacComposantePoste('Activités  ou compétences énoncées dans la fiche de poste : détailler'));
	       $this->addComposantesPoste(new CrepDgacComposantePoste("Organisationnelle (du travail, de l'activité, de réunion, d'agendas...)"));
	       $this->addComposantesPoste(new CrepDgacComposantePoste('Travail en équipe'));
	       $this->addComposantesPoste(new CrepDgacComposantePoste('Management'));
	       $this->addComposantesPoste(new CrepDgacComposantePoste('Conduite de projet'));
	       
	       // Initialisation du référentiel competences professionnelles sur les besoins du poste
	       $this->addCompetencesProfessionnelle(new CrepDgacCompetenceProfessionnelle('Activités  ou compétences énoncées dans la fiche de poste : détailler'));
	       $this->addCompetencesProfessionnelle(new CrepDgacCompetenceProfessionnelle("Organisationnelle (du travail, de l'activité, de réunion, d'agendas...)"));
	       $this->addCompetencesProfessionnelle(new CrepDgacCompetenceProfessionnelle('Travail en équipe'));
	       $this->addCompetencesProfessionnelle(new CrepDgacCompetenceProfessionnelle('Management'));
	       $this->addCompetencesProfessionnelle(new CrepDgacCompetenceProfessionnelle('Conduite de projet')); 
	
	       // Initialisation du référentiel competences manageriales sur les besoins du poste
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale('Sens du travail en équipe'));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale("Capacité à encadrer, déléguer, assurer le suivi des dossiers"));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale('Aptitude à former des collaborateurs'));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale('Aptitude aux responsabilités/prise de décision'));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale("Sens de l'organisation"));	    
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale("Aptitude à la communication interne et externe"));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale('Aptitude à la négociation/médiation'));
	       $this->addCompetencesManageriale(new CrepDgacCompetenceManageriale("Sens des relations humaines"));

	       // Initialisation du référentiel sur la synthèse des competences du poste
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese('Maitrise des techniques, des dossiers'));
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese('Efficacité'));
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese('Respect des délais'));
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese('Adaptation aux situations nouvelles'));
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese("Esprit d'initiative"));	     
	       $this->addCompetencesSynthese(new CrepDgacCompetenceSynthese('Implication'));
	       
	}


	/**
	 * Méthode appelée lors d'un rattachement d'un nouveau N+1.
	*/
	public function actualiserDonneesShd()
	{
		
	}

	//Fonctions de confidentialisation d'un CREP
	public function confidentialisationChampsShd ()
	{
		$this->setContexteAnneeEcoulee(null)
            ->setDescriptionPosteMission(null)
            ->setElementsObservesShd(null)
            ->setSouhaitMobilite(null)
		    ->setDemarrageMobiliteSouhaitee(null)
            ->setAffectation(null)
		;
		
		/** @var $contraintesPoste CrepEddContraintePoste  */
		foreach ($this->getComposantesPostes() as $composantesPostes) {
			$this->removeComposantesPoste($composantesPostes);
		}		
		
		
	}

	public function confidentialisationChampsAgent ()
	{
		$this->setElementsObservesAgent(null);
        $this->setDateVisaAgent(null);
        $this->setDateRefusVisa(null);
	}

	public function confidentialisationChampsAgentAvantNotification ()
	{
		
	}
	
	public function confidentialisationChampsAh ()
	{
		
	}
	
	/**
	 * Add composantesPoste.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacComposantePoste $composantesPostes
	 *
	 * @return CrepDgac
	 */
	public function addComposantesPoste(\AppBundle\Entity\Crep\CrepDgac\CrepDgacComposantePoste $composantesPoste)
	{
		$this->composantesPostes[] = $composantesPoste;
		$composantesPoste->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove composantesPoste.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacComposantePoste $composantesPostes
	 */
	public function removeComposantesPoste(\AppBundle\Entity\Crep\CrepDgac\CrepDgacComposantePoste $composantesPostes)
	{
		$this->composantesPostes->removeElement($composantesPostes);
	}
	
	/**
	 * Get composantesPostes.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getComposantesPostes()
	{
		return $this->composantesPostes;
	}
	

	/**
	 * Add autresComposantesPoste.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreComposantePoste $autresComposantesPostes
	 *
	 * @return CrepDgac
	 */
	public function addAutresComposantesPoste(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreComposantePoste $autreComposantesPoste)
	{
		$this->autresComposantesPostes[] = $autreComposantesPoste;
		$autreComposantesPoste->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove autresComposantesPoste.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreComposantePoste $autresComposantesPostes
	 */
	public function removeAutresComposantesPoste(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreComposantePoste $autresComposantesPoste)
	{
		$this->autresComposantesPostes->removeElement($autresComposantesPoste);
	}
	
	/**
	 * Get autresComposantesPostes.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAutresComposantesPostes()
	{
		return $this->autresComposantesPostes;
	}
	
	/**
	 * Add competencesProfessionnelle.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceProfessionnelle $competencesProfessionnelles
	 *
	 * @return CrepDgac
	 */
	public function addCompetencesProfessionnelle(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceProfessionnelle $competencesProfessionnelle)
	{
		$this->competencesProfessionnelles[] = $competencesProfessionnelle;
		$competencesProfessionnelle->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove competencesProfessionnelle.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceProfessionnelle $competencesProfessionnelles
	 */
	public function removeCompetencesProfessionnelle(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceProfessionnelle $competencesProfessionnelle)
	{
		$this->competencesProfessionnelles->removeElement($competencesProfessionnelle);
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
	 * Add autresCompetencesProfessionnelle.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceProfessionnelle $autresCompetencesProfessionnelles
	 *
	 * @return CrepDgac
	 */
	public function addAutresCompetencesProfessionnelle(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceProfessionnelle $autresCompetencesProfessionnelle)
	{
		$this->autresCompetencesProfessionnelles[] = $autresCompetencesProfessionnelle;
		$autresCompetencesProfessionnelle->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove autresCompetencesProfessionnelle.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceProfessionnelle $autresCompetencesProfessionnelles
	 */
	public function removeAutresCompetencesProfessionnelle(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceProfessionnelle $autresCompetencesProfessionnelle)
	{
		$this->autresCompetencesProfessionnelles->removeElement($autresCompetencesProfessionnelle);
	}
	
	/**
	 * Get autresCompetencesProfessionnelles.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAutresCompetencesProfessionnelles()
	{
		return $this->autresCompetencesProfessionnelles;
	}	

	/**
	 * Add competencesManageriale.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceManageriale $competencesManageriales
	 *
	 * @return CrepDgac
	 */
	public function addCompetencesManageriale(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceManageriale $competencesManageriale)
	{
		$this->competencesManageriales[] = $competencesManageriale;
		$competencesManageriale->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove competencesManageriale.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceManageriale $competencesManageriales
	 */
	public function removeCompetencesManageriale(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceManageriale $competencesManageriale)
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
	 * Add autresCompetencesManageriale.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceManageriale $autresCompetencesManageriales
	 *
	 * @return CrepDgac
	 */
	public function addAutresCompetencesManageriale(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceManageriale $autresCompetencesManageriale)
	{
		$this->autresCompetencesManageriales[] = $autresCompetencesManageriale;
		$autresCompetencesManageriale->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove autresCompetencesManageriale.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceManageriale $autresCompetencesManageriales
	 */
	public function removeAutresCompetencesManageriale(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceManageriale $autresCompetencesManageriale)
	{
		$this->autresCompetencesManageriales->removeElement($autresCompetencesManageriale);
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
	 * Add competencesSynthese.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceSynthese $competencesSyntheses
	 *
	 * @return CrepDgac
	 */
	public function addCompetencesSynthese(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceSynthese $competencesSynthese)
	{
		$this->competencesSyntheses[] = $competencesSynthese;
		$competencesSynthese->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove competencesSynthese.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceSynthese $competencesSyntheses
	 */
	public function removeCompetencesSynthese(\AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceSynthese $competencesSynthese)
	{
		$this->competencesSyntheses->removeElement($competencesSynthese);
	}
	
	/**
	 * Get competencesSyntheses.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCompetencesSyntheses()
	{
		return $this->competencesSyntheses;
	}	
	
	/**
	 * Add autresCompetencesSynthese.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceSynthese $autresCompetencesSyntheses
	 *
	 * @return CrepDgac
	 */
	public function addAutresCompetencesSynthese(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceSynthese $autresCompetencesSynthese)
	{
		$this->autresCompetencesSyntheses[] = $autresCompetencesSynthese;
		$autresCompetencesSynthese->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove autresCompetencesSynthese.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceSynthese $autresCompetencesSyntheses
	 */
	public function removeAutresCompetencesSynthese(\AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceSynthese $autresCompetencesSynthese)
	{
		$this->autresCompetencesSyntheses->removeElement($autresCompetencesSynthese);
	}



	/**
	 * Get autresCompetencesSyntheses.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAutresCompetencesSyntheses()
	{
		return $this->autresCompetencesSyntheses;
	}













	/**
	 * Add crepDgacFormationsSuivy
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacFormationSuivie $formation
	 *
	 * @return CrepDgac
	 */
	public function addCrepDgacFormationsSuivy(CrepDgacFormationSuivie $formation)
	{
		$this->crepDgacFormationsSuivies[] = $formation;
		$formation->setCrep($this);

		return $this;
	}

	/**
	 * Remove crepDgacFormationsSuivy
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgacFormationSuivie $formation
	 */
	public function removeCrepDgacFormationsSuivy(CrepDgacFormationSuivie $formation)
	{
		$this->crepDgacFormationsSuivies->removeElement($formation);
		$formation->setCrep(null);
	}

	/**
	 * Get crepDgacFormationsSuivies
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCrepDgacFormationsSuivies()
	{
		return $this->crepDgacFormationsSuivies;
	}

    /**
     * @return bool
     */
    public function getSouhaitMobilite()
    {
        return $this->souhaitMobilite;
    }

    /**
     * @param $souhaitMobilite
     * @return $this
     */
    public function setSouhaitMobilite($souhaitMobilite)
    {
        $this->souhaitMobilite = $souhaitMobilite;

        return $this;
    }



    /**
     * Get demarrageMobiliteSouhaitee
     *
     * @return int
     */
    public function getDemarrageMobiliteSouhaitee()
    {
        return $this->demarrageMobiliteSouhaitee;
    }

    /**
     * Set demarrageMobiliteSouhaitee
     *
     * @param $demarrageMobiliteSouhaitee
     * @return $this
     */
    public function setDemarrageMobiliteSouhaitee($demarrageMobiliteSouhaitee)
    {
        $this->demarrageMobiliteSouhaitee = $demarrageMobiliteSouhaitee;
        return $this;
    }

    /**
     * @return CrepDgacMobilitePoste
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
     * @return CrepDgacPerspectives
     */
    public function getPerspectives()
    {
        return $this->perspectives;
    }

    /**
     * @param $perspectives
     * @return $this
     */
    public function setPerspectives($perspectives)
    {
        $this->perspectives = $perspectives;
        return $this;
    }


    /**
     * Validations CrepDgac
     * @param ExecutionContextInterface $context
     * @Assert\Callback
     */
	public function validateCrepDgac(ExecutionContextInterface $context)
	{
        /*  *****   VALIDATION: autresActivites   ***** */
        foreach($this->autresComposantesPostes as $autres) {
            /** @var Competence $autres */
            if (null !== $this->resultatAutresActivites && null === $autres->getLibelle()) {
                $context->buildViolation('Champ obligatoire')
                    ->atPath('autresActivites')
                    ->addViolation();
            }
        }
	}
}
