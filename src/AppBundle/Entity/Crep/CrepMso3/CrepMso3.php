<?php

namespace AppBundle\Entity\Crep\CrepMso3;

use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepMsoAnnexe3.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMsoAnnexe3")
 */
class CrepMso3 extends Crep
{
    public static $echelleObjectifEvalue = [
            'Atteint' => 3,
            'Partiellement Atteint' => 2,
            'Non atteint' => 1,
            'Devenu sans objet' => 0,
    ];

    /**
     * @var string @ORM\Column(type="string", nullable=true, length=70)
     * @Assert\NotBlank(message = "Nom obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 70,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomUsage;

    /**
     * @ORM\Column(type="string", nullable=true, length=70)
     * @Assert\NotBlank(message = "Prénom obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 70,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message = "Date non valide")
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
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $corps;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $grade;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=30)
     * @Assert\Length(
     *    max = 30,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $echelon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $affectation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $posteOccupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message = "Date non valide")
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
     *
     * @ORM\Column(type="string", nullable=true, length=70)
     * @Assert\NotBlank(message = "Nom du supérieur hiérarchique direct obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 70,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomUsageShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=70)
     * @Assert\NotBlank(message = "Prénom du supérieur hiérarchique direct obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 70,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $prenomShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $categorieShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $corpsShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $gradeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $fonctionExerceeShd;

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
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $cotationPoste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    min = 2,
     *    max = 255,
     *    minMessage = "Le champ doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $quotiteTravail;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $fichePosteAdaptee;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $pointsActualisesFichePoste;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciationPosteAgent;

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
    protected $natureDossiersTravaux;

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
    protected $contexteResultats;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciationEvaluateur;

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
     * @ORM\Column(name="obs_agent_sur_son_activite",type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $observationsAgentSurSonActivite;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $objectifsService;

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
     * @ORM\OneToMany(targetEntity="CrepMso3CompetenceRequise", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $competencesRequises;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3SavoirFairePoste", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $savoirsFairePoste;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3SavoirFairePosteAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $savoirsFairePosteAutres;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3QualiteRelationnellePoste", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $qualitesRelationnellesPoste;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3QualiteRelationnellePosteAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $qualitesRelationnellesPosteAutres;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3CompetenceMiseEnOeuvre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $competencesMisesEnOeuvre;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3SavoirFaireAgent", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $savoirsFaireAgent;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3SavoirFaireAgentAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $savoirsFaireAgentAutres;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3QualiteRelationnelleAgent", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $qualitesRelationnellesAgent;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3QualiteRelationnelleAgentAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $qualitesRelationnellesAgentAutres;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $agentsEncadres;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3AptitudeManagementAgent", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $aptitudesManagementAgent;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationN1", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsN1;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationN2", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsN2;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationT1", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsT1;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationT2", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsT2;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationT3", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsT3;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationPreparationConcours", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsPreparationConcours;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3FormationAutre", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAutres;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $evolutionPosteActuel;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $modificationFicheDePoste;

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
    protected $projetProfessionnel;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var string
     *
     * @ORM\Column(name = "obs_shd_perspectives_pro", type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $observationsShdPerspectivesProfessionnelles;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $avisShdAvancementGrade;

    /**
     * @var string
     *
     * @ORM\Column(name = "obs_agent_perspectives_pro", type="text", nullable=true, length=4096)
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $observationsAgentPerspectivesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepMso3CompetenceManiereServirAgent", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $competencesManiereServir;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="aptitudes_exercer_fonct_supp")
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $aptitudesExercerFonctionsSupperieures;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *    max = 4096,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $appreciationLitteraleShd;

    /**
     * @var string
     *
     * @ORM\Column(name="obs_apprec_portees_agent", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAppreciationsPorteesAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="obs_conduite_entretien_ah", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsConduiteEntretienAh;

    /**
     * @var string
     *
     * @ORM\Column(name="obs_apprec_portees_ah", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAppreciationsPorteesAh;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsEventuellesAh;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $fonctionAh;

    //Fonctions de confidentialisation d'un CREP
    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $dernierCrep = $em->getRepository(Crep::class)->getDernierCrep($agent);
        
        // Reprise des données du CREP N-1
        if($dernierCrep && $dernierCrep instanceof $this){
        
        	// Reprise des formations
        	foreach ($dernierCrep->getFormationsT1() as $formation){
        		$formationSuivie = new CrepMso3FormationN1();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsN1($formationSuivie);
        	}
        	
        	foreach ($dernierCrep->getFormationsT2() as $formation){
        		$formationSuivie = new CrepMso3FormationN1();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsN1($formationSuivie);
        	}
        	
        	foreach ($dernierCrep->getFormationsT3() as $formation){
        		$formationSuivie = new CrepMso3FormationN1();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsN1($formationSuivie);
        	}
        	
        	foreach ($dernierCrep->getFormationsPreparationConcours() as $formation){
        		$formationSuivie = new CrepMso3FormationN1();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsN1($formationSuivie);
        	}
        	
        	foreach ($dernierCrep->getFormationsAutres() as $formation){
        		$formationSuivie = new CrepMso3FormationN1();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsN1($formationSuivie);
        	}
        	
        	// Reprise des fonctions exercees
        	$this->setFonctionsExercees($dernierCrep->getFonctionsExercees());
        	
        	// Reprise des compétences
        	foreach ($dernierCrep->getCompetencesMisesEnOeuvre() as $ancienneCompetence){
        		$nouvelleCompetence = new CrepMso3CompetenceMiseEnOeuvre();
        		$nouvelleCompetence->setLibelle($ancienneCompetence->getLibelle());
        		$nouvelleCompetence->setNiveau($ancienneCompetence->getNiveau());
        		
        		$this->addCompetencesMisesEnOeuvre($nouvelleCompetence);
        	}
        	
        	foreach ($dernierCrep->getSavoirsFaireAgent() as $ancienneSavoirFaire){
        		$nouveauSavoirFaire = new CrepMso3SavoirFaireAgent();
        		$nouveauSavoirFaire->setLibelle($ancienneSavoirFaire->getLibelle());
        		$nouveauSavoirFaire->setNiveau($ancienneSavoirFaire->getNiveau());
        	
        		$this->addSavoirsFaireAgent($nouveauSavoirFaire);
        	}
        	
        	foreach ($dernierCrep->getQualitesRelationnellesAgent() as $ancienneQualiteRelationnelle){
        		$nouvelleQualiteRelationnelle = new CrepMso3QualiteRelationnelleAgent();
        		$nouvelleQualiteRelationnelle->setLibelle($ancienneQualiteRelationnelle->getLibelle());
        		$nouvelleQualiteRelationnelle->setNiveau($ancienneQualiteRelationnelle->getNiveau());
        		 
        		$this->addQualitesRelationnellesAgent($nouvelleQualiteRelationnelle);
        	}       	
        }
        
        $this->setPrenom($agent->getPrenom())
            ->setNomUsage($agent->getNom())
            ->setDateNaissance($agent->getDateNaissance())
            ->setCategorie($agent->getCategorieAgent())
            ->setCorps($agent->getCorps())
            ->setGrade($agent->getGrade())
            ->setEchelon($agent->getEchelon())
            ->setAffectation($agent->getAffectation())
            ->setPosteOccupe($agent->getPosteOccupe())
            ->setDateEntreePoste($agent->getDateEntreePosteOccupe());

        if ($agent->getShd()) {
            $this->setPrenomShd($agent->getShd()->getPrenom())
                ->setNomUsageShd($agent->getShd()->getNom())
                ->setCategorieShd($agent->getShd()->getCategorieAgent())
                ->setCorpsShd($agent->getShd()->getCorps())
                ->setGradeShd($agent->getShd()->getGrade());
        }

        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Travail en équipe'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Capacité de synthèse'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Capacité d’analyse'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Animation d’équipe'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Expression écrite'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Expression orale'));
        $this->addSavoirsFairePoste(new CrepMso3SavoirFairePoste('Techniques spécifiques'));

        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Sens des relations humaines'));
        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Capacité d’adaptation'));
        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Autonomie'));
        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Rigueur dans l’exécution des tâches'));
        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Capacité d’initiative'));
        $this->addQualitesRelationnellesPoste(new CrepMso3QualiteRelationnellePoste('Réactivité'));

        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Travail en équipe'));
        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Capacité de synthèse'));
        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Capacité d’analyse'));
        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Animation d’équipe'));
        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Expression écrite'));
        $this->addSavoirsFaireAgent(new CrepMso3SavoirFaireAgent('Techniques spécifiques'));

        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Sens des relations humaines'));
        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Capacité d’adaptation'));
        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Autonomie'));
        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Rigueur dans l’exécution des tâches'));
        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Capacité d’initiative'));
        $this->addQualitesRelationnellesAgent(new CrepMso3QualiteRelationnelleAgent('Réactivité'));

        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Capacité à déléguer'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Capacité à mobiliser et valoriser les compétences'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Capacité d’organisation, de pilotage'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Attention portée au développement professionnel des collaborateurs'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Aptitude à prévenir, arbitrer et gérer les conflits'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Aptitude à la prise de décision'));
        $this->addAptitudesManagementAgent(new CrepMso3AptitudeManagementAgent('Capacité à fixer des objectifs cohérents'));

        $this->addCompetencesManiereServir(new CrepMso3CompetenceManiereServirAgent('Qualité du travail'));
        $this->addCompetencesManiereServir(new CrepMso3CompetenceManiereServirAgent('Qualités relationnelles'));
        $this->addCompetencesManiereServir(new CrepMso3CompetenceManiereServirAgent('Implication personnelle'));
        $this->addCompetencesManiereServir(new CrepMso3CompetenceManiereServirAgent('Sens du service public'));
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::init();
        $this->competencesRequises = new \Doctrine\Common\Collections\ArrayCollection();
        $this->savoirsFairePoste = new \Doctrine\Common\Collections\ArrayCollection();
        $this->savoirsFairePosteAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->qualitesRelationnellesPoste = new \Doctrine\Common\Collections\ArrayCollection();
        $this->qualitesRelationnellesPosteAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesMisesEnOeuvre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->savoirsFaireAgent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->savoirsFaireAgentAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->qualitesRelationnellesAgent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->qualitesRelationnellesAgentAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aptitudesManagementAgent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsN1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsN2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsT3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsPreparationConcours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAutres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesManiereServir = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nom.
     *
     * @param string $nomUsage
     *
     * @return CrepMso3
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * Get nomUsage.
     *
     * @return string
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return CrepMso3
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance.
     *
     * @param \DateTime $dateNaissance
     *
     * @return CrepMso3
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

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
     * Set categorie.
     *
     * @param string $categorie
     *
     * @return CrepMso3
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

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
     * Set corps.
     *
     * @param string $corps
     *
     * @return CrepMso3
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;

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
     * Set grade.
     *
     * @param string $grade
     *
     * @return CrepMso3
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

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
     * Set echelon.
     *
     * @param string $echelon
     *
     * @return CrepMso3
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon.
     *
     * @return string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * Set affectation.
     *
     * @param string $affectation
     *
     * @return CrepMso3
     */
    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;

        return $this;
    }

    /**
     * Get affectation.
     *
     * @return string
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * Set posteOccupe.
     *
     * @param string $posteOccupe
     *
     * @return CrepMso3
     */
    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;

        return $this;
    }

    /**
     * Get posteOccupe.
     *
     * @return string
     */
    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    /**
     * Set dateEntreePoste.
     *
     * @param \DateTime $dateEntreePoste
     *
     * @return CrepMso3
     */
    public function setDateEntreePoste($dateEntreePoste)
    {
        $this->dateEntreePoste = $dateEntreePoste;

        return $this;
    }

    /**
     * Get dateEntreePoste.
     *
     * @return \DateTime
     */
    public function getDateEntreePoste()
    {
        return $this->dateEntreePoste;
    }

    /**
     * Set nomUsageShd.
     *
     * @param string $nomUsageShd
     *
     * @return CrepMso3
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;

        return $this;
    }

    /**
     * Get nomUsageShd.
     *
     * @return string
     */
    public function getNomUsageShd()
    {
        return $this->nomUsageShd;
    }

    /**
     * Set prenomShd.
     *
     * @param string $prenomShd
     *
     * @return CrepMso3
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;

        return $this;
    }

    /**
     * Get prenomShd.
     *
     * @return string
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     * Set categorieShd.
     *
     * @param string $categorieShd
     *
     * @return CrepMso3
     */
    public function setCategorieShd($categorieShd)
    {
        $this->categorieShd = $categorieShd;

        return $this;
    }

    /**
     * Get categorieShd.
     *
     * @return string
     */
    public function getCategorieShd()
    {
        return $this->categorieShd;
    }

    /**
     * Set corpsShd.
     *
     * @param string $corpsShd
     *
     * @return CrepMso3
     */
    public function setCorpsShd($corpsShd)
    {
        $this->corpsShd = $corpsShd;

        return $this;
    }

    /**
     * Get corpsShd.
     *
     * @return string
     */
    public function getCorpsShd()
    {
        return $this->corpsShd;
    }

    /**
     * Set gradeShd.
     *
     * @param string $gradeShd
     *
     * @return CrepMso3
     */
    public function setGradeShd($gradeShd)
    {
        $this->gradeShd = $gradeShd;

        return $this;
    }

    /**
     * Get gradeShd.
     *
     * @return string
     */
    public function getGradeShd()
    {
        return $this->gradeShd;
    }

    /**
     * Set fonctionExerceeShd.
     *
     * @param string $fonctionExerceeShd
     *
     * @return CrepMso3
     */
    public function setFonctionExerceeShd($fonctionExerceeShd)
    {
        $this->fonctionExerceeShd = $fonctionExerceeShd;

        return $this;
    }

    /**
     * Get fonctionExerceeShd.
     *
     * @return string
     */
    public function getFonctionExerceeShd()
    {
        return $this->fonctionExerceeShd;
    }

    /**
     * Set fonctionsExercees.
     *
     * @param string $fonctionsExercees
     *
     * @return CrepMso3
     */
    public function setFonctionsExercees($fonctionsExercees)
    {
        $this->fonctionsExercees = $fonctionsExercees;

        return $this;
    }

    /**
     * Get fonctionsExercees.
     *
     * @return string
     */
    public function getFonctionsExercees()
    {
        return $this->fonctionsExercees;
    }

    /**
     * Set cotationPoste.
     *
     * @param string $cotationPoste
     *
     * @return CrepMso3
     */
    public function setCotationPoste($cotationPoste)
    {
        $this->cotationPoste = $cotationPoste;

        return $this;
    }

    /**
     * Get cotationPoste.
     *
     * @return string
     */
    public function getCotationPoste()
    {
        return $this->cotationPoste;
    }

    /**
     * Set quotiteTravail.
     *
     * @param string $quotiteTravail
     *
     * @return CrepMso3
     */
    public function setQuotiteTravail($quotiteTravail)
    {
        $this->quotiteTravail = $quotiteTravail;

        return $this;
    }

    /**
     * Get quotiteTravail.
     *
     * @return string
     */
    public function getQuotiteTravail()
    {
        return $this->quotiteTravail;
    }

    /**
     * Set fichePosteAdaptee.
     *
     * @param bool $fichePosteAdaptee
     *
     * @return CrepMso3
     */
    public function setFichePosteAdaptee($fichePosteAdaptee)
    {
        $this->fichePosteAdaptee = $fichePosteAdaptee;

        return $this;
    }

    /**
     * Get fichePosteAdaptee.
     *
     * @return bool
     */
    public function getFichePosteAdaptee()
    {
        return $this->fichePosteAdaptee;
    }

    /**
     * Set pointsActualisesFichePoste.
     *
     * @param string $pointsActualisesFichePoste
     *
     * @return CrepMso3
     */
    public function setPointsActualisesFichePoste($pointsActualisesFichePoste)
    {
        $this->pointsActualisesFichePoste = $pointsActualisesFichePoste;

        return $this;
    }

    /**
     * Get pointsActualisesFichePoste.
     *
     * @return string
     */
    public function getPointsActualisesFichePoste()
    {
        return $this->pointsActualisesFichePoste;
    }

    /**
     * Set appreciationPosteAgent.
     *
     * @param string $appreciationPosteAgent
     *
     * @return CrepMso3
     */
    public function setAppreciationPosteAgent($appreciationPosteAgent)
    {
        $this->appreciationPosteAgent = $appreciationPosteAgent;

        return $this;
    }

    /**
     * Get appreciationPosteAgent.
     *
     * @return string
     */
    public function getAppreciationPosteAgent()
    {
        return $this->appreciationPosteAgent;
    }

    /**
     * Set contexteAnneeEcoulee.
     *
     * @param string $contexteAnneeEcoulee
     *
     * @return CrepMso3
     */
    public function setContexteAnneeEcoulee($contexteAnneeEcoulee)
    {
        $this->contexteAnneeEcoulee = $contexteAnneeEcoulee;

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
     * Set natureDossiersTravaux.
     *
     * @param string $natureDossiersTravaux
     *
     * @return CrepMso3
     */
    public function setNatureDossiersTravaux($natureDossiersTravaux)
    {
        $this->natureDossiersTravaux = $natureDossiersTravaux;

        return $this;
    }

    /**
     * Get natureDossiersTravaux.
     *
     * @return string
     */
    public function getNatureDossiersTravaux()
    {
        return $this->natureDossiersTravaux;
    }

    /**
     * Set resultatsObtenusParAgent.
     *
     * @param string $resultatsObtenusParAgent
     *
     * @return CrepMso3
     */
    public function setResultatsObtenusParAgent($resultatsObtenusParAgent)
    {
        $this->resultatsObtenusParAgent = $resultatsObtenusParAgent;

        return $this;
    }

    /**
     * Get resultatsObtenusParAgent.
     *
     * @return string
     */
    public function getResultatsObtenusParAgent()
    {
        return $this->resultatsObtenusParAgent;
    }

    /**
     * Set contexteResultats.
     *
     * @param string $contexteResultats
     *
     * @return CrepMso3
     */
    public function setContexteResultats($contexteResultats)
    {
        $this->contexteResultats = $contexteResultats;

        return $this;
    }

    /**
     * Get contexteResultats.
     *
     * @return string
     */
    public function getContexteResultats()
    {
        return $this->contexteResultats;
    }

    /**
     * Set appreciationEvaluateur.
     *
     * @param string $appreciationEvaluateur
     *
     * @return CrepMso3
     */
    public function setAppreciationEvaluateur($appreciationEvaluateur)
    {
        $this->appreciationEvaluateur = $appreciationEvaluateur;

        return $this;
    }

    /**
     * Get appreciationEvaluateur.
     *
     * @return string
     */
    public function getAppreciationEvaluateur()
    {
        return $this->appreciationEvaluateur;
    }

    /**
     * Set elementsParticuliers.
     *
     * @param string $elementsParticuliers
     *
     * @return CrepMso3
     */
    public function setElementsParticuliers($elementsParticuliers)
    {
        $this->elementsParticuliers = $elementsParticuliers;

        return $this;
    }

    /**
     * Get elementsParticuliers.
     *
     * @return string
     */
    public function getElementsParticuliers()
    {
        return $this->elementsParticuliers;
    }

    /**
     * Set observationsAgentSurSonActivite.
     *
     * @param string $observationsAgentSurSonActivite
     *
     * @return CrepMso3
     */
    public function setObservationsAgentSurSonActivite($observationsAgentSurSonActivite)
    {
        $this->observationsAgentSurSonActivite = $observationsAgentSurSonActivite;

        return $this;
    }

    /**
     * Get observationsAgentSurSonActivite.
     *
     * @return string
     */
    public function getObservationsAgentSurSonActivite()
    {
        return $this->observationsAgentSurSonActivite;
    }

    /**
     * Set objectifsService.
     *
     * @param string $objectifsService
     *
     * @return CrepMso3
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
     * Set agentsEncadres.
     *
     * @param string $agentsEncadres
     *
     * @return CrepMso3
     */
    public function setAgentsEncadres($agentsEncadres)
    {
        $this->agentsEncadres = $agentsEncadres;

        return $this;
    }

    /**
     * Get agentsEncadres.
     *
     * @return string
     */
    public function getAgentsEncadres()
    {
        return $this->agentsEncadres;
    }

    /**
     * Set contextePrevisibleAnnee.
     *
     * @param string $contextePrevisibleAnnee
     *
     * @return CrepMso3
     */
    public function setContextePrevisibleAnnee($contextePrevisibleAnnee)
    {
        $this->contextePrevisibleAnnee = $contextePrevisibleAnnee;

        return $this;
    }

    /**
     * Get contextePrevisibleAnnee.
     *
     * @return string
     */
    public function getContextePrevisibleAnnee()
    {
        return $this->contextePrevisibleAnnee;
    }

    /**
     * Set evolutionPosteActuel.
     *
     * @param string $evolutionPosteActuel
     *
     * @return CrepMso3
     */
    public function setEvolutionPosteActuel($evolutionPosteActuel)
    {
        $this->evolutionPosteActuel = $evolutionPosteActuel;

        return $this;
    }

    /**
     * Get evolutionPosteActuel.
     *
     * @return string
     */
    public function getEvolutionPosteActuel()
    {
        return $this->evolutionPosteActuel;
    }

    /**
     * Set modificationFicheDePoste.
     *
     * @param string $modificationFicheDePoste
     *
     * @return CrepMso3
     */
    public function setModificationFicheDePoste($modificationFicheDePoste)
    {
        $this->modificationFicheDePoste = $modificationFicheDePoste;

        return $this;
    }

    /**
     * Get modificationFicheDePoste.
     *
     * @return string
     */
    public function getModificationFicheDePoste()
    {
        return $this->modificationFicheDePoste;
    }

    /**
     * Set priseDeResponsabilites.
     *
     * @param string $priseDeResponsabilites
     *
     * @return CrepMso3
     */
    public function setPriseDeResponsabilites($priseDeResponsabilites)
    {
        $this->priseDeResponsabilites = $priseDeResponsabilites;

        return $this;
    }

    /**
     * Get priseDeResponsabilites.
     *
     * @return string
     */
    public function getPriseDeResponsabilites()
    {
        return $this->priseDeResponsabilites;
    }

    /**
     * Set projetProfessionnel.
     *
     * @param string $projetProfessionnel
     *
     * @return CrepMso3
     */
    public function setProjetProfessionnel($projetProfessionnel)
    {
        $this->projetProfessionnel = $projetProfessionnel;

        return $this;
    }

    /**
     * Get projetProfessionnel.
     *
     * @return string
     */
    public function getProjetProfessionnel()
    {
        return $this->projetProfessionnel;
    }

    /**
     * Set observationsShdPerspectivesProfessionnelles.
     *
     * @param string $observationsShdPerspectivesProfessionnelles
     *
     * @return CrepMso3
     */
    public function setObservationsShdPerspectivesProfessionnelles($observationsShdPerspectivesProfessionnelles)
    {
        $this->observationsShdPerspectivesProfessionnelles = $observationsShdPerspectivesProfessionnelles;

        return $this;
    }

    /**
     * Get observationsShdPerspectivesProfessionnelles.
     *
     * @return string
     */
    public function getObservationsShdPerspectivesProfessionnelles()
    {
        return $this->observationsShdPerspectivesProfessionnelles;
    }

    /**
     * Set avisShdAvancementGrade.
     *
     * @param string $avisShdAvancementGrade
     *
     * @return CrepMso3
     */
    public function setAvisShdAvancementGrade($avisShdAvancementGrade)
    {
        $this->avisShdAvancementGrade = $avisShdAvancementGrade;

        return $this;
    }

    /**
     * Get avisShdAvancementGrade.
     *
     * @return string
     */
    public function getAvisShdAvancementGrade()
    {
        return $this->avisShdAvancementGrade;
    }

    /**
     * Set observationsAgentPerspectivesProfessionnelles.
     *
     * @param string $observationsAgentPerspectivesProfessionnelles
     *
     * @return CrepMso3
     */
    public function setObservationsAgentPerspectivesProfessionnelles($observationsAgentPerspectivesProfessionnelles)
    {
        $this->observationsAgentPerspectivesProfessionnelles = $observationsAgentPerspectivesProfessionnelles;

        return $this;
    }

    /**
     * Get observationsAgentPerspectivesProfessionnelles.
     *
     * @return string
     */
    public function getObservationsAgentPerspectivesProfessionnelles()
    {
        return $this->observationsAgentPerspectivesProfessionnelles;
    }

    /**
     * Set aptitudesExercerFonctionsSupperieures.
     *
     * @param string $aptitudesExercerFonctionsSupperieures
     *
     * @return CrepMso3
     */
    public function setAptitudesExercerFonctionsSupperieures($aptitudesExercerFonctionsSupperieures)
    {
        $this->aptitudesExercerFonctionsSupperieures = $aptitudesExercerFonctionsSupperieures;

        return $this;
    }

    /**
     * Get aptitudesExercerFonctionsSupperieures.
     *
     * @return string
     */
    public function getAptitudesExercerFonctionsSupperieures()
    {
        return $this->aptitudesExercerFonctionsSupperieures;
    }

    /**
     * Set appreciationLitteraleShd.
     *
     * @param string $appreciationLitteraleShd
     *
     * @return CrepMso3
     */
    public function setAppreciationLitteraleShd($appreciationLitteraleShd)
    {
        $this->appreciationLitteraleShd = $appreciationLitteraleShd;

        return $this;
    }

    /**
     * Get appreciationLitteraleShd.
     *
     * @return string
     */
    public function getAppreciationLitteraleShd()
    {
        return $this->appreciationLitteraleShd;
    }

    /**
     * Set observationsAppreciationsPorteesAgent.
     *
     * @param string $observationsAppreciationsPorteesAgent
     *
     * @return CrepMso3
     */
    public function setObservationsAppreciationsPorteesAgent($observationsAppreciationsPorteesAgent)
    {
        $this->observationsAppreciationsPorteesAgent = $observationsAppreciationsPorteesAgent;

        return $this;
    }

    /**
     * Get observationsAppreciationsPorteesAgent.
     *
     * @return string
     */
    public function getObservationsAppreciationsPorteesAgent()
    {
        return $this->observationsAppreciationsPorteesAgent;
    }

    /**
     * Set observationsConduiteEntretienAh.
     *
     * @param string $observationsConduiteEntretienAh
     *
     * @return CrepMso3
     */
    public function setObservationsConduiteEntretienAh($observationsConduiteEntretienAh)
    {
        $this->observationsConduiteEntretienAh = $observationsConduiteEntretienAh;

        return $this;
    }

    /**
     * Get observationsConduiteEntretienAh.
     *
     * @return string
     */
    public function getObservationsConduiteEntretienAh()
    {
        return $this->observationsConduiteEntretienAh;
    }

    /**
     * Set observationsAppreciationsPorteesAh.
     *
     * @param string $observationsAppreciationsPorteesAh
     *
     * @return CrepMso3
     */
    public function setObservationsAppreciationsPorteesAh($observationsAppreciationsPorteesAh)
    {
        $this->observationsAppreciationsPorteesAh = $observationsAppreciationsPorteesAh;

        return $this;
    }

    /**
     * Get observationsAppreciationsPorteesAh.
     *
     * @return string
     */
    public function getObservationsAppreciationsPorteesAh()
    {
        return $this->observationsAppreciationsPorteesAh;
    }

    /**
     * Set observationsEventuellesAh.
     *
     * @param string $observationsEventuellesAh
     *
     * @return CrepMso3
     */
    public function setObservationsEventuellesAh($observationsEventuellesAh)
    {
        $this->observationsEventuellesAh = $observationsEventuellesAh;

        return $this;
    }

    /**
     * Get observationsEventuellesAh.
     *
     * @return string
     */
    public function getObservationsEventuellesAh()
    {
        return $this->observationsEventuellesAh;
    }

    /**
     * Set fonctionAh.
     *
     * @param string $fonctionAh
     *
     * @return CrepMso3
     */
    public function setFonctionAh($fonctionAh)
    {
        $this->fonctionAh = $fonctionAh;

        return $this;
    }

    /**
     * Get fonctionAh.
     *
     * @return string
     */
    public function getFonctionAh()
    {
        return $this->fonctionAh;
    }

    /**
     * Add competencesRequise.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceRequise $competencesRequise
     *
     * @return CrepMso3
     */
    public function addCompetencesRequise(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceRequise $competencesRequise)
    {
        $this->competencesRequises[] = $competencesRequise;

        $competencesRequise->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesRequise.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceRequise $competencesRequise
     */
    public function removeCompetencesRequise(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceRequise $competencesRequise)
    {
        $this->competencesRequises->removeElement($competencesRequise);

        $competencesRequise->setCrep(null);
    }

    /**
     * Get competencesRequises.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesRequises()
    {
        return $this->competencesRequises;
    }

    /**
     * Add savoirsFairePoste.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePoste $savoirsFairePoste
     *
     * @return CrepMso3
     */
    public function addSavoirsFairePoste(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePoste $savoirsFairePoste)
    {
        $this->savoirsFairePoste[] = $savoirsFairePoste;

        $savoirsFairePoste->setCrep($this);

        return $this;
    }

    /**
     * Remove savoirsFairePoste.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePoste $savoirsFairePoste
     */
    public function removeSavoirsFairePoste(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePoste $savoirsFairePoste)
    {
        $this->savoirsFairePoste->removeElement($savoirsFairePoste);

        $savoirsFairePoste->setCrep(null);
    }

    /**
     * Get savoirsFairePoste.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSavoirsFairePoste()
    {
        return $this->savoirsFairePoste;
    }

    /**
     * Add savoirsFairePosteAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePosteAutre $savoirsFairePosteAutre
     *
     * @return CrepMso3
     */
    public function addSavoirsFairePosteAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePosteAutre $savoirsFairePosteAutre)
    {
        $this->savoirsFairePosteAutres[] = $savoirsFairePosteAutre;

        $savoirsFairePosteAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove savoirsFairePosteAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePosteAutre $savoirsFairePosteAutre
     */
    public function removeSavoirsFairePosteAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFairePosteAutre $savoirsFairePosteAutre)
    {
        $this->savoirsFairePosteAutres->removeElement($savoirsFairePosteAutre);

        $savoirsFairePosteAutre->setCrep(null);
    }

    /**
     * Get savoirsFairePosteAutres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSavoirsFairePosteAutres()
    {
        return $this->savoirsFairePosteAutres;
    }

    /**
     * Add qualitesRelationnellesPoste.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePoste $qualitesRelationnellesPoste
     *
     * @return CrepMso3
     */
    public function addQualitesRelationnellesPoste(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePoste $qualitesRelationnellesPoste)
    {
        $this->qualitesRelationnellesPoste[] = $qualitesRelationnellesPoste;

        $qualitesRelationnellesPoste->setCrep($this);

        return $this;
    }

    /**
     * Remove qualitesRelationnellesPoste.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePoste $qualitesRelationnellesPoste
     */
    public function removeQualitesRelationnellesPoste(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePoste $qualitesRelationnellesPoste)
    {
        $this->qualitesRelationnellesPoste->removeElement($qualitesRelationnellesPoste);

        $qualitesRelationnellesPoste->setCrep(null);
    }

    /**
     * Get qualitesRelationnellesPoste.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualitesRelationnellesPoste()
    {
        return $this->qualitesRelationnellesPoste;
    }

    /**
     * Add qualitesRelationnellesPosteAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePosteAutre $qualitesRelationnellesPosteAutre
     *
     * @return CrepMso3
     */
    public function addQualitesRelationnellesPosteAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePosteAutre $qualitesRelationnellesPosteAutre)
    {
        $this->qualitesRelationnellesPosteAutres[] = $qualitesRelationnellesPosteAutre;

        $qualitesRelationnellesPosteAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove qualitesRelationnellesPosteAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePosteAutre $qualitesRelationnellesPosteAutre
     */
    public function removeQualitesRelationnellesPosteAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnellePosteAutre $qualitesRelationnellesPosteAutre)
    {
        $this->qualitesRelationnellesPosteAutres->removeElement($qualitesRelationnellesPosteAutre);

        $qualitesRelationnellesPosteAutre->setCrep(null);
    }

    /**
     * Get qualitesRelationnellesPosteAutres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualitesRelationnellesPosteAutres()
    {
        return $this->qualitesRelationnellesPosteAutres;
    }

    /**
     * Add competencesMisesEnOeuvre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceMiseEnOeuvre $competencesMisesEnOeuvre
     *
     * @return CrepMso3
     */
    public function addCompetencesMisesEnOeuvre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceMiseEnOeuvre $competencesMisesEnOeuvre)
    {
        $this->competencesMisesEnOeuvre[] = $competencesMisesEnOeuvre;

        $competencesMisesEnOeuvre->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesMisesEnOeuvre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceMiseEnOeuvre $competencesMisesEnOeuvre
     */
    public function removeCompetencesMisesEnOeuvre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceMiseEnOeuvre $competencesMisesEnOeuvre)
    {
        $this->competencesMisesEnOeuvre->removeElement($competencesMisesEnOeuvre);

        $competencesMisesEnOeuvre->setCrep(null);
    }

    /**
     * Get competencesMisesEnOeuvre.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesMisesEnOeuvre()
    {
        return $this->competencesMisesEnOeuvre;
    }

    /**
     * Add savoirsFaireAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgent $savoirsFaireAgent
     *
     * @return CrepMso3
     */
    public function addSavoirsFaireAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgent $savoirsFaireAgent)
    {
        $this->savoirsFaireAgent[] = $savoirsFaireAgent;

        $savoirsFaireAgent->setCrep($this);

        return $this;
    }

    /**
     * Remove savoirsFaireAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgent $savoirsFaireAgent
     */
    public function removeSavoirsFaireAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgent $savoirsFaireAgent)
    {
        $this->savoirsFaireAgent->removeElement($savoirsFaireAgent);

        $savoirsFaireAgent->setCrep(null);
    }

    /**
     * Get savoirsFaireAgent.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSavoirsFaireAgent()
    {
        return $this->savoirsFaireAgent;
    }

    /**
     * Add savoirsFaireAgentAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgentAutre $savoirsFaireAgentAutre
     *
     * @return CrepMso3
     */
    public function addSavoirsFaireAgentAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgentAutre $savoirsFaireAgentAutre)
    {
        $this->savoirsFaireAgentAutres[] = $savoirsFaireAgentAutre;

        $savoirsFaireAgentAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove savoirsFaireAgentAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgentAutre $savoirsFaireAgentAutre
     */
    public function removeSavoirsFaireAgentAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3SavoirFaireAgentAutre $savoirsFaireAgentAutre)
    {
        $this->savoirsFaireAgentAutres->removeElement($savoirsFaireAgentAutre);

        $savoirsFaireAgentAutre->setCrep(null);
    }

    /**
     * Get savoirsFaireAgentAutres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSavoirsFaireAgentAutres()
    {
        return $this->savoirsFaireAgentAutres;
    }

    /**
     * Add qualitesRelationnellesAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgent $qualitesRelationnellesAgent
     *
     * @return CrepMso3
     */
    public function addQualitesRelationnellesAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgent $qualitesRelationnellesAgent)
    {
        $this->qualitesRelationnellesAgent[] = $qualitesRelationnellesAgent;

        $qualitesRelationnellesAgent->setCrep($this);

        return $this;
    }

    /**
     * Remove qualitesRelationnellesAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgent $qualitesRelationnellesAgent
     */
    public function removeQualitesRelationnellesAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgent $qualitesRelationnellesAgent)
    {
        $this->qualitesRelationnellesAgent->removeElement($qualitesRelationnellesAgent);

        $qualitesRelationnellesAgent->setCrep(null);
    }

    /**
     * Get qualitesRelationnellesAgent.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualitesRelationnellesAgent()
    {
        return $this->qualitesRelationnellesAgent;
    }

    /**
     * Add qualitesRelationnellesAgentAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgentAutre $qualitesRelationnellesAgentAutre
     *
     * @return CrepMso3
     */
    public function addQualitesRelationnellesAgentAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgentAutre $qualitesRelationnellesAgentAutre)
    {
        $this->qualitesRelationnellesAgentAutres[] = $qualitesRelationnellesAgentAutre;

        $qualitesRelationnellesAgentAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove qualitesRelationnellesAgentAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgentAutre $qualitesRelationnellesAgentAutre
     */
    public function removeQualitesRelationnellesAgentAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3QualiteRelationnelleAgentAutre $qualitesRelationnellesAgentAutre)
    {
        $this->qualitesRelationnellesAgentAutres->removeElement($qualitesRelationnellesAgentAutre);

        $qualitesRelationnellesAgentAutre->setCrep(null);
    }

    /**
     * Get qualitesRelationnellesAgentAutres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualitesRelationnellesAgentAutres()
    {
        return $this->qualitesRelationnellesAgentAutres;
    }

    /**
     * Add aptitudesManagementAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\AptitudeManagementAgent $aptitudesManagementAgent
     *
     * @return CrepMso3
     */
    public function addAptitudesManagementAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3AptitudeManagementAgent $aptitudesManagementAgent)
    {
        $this->aptitudesManagementAgent[] = $aptitudesManagementAgent;

        $aptitudesManagementAgent->setCrep($this);

        return $this;
    }

    /**
     * Remove aptitudesManagementAgent.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\AptitudeManagementAgent $aptitudesManagementAgent
     */
    public function removeAptitudesManagementAgent(\AppBundle\Entity\Crep\CrepMso3\CrepMso3AptitudeManagementAgent $aptitudesManagementAgent)
    {
        $this->aptitudesManagementAgent->removeElement($aptitudesManagementAgent);

        $aptitudesManagementAgent->setCrep(null);
    }

    /**
     * Get aptitudesManagementAgent.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAptitudesManagementAgent()
    {
        return $this->aptitudesManagementAgent;
    }

    /**
     * Add formationsN1.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN1 $formationsN1
     *
     * @return CrepMso3
     */
    public function addFormationsN1(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN1 $formationsN1)
    {
        $this->formationsN1[] = $formationsN1;

        $formationsN1->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsN1.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN1 $formationsN1
     */
    public function removeFormationsN1(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN1 $formationsN1)
    {
        $this->formationsN1->removeElement($formationsN1);

        $formationsN1->setCrep(null);
    }

    /**
     * Get formationsN1.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsN1()
    {
        return $this->formationsN1;
    }

    /**
     * Add formationsN2.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN2 $formationsN2
     *
     * @return CrepMso3
     */
    public function addFormationsN2(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN2 $formationsN2)
    {
        $this->formationsN2[] = $formationsN2;

        $formationsN2->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsN2.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN2 $formationsN2
     */
    public function removeFormationsN2(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN2 $formationsN2)
    {
        $this->formationsN2->removeElement($formationsN2);

        $formationsN2->setCrep(null);
    }

    /**
     * Get formationsN2.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsN2()
    {
        return $this->formationsN2;
    }

    /**
     * Add formationsT1.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT1 $formationsT1
     *
     * @return CrepMso3
     */
    public function addFormationsT1(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT1 $formationsT1)
    {
        $this->formationsT1[] = $formationsT1;

        $formationsT1->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT1.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT1 $formationsT1
     */
    public function removeFormationsT1(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT1 $formationsT1)
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
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT2 $formationsT2
     *
     * @return CrepMso3
     */
    public function addFormationsT2(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT2 $formationsT2)
    {
        $this->formationsT2[] = $formationsT2;

        $formationsT2->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT2.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT2 $formationsT2
     */
    public function removeFormationsT2(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT2 $formationsT2)
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
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT3 $formationsT3
     *
     * @return CrepMso3
     */
    public function addFormationsT3(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT3 $formationsT3)
    {
        $this->formationsT3[] = $formationsT3;

        $formationsT3->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsT3.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT3 $formationsT3
     */
    public function removeFormationsT3(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationT3 $formationsT3)
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
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationPreparationConcours $formationsPreparationConcour
     *
     * @return CrepMso3
     */
    public function addFormationsPreparationConcour(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationPreparationConcours $formationsPreparationConcour)
    {
        $this->formationsPreparationConcours[] = $formationsPreparationConcour;

        $formationsPreparationConcour->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsPreparationConcour.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationPreparationConcours $formationsPreparationConcour
     */
    public function removeFormationsPreparationConcour(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationPreparationConcours $formationsPreparationConcour)
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
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationAutre $formationsAutre
     *
     * @return CrepMso3
     */
    public function addFormationsAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationAutre $formationsAutre)
    {
        $this->formationsAutres[] = $formationsAutre;

        $formationsAutre->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAutre.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationAutre $formationsAutre
     */
    public function removeFormationsAutre(\AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationAutre $formationsAutre)
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
     * Add competencesManiereServir.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceManiereServirAgent $competencesManiereServir
     *
     * @return CrepMso3
     */
    public function addCompetencesManiereServir(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceManiereServirAgent $competencesManiereServir)
    {
        $this->competencesManiereServir[] = $competencesManiereServir;

        $competencesManiereServir->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesManiereServir.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceManiereServirAgent $competencesManiereServir
     */
    public function removeCompetencesManiereServir(\AppBundle\Entity\Crep\CrepMso3\CrepMso3CompetenceManiereServirAgent $competencesManiereServir)
    {
        $this->competencesManiereServir->removeElement($competencesManiereServir);

        $competencesManiereServir->setCrep(null);
    }

    /**
     * Get competencesManiereServir.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesManiereServir()
    {
        return $this->competencesManiereServir;
    }

    public function getSouhaitEntretienCarriere()
    {
        return $this->souhaitEntretienCarriere;
    }

    public function setSouhaitEntretienCarriere($souhaitEntretienCarriere)
    {
        $this->souhaitEntretienCarriere = $souhaitEntretienCarriere;

        return $this;
    }

    /**
     * @Assert\Callback()
     */
    public function validateCrepMso3(ExecutionContextInterface $context)
    {
        if ($this->pointsActualisesFichePoste && true == $this->fichePosteAdaptee) {
            $context->buildViolation('Ce champ doit être vide si la fiche de poste est adaptée')
            ->atPath('pointsActualisesFichePoste')
            ->addViolation();
        }
    }

    /**
     * Méthode appelée lors d'un rattachement d'un nouveau N+1.
     */
    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this
                ->setPrenomShd($shd->getPrenom())
                ->setNomUsageShd($shd->getNom())
                ->setCategorieShd($shd->getCategorieAgent())
                ->setCorpsShd($shd->getCorps())
                ->setGradeShd($shd->getGrade());
        } else {
            $this
                ->setPrenomShd(null)
                ->setNomUsageShd(null)
                ->setCategorieShd(null)
                ->setCorpsShd(null)
                ->setGradeShd(null);
        }
    }

    public function confidentialisationChampsShd()
    {
        $this
            ->setFonctionsExercees(null)
            ->setCotationPoste(null)
            ->setQuotiteTravail(null)
            ->setFichePosteAdaptee(null)
            ->setPointsActualisesFichePoste(null)
            ->setAppreciationPosteAgent(null)
            ->setContexteAnneeEcoulee(null);

        $this->objectifsEvalues->clear();

        $this
            ->setNatureDossiersTravaux(null)
            ->setResultatsObtenusParAgent(null)
            ->setContexteResultats(null)
            ->setAppreciationEvaluateur(null)
            ->setElementsParticuliers(null)
            ->setObjectifsService(null)
            ->setContextePrevisibleAnnee(null);

        $this->objectifsFuturs->clear();
        $this->competencesRequises->clear();

        /* @var $savoirFairePoste  CrepMso3SavoirFairePoste */
        foreach ($this->savoirsFairePoste as $savoirFairePoste) {
            $savoirFairePoste
                ->setNiveau(null)
                ->setAppreciation(null);
        }
        $this->savoirsFairePosteAutres->clear();

        foreach ($this->qualitesRelationnellesPoste as $qualiteRelationnelle) {
            $qualiteRelationnelle
                ->setNiveau(null)
                ->setAppreciation(null);
        }
        $this->qualitesRelationnellesPosteAutres->clear();

        $this->competencesMisesEnOeuvre->clear();

        foreach ($this->savoirsFaireAgent as $savoirFaireAgent) {
            $savoirFaireAgent
                ->setNiveau(null)
                ->setAppreciation(null);
        }
        $this->savoirsFaireAgentAutres->clear();

        foreach ($this->qualitesRelationnellesAgent as $qualiteRelationnelle) {
            $qualiteRelationnelle
                    ->setNiveau(null)
                    ->setAppreciation(null);
        }
        $this->qualitesRelationnellesAgentAutres->clear();

        $this->setAgentsEncadres(null);

        foreach ($this->aptitudesManagementAgent as $aptitude) {
            $aptitude
            ->setNiveau(null)
            ->setAppreciation(null);
        }

        $this->formationsN1->clear();
        $this->formationsN2->clear();
        $this->formationsT1->clear();
        $this->formationsT2->clear();
        $this->formationsT3->clear();
        $this->formationsPreparationConcours->clear();
        $this->formationsAutres->clear();

        $this
            ->setEvolutionPosteActuel(null)
            ->setModificationFicheDePoste(null)
            ->setPriseDeResponsabilites(null)
            ->setProjetProfessionnel(null)
            ->setSouhaitEntretienCarriere(null)
            ->setObservationsShdPerspectivesProfessionnelles(null)
            ->setAvisShdAvancementGrade(null);

        foreach ($this->competencesManiereServir as $competence) {
            $competence->setNiveau(null);
        }

        $this
            ->setAptitudesExercerFonctionsSupperieures(null)
            ->setAppreciationLitteraleShd(null)
            ->setDateEntretien(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this
            ->setObservationsAppreciationsPorteesAgent(null)
            ->setObservationsVisaAgent(null)
            ->setObservationsAgentSurSonActivite(null)
            ->setObservationsAgentPerspectivesProfessionnelles(null);
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    public function confidentialisationChampsAh()
    {
        $this
            ->setObservationsConduiteEntretienAh(null)
            ->setObservationsAppreciationsPorteesAh(null)
            ->setFonctionAh(null)
            ->setObservationsEventuellesAh(null);
    }
}
