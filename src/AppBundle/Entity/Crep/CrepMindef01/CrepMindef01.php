<?php
namespace AppBundle\Entity\Crep\CrepMindef01;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;
use AppBundle\Entity\RepriseMINDEF2016\ObjectifFutur2016;
use AppBundle\Entity\FormationAVenir;
use AppBundle\Entity\FormationDemandeeAdministration;
use AppBundle\Entity\FormationReglementaire;
use AppBundle\Entity\FormationDemandeeAgent;
use AppBundle\Util\Converter;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Emploi;
use AppBundle\Entity\FormationSuivie;
use AppBundle\Entity\ObjectifEvalue;
use AppBundle\Entity\MotivationsMobilite;
use AppBundle\Entity\DemandeFormationProfessionnelle;
use AppBundle\Entity\Crep;
use AppBundle\Entity\MobiliteFonctionnelle;
use AppBundle\Entity\MobiliteGeographique;
use AppBundle\Entity\MobiliteExterne;
use AppBundle\Entity\Crep\CrepMindef01\AutreDomaine;
use AppBundle\Entity\Crep\CrepMindef01\Technique;
use Doctrine\ORM\EntityManagerInterface;


/**
 * CrepMindef01.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindef01Repository")
 * @ORM\HasLifecycleCallbacks()
 */
class CrepMindef01 extends Crep
{
    /**
     * @var string @ORM\Column(type="string", nullable=true)
     */
    protected $matriculeAlliance;

    /**
     * @var string @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom de famille obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomNaissance;

    /**
     * @var string @ORM\Column(type="string")
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nomUsage;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Prénom obligatoire", groups={"SignatureShd"})
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
     */
    protected $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="corps", type="string", nullable=true)
     */
    protected $corps;

    /**
     * @var \DateTime @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le corps non valide")
     */
    protected $dateEntreeCorps;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $grade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le grade non valide")
     */
    protected $dateEntreeGrade;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    protected $echelon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntreeEchelon;

    /**
     * @ORM\Column(type="string")
     */
    protected $codePosteAlliance;

    /**
     * @var string @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom de famille obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomNaissanceShd;

    /**
     * @var string @ORM\Column(type="string")
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nomUsageShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Prénom obligatoire", groups={"SignatureShd"})
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $prenomShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $corpsShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $gradeShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $affectationSigleAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $affectationClairAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupeAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="date_ent_post_occupe_agent")
     * @Assert\Date(message = "Date d'entrée dans le poste non valide")
     */
    protected $dateEntreePosteOccupeAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupeShd;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $fichePoseAJour;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $pointsActualisesFichePoste;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $autresActivites;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $resultatAutresActivites;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_objectifs_passes")
     */
    protected $observationsAgentObjectifsPasses;

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
    protected $nbAgentsEncadresA;

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
    protected $nbAgentsEncadresB;

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
    protected $nbAgentsEncadresC;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="ctx_obj_annee_en_cours")
     */
    protected $contexteObjectifsAnneeEnCours;

    /**
     * @var bool
     *
     * @ORM\Column(name="souhait_ent_carriere_mindef", type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var bool
     *
     * @ORM\Column(name="souhait_evol_pro_mindef", type="boolean", nullable=true)
     */
    protected $souhaitEvolutionProfessionnelle;

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
    protected $capitalDif;

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
    protected $capitalDifMobilisable;

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
    protected $capitalDifEstimation;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $evaluationGlobale;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="aptitudes_exercer_fonct_supp")
     */
    protected $aptitudesExercerFonctionsSupperieures;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $appreciationLitteraleShd;

    /**
     * @ORM\OneToMany(targetEntity="CrepMindef01CompetenceManageriale", mappedBy="crepMindef01", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $competencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepMindef01CompetenceTransverse", mappedBy="crepMindef01", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $competencesTransverses;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $categorieAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $categorieShd;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteOrganisme1;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteOrganisme2;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteOrganisme3;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteOrganisme4;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobilitePoste1;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobilitePoste2;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobilitePoste3;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobilitePoste4;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteZoneGeo1;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteZoneGeo2;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteZoneGeo3;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobiliteZoneGeo4;

    /**
     * @ORM\OneToOne(targetEntity="MotivationsMobilite", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $motivationsMobilite;

    /**
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\DemandeFormationProfessionnelle", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="demande_form_prof_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $demandeFormationProfessionnelle;

    /**
     * =====================================================================================================
     *                                      collections des techniques
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="Technique", mappedBy="crepMindef01", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $techniques;

    /**
     * =====================================================================================================
     *                                         collections des autres domaines
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="AutreDomaine", mappedBy="crepMindef01", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $autresDomaines;

    public static $echelleObjectifEvalue = [
                        'Dépassé(*)(**)' => 0,
                        'Atteint' => 1,
                        'Partiellement Atteint' => 2,
                        'Non atteint(**)' => 3,
                        'Devenu non pertinent(**)' => 4,
                    ];

    public static $echelleNiveauSame = [
                        'Sensibilisation' => 0,
                        'Application' => 1,
                        'Maîtrise' => 2,
                        'Expertise' => 3,
    ];

    public static $selectTypologieFormation = [
        'Formation continue liée à l\'adaptation au poste de travail actuel' => 0,
        'Formation continue liée à l\'évolution prévisible des métiers' => 1,
        'Formation liée au développement des qualifications et à l\'acquisition de compétences' => 2,
                        'Préparation aux concours, examens et essais professionnels' => 3,
    ];

    public function __construct()
    {
        parent::init();
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $dernierCrep = $em->getRepository(Crep::class)->getDernierCrep($agent);
        
        // Reprise des données du CREP N-1
        if($dernierCrep && $dernierCrep instanceof $this){
            
            foreach ($dernierCrep->getObjectifsFuturs() as $objectif){
                $objectifsEvalue = new ObjectifEvalue();
                
                $objectifsEvalue
                    ->setLibelle($objectif->getLibelle())
                    ->setResultatObtenu($this::$echelleObjectifEvalue['Atteint']);
                $this->addObjectifsEvalue($objectifsEvalue);
            }

        	foreach ($dernierCrep->getFormationsAVenir() as $formation){
        		$formationSuivie = new FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		
        		$this->addFormationsSuivy($formationSuivie);
        	}
        	
        	foreach ($this->getFormationsDemandeesAdministration() as $formation){
        		$formationSuivie = new FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        	
        		$this->addFormationsSuivy($formationSuivie);
        	}
        	
        	foreach ($this->getFormationsReglementaires() as $formation){
        		$formationSuivie = new FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsSuivy($formationSuivie);
        	}
        	
        	foreach ($this->getFormationsDemandeesAgent() as $formation){
        		$formationSuivie = new FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        		 
        		$this->addFormationsSuivy($formationSuivie);
        	}
        }
        
        
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());

        $transverses = $em
        ->getRepository('AppBundle:CompetenceTransverse')
        ->findByModeleCrep(Util::getClassName($this));

        $manageriales = $em
        ->getRepository('AppBundle:CompetenceManageriale')
        ->findByModeleCrep(Util::getClassName($this));

        // Reprise des données de l'année 2016 pour l'année 2017
//         if (2017 == $agent->getCampagnePnc()->getAnneeEvaluee()) {
//             // Récupération des objectifs futurs 2016
//             $objectifsFuturs2016 = $em
//             ->getRepository('AppBundle:RepriseMINDEF2016\ObjectifFutur2016')
//             ->findByEmail($agent->getEmail());

//             // Récupération des formations à venir 2016
//             $formationsAVenir2016 = $em
//             ->getRepository('AppBundle:RepriseMINDEF2016\FormationAVenir2016')
//             ->findByEmail($agent->getEmail());

//             // Récupération des formations demandées administration 2016
//             $formationsDemandeesAdministration2016 = $em
//             ->getRepository('AppBundle:RepriseMINDEF2016\FormationDemandeeAdministration2016')
//             ->findByEmail($agent->getEmail());

//             // Récupération des formations réglementaires 2016
//             $formationsReglementaires2016 = $em
//             ->getRepository('AppBundle:RepriseMINDEF2016\FormationReglementaire2016')
//             ->findByEmail($agent->getEmail());

//             // Récupération des formations demandées par l'agent en 2016
//             $formationsDemandeesAgent2016 = $em
//             ->getRepository('AppBundle:RepriseMINDEF2016\FormationDemandeeAgent2016')
//             ->findByEmail($agent->getEmail());

//             /* @var $objectif ObjectifFutur2016 */
//             foreach ($objectifsFuturs2016 as $objectif) {
//                 $objectif2017 = new ObjectifEvalue();
//                 $objectif2017->setLibelle($objectif->getLibelle())
//                             ->setResultatObtenu($this::$echelleObjectifEvalue['Atteint']);

//                 $this->addObjectifsEvalue($objectif2017);
//             }

//             /* @var $formation FormationAVenir */
//             foreach ($formationsAVenir2016 as $formation) {
//                 $formationSuivie = new FormationSuivie();
//                 $formationSuivie->setLibelle($formation->getLibelle());
//                 $this->addFormationsSuivy($formationSuivie);
//             }

//             /* @var $formation FormationDemandeeAdministration */
//             foreach ($formationsDemandeesAdministration2016 as $formation) {
//                 $formationSuivie = new FormationSuivie();
//                 $formationSuivie->setLibelle($formation->getLibelle());
//                 $this->addFormationsSuivy($formationSuivie);
//             }

//             /* @var $formation FormationReglementaire */
//             foreach ($formationsReglementaires2016 as $formation) {
//                 $formationSuivie = new FormationSuivie();
//                 $formationSuivie->setLibelle($formation->getLibelle());
//                 $this->addFormationsSuivy($formationSuivie);
//             }

//             /* @var $formation FormationDemandeeAgent */
//             foreach ($formationsDemandeesAgent2016 as $formation) {
//                 $formationSuivie = new FormationSuivie();
//                 $formationSuivie->setLibelle($formation->getLibelle());
//                 $this->addFormationsSuivy($formationSuivie);
//             }
//         }
        // Fin de la partie reprise des données de l'année 2016 pour l'année 2017

        /// Valable pour XP ///
        foreach ($transverses as $transverse) {
            $competenceTransverse = new CrepMindef01CompetenceTransverse();
            $competenceTransverse->setCompetenceTransverse($transverse);
            $this->addCompetencesTransverse($competenceTransverse);
        }

        foreach ($manageriales as $manageriale) {
            $competenceManageriale = new CrepMindef01CompetenceManageriale();
            $competenceManageriale->setCompetenceManageriale($manageriale);
            $this->addCompetencesManageriale($competenceManageriale);
        }

        $motivationsMobilite = new MotivationsMobilite();
        $this->setMotivationsMobilite($motivationsMobilite);

        $demandeFormationProfessionnelle = new DemandeFormationProfessionnelle();
        $this->setDemandeFormationProfessionnelle($demandeFormationProfessionnelle);

        ///  FIN Valable pour XP ///

        /* @var $crep CrepMindef01 */
        $this->setMatriculeAlliance($agent->getMatricule());
        $this->setNomUsage($agent->getNom());
        $this->setNomNaissance($agent->getNomNaissance());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setCorps($agent->getCorps());
        $this->setDateEntreeCorps($agent->getDateEntreeCorps());
        $this->setGrade($agent->getGrade());
        $this->setDateEntreeGrade($agent->getDateEntreeGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDateEntreeEchelon($agent->getDateEntreeEchelon());

        $this->setAffectationSigleAgent($agent->getAffectation());
        $this->setPosteOccupeAgent($agent->getPosteOccupe());
        $this->setDateEntreePosteOccupeAgent($agent->getDateEntreePosteOccupe());
        $this->setCodePosteAlliance($agent->getCodeSirh1());

        $this->setCategorieAgent($agent->getCategorieAgent());
        $this->setAffectationClairAgent($agent->getAffectationClairAgent());
        $this->setCapitalDif($agent->getCapitalDif());
        $this->setCapitalDifMobilisable($agent->getCapitalDifMobilisable());

        if ($agent->getShd()) {
            $this->setNomNaissanceShd($agent->getShd()->getNomNaissance());
            $this->setNomUsageShd($agent->getShd()->getNom());
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setCorpsShd($agent->getShd()->getCorps());
            $this->setGradeShd($agent->getShd()->getGrade());
            $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
            $this->setCategorieShd($agent->getShd()->getCategorieAgent());
        }

        $mobiliteFonctionnelle = new MobiliteFonctionnelle();
        $this->setMobiliteFonctionnelle($mobiliteFonctionnelle);

        $mobiliteGeographique = new MobiliteGeographique();
        $this->setMobiliteGeographique($mobiliteGeographique);

        $mobiliteExterne = new MobiliteExterne();
        $this->setMobiliteExterne($mobiliteExterne);
    }

    /**
     * Set matriculeAlliance.
     *
     * @param string $matriculeAlliance
     *
     * @return CrepMindef01
     */
    public function setMatriculeAlliance($matriculeAlliance)
    {
        $this->matriculeAlliance = $matriculeAlliance;

        return $this;
    }

    /**
     * Get matriculeAlliance.
     *
     * @return string
     */
    public function getMatriculeAlliance()
    {
        return $this->matriculeAlliance;
    }

    /**
     * Set nomNaissance.
     *
     * @param string $nomNaissance
     *
     * @return CrepMindef01
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    /**
     * Get nomNaissance.
     *
     * @return string
     */
    public function getNomNaissance()
    {
        return $this->nomNaissance;
    }

    /**
     * Set nomUsage.
     *
     * @param string $nomUsage
     *
     * @return CrepMindef01
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
     * @return CrepMindef01
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
     * @return CrepMindef01
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
     * Set corps.
     *
     * @param string $corps
     *
     * @return CrepMindef01
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
     * Set dateEntreeCorps.
     *
     * @param \DateTime $dateEntreeCorps
     *
     * @return CrepMindef01
     */
    public function setDateEntreeCorps($dateEntreeCorps)
    {
        $this->dateEntreeCorps = $dateEntreeCorps;

        return $this;
    }

    /**
     * Get dateEntreeCorps.
     *
     * @return \DateTime
     */
    public function getDateEntreeCorps()
    {
        return $this->dateEntreeCorps;
    }

    /**
     * Set grade.
     *
     * @param string $grade
     *
     * @return CrepMindef01
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
     * Set dateEntreeGrade.
     *
     * @param \DateTime $dateEntreeGrade
     *
     * @return CrepMindef01
     */
    public function setDateEntreeGrade($dateEntreeGrade)
    {
        $this->dateEntreeGrade = $dateEntreeGrade;

        return $this;
    }

    /**
     * Get dateEntreeGrade.
     *
     * @return \DateTime
     */
    public function getDateEntreeGrade()
    {
        return $this->dateEntreeGrade;
    }

    /**
     * Set echelon.
     *
     * @param string $echelon
     *
     * @return CrepMindef01
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
     * Set dateEntreeEchelon.
     *
     * @param \DateTime $dateEntreeEchelon
     *
     * @return CrepMindef01
     */
    public function setDateEntreeEchelon($dateEntreeEchelon)
    {
        $this->dateEntreeEchelon = $dateEntreeEchelon;

        return $this;
    }

    /**
     * Get dateEntreeEchelon.
     *
     * @return \DateTime
     */
    public function getDateEntreeEchelon()
    {
        return $this->dateEntreeEchelon;
    }

    /**
     * Set codePosteAlliance.
     *
     * @param string $codePosteAlliance
     *
     * @return CrepMindef01
     */
    public function setCodePosteAlliance($codePosteAlliance)
    {
        $this->codePosteAlliance = $codePosteAlliance;

        return $this;
    }

    /**
     * Get codePosteAlliance.
     *
     * @return string
     */
    public function getCodePosteAlliance()
    {
        return $this->codePosteAlliance;
    }

    /**
     * Set nomNaissanceShd.
     *
     * @param string $nomNaissanceShd
     *
     * @return CrepMindef01
     */
    public function setNomNaissanceShd($nomNaissanceShd)
    {
        $this->nomNaissanceShd = $nomNaissanceShd;

        return $this;
    }

    /**
     * Get nomNaissanceShd.
     *
     * @return string
     */
    public function getNomNaissanceShd()
    {
        return $this->nomNaissanceShd;
    }

    /**
     * Set nomUsageShd.
     *
     * @param string $nomUsageShd
     *
     * @return CrepMindef01
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
     * @return CrepMindef01
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
     * Set corpsShd.
     *
     * @param string $corpsShd
     *
     * @return CrepMindef01
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
     * @return CrepMindef01
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
     * Set affectationSigleAgent.
     *
     * @param string $affectationSigleAgent
     *
     * @return CrepMindef01
     */
    public function setAffectationSigleAgent($affectationSigleAgent)
    {
        $this->affectationSigleAgent = $affectationSigleAgent;

        return $this;
    }

    /**
     * Get affectationSigleAgent.
     *
     * @return string
     */
    public function getAffectationSigleAgent()
    {
        return $this->affectationSigleAgent;
    }

    /**
     * Set affectationClairAgent.
     *
     * @param string $affectationClairAgent
     *
     * @return CrepMindef01
     */
    public function setAffectationClairAgent($affectationClairAgent)
    {
        $this->affectationClairAgent = $affectationClairAgent;

        return $this;
    }

    /**
     * Get affectationClairAgent.
     *
     * @return string
     */
    public function getAffectationClairAgent()
    {
        return $this->affectationClairAgent;
    }

    /**
     * Set posteOccupeAgent.
     *
     * @param string $posteOccupeAgent
     *
     * @return CrepMindef01
     */
    public function setPosteOccupeAgent($posteOccupeAgent)
    {
        $this->posteOccupeAgent = $posteOccupeAgent;

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
     * Set dateEntreePosteOccupeAgent.
     *
     * @param \DateTime $dateEntreePosteOccupeAgent
     *
     * @return CrepMindef01
     */
    public function setDateEntreePosteOccupeAgent($dateEntreePosteOccupeAgent)
    {
        $this->dateEntreePosteOccupeAgent = $dateEntreePosteOccupeAgent;

        return $this;
    }

    /**
     * Get dateEntreePosteOccupeAgent.
     *
     * @return \DateTime
     */
    public function getDateEntreePosteOccupeAgent()
    {
        return $this->dateEntreePosteOccupeAgent;
    }

    /**
     * Set posteOccupeShd.
     *
     * @param string $posteOccupeShd
     *
     * @return CrepMindef01
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;

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
     * Set fichePoseAJour.
     *
     * @param bool $fichePoseAJour
     *
     * @return CrepMindef01
     */
    public function setFichePoseAJour($fichePoseAJour)
    {
        $this->fichePoseAJour = $fichePoseAJour;

        return $this;
    }

    /**
     * Get fichePoseAJour.
     *
     * @return bool
     */
    public function getFichePoseAJour()
    {
        return $this->fichePoseAJour;
    }

    /**
     * Set autresActivites.
     *
     * @param string $autresActivites
     *
     * @return CrepMindef01
     */
    public function setAutresActivites($autresActivites)
    {
        $this->autresActivites = $autresActivites;

        return $this;
    }

    /**
     * Get autresActivites.
     *
     * @return string
     */
    public function getAutresActivites()
    {
        return $this->autresActivites;
    }

    /**
     * Set resultatAutresActivites.
     *
     * @param string $resultatAutresActivites
     *
     * @return CrepMindef01
     */
    public function setResultatAutresActivites($resultatAutresActivites)
    {
        $this->resultatAutresActivites = $resultatAutresActivites;

        return $this;
    }

    /**
     * Get resultatAutresActivites.
     *
     * @return string
     */
    public function getResultatAutresActivites()
    {
        return $this->resultatAutresActivites;
    }

    /**
     * Set observationsAgentObjectifsPasses.
     *
     * @param string $observationsAgentObjectifsPasses
     *
     * @return CrepMindef01
     */
    public function setObservationsAgentObjectifsPasses($observationsAgentObjectifsPasses)
    {
        $this->observationsAgentObjectifsPasses = $observationsAgentObjectifsPasses;

        return $this;
    }

    /**
     * Get observationsAgentObjectifsPasses.
     *
     * @return string
     */
    public function getObservationsAgentObjectifsPasses()
    {
        return $this->observationsAgentObjectifsPasses;
    }

    /**
     * Set nbAgentsEncadresA.
     *
     * @param int $nbAgentsEncadresA
     *
     * @return CrepMindef01
     */
    public function setNbAgentsEncadresA($nbAgentsEncadresA)
    {
        $this->nbAgentsEncadresA = $nbAgentsEncadresA;

        return $this;
    }

    /**
     * Get nbAgentsEncadresA.
     *
     * @return int
     */
    public function getNbAgentsEncadresA()
    {
        return $this->nbAgentsEncadresA;
    }

    /**
     * Set nbAgentsEncadresB.
     *
     * @param int $nbAgentsEncadresB
     *
     * @return CrepMindef01
     */
    public function setNbAgentsEncadresB($nbAgentsEncadresB)
    {
        $this->nbAgentsEncadresB = $nbAgentsEncadresB;

        return $this;
    }

    /**
     * Get nbAgentsEncadresB.
     *
     * @return int
     */
    public function getNbAgentsEncadresB()
    {
        return $this->nbAgentsEncadresB;
    }

    /**
     * Set nbAgentsEncadresC.
     *
     * @param int $nbAgentsEncadresC
     *
     * @return CrepMindef01
     */
    public function setNbAgentsEncadresC($nbAgentsEncadresC)
    {
        $this->nbAgentsEncadresC = $nbAgentsEncadresC;

        return $this;
    }

    /**
     * Get nbAgentsEncadresC.
     *
     * @return int
     */
    public function getNbAgentsEncadresC()
    {
        return $this->nbAgentsEncadresC;
    }

    /**
     * Set contexteObjectifsAnneeEnCours.
     *
     * @param string $contexteObjectifsAnneeEnCours
     *
     * @return CrepMindef01
     */
    public function setContexteObjectifsAnneeEnCours($contexteObjectifsAnneeEnCours)
    {
        $this->contexteObjectifsAnneeEnCours = $contexteObjectifsAnneeEnCours;

        return $this;
    }

    /**
     * Get contexteObjectifsAnneeEnCours.
     *
     * @return string
     */
    public function getContexteObjectifsAnneeEnCours()
    {
        return $this->contexteObjectifsAnneeEnCours;
    }

    /**
     * Set souhaitEntretienCarriere.
     *
     * @param bool $souhaitEntretienCarriere
     *
     * @return CrepMindef01
     */
    public function setSouhaitEntretienCarriere($souhaitEntretienCarriere)
    {
        $this->souhaitEntretienCarriere = $souhaitEntretienCarriere;

        return $this;
    }

    /**
     * Get souhaitEntretienCarriere.
     *
     * @return bool
     */
    public function getSouhaitEntretienCarriere()
    {
        return $this->souhaitEntretienCarriere;
    }

    /**
     * Set capitalDif.
     *
     * @param int $capitalDif
     *
     * @return CrepMindef01
     */
    public function setCapitalDif($capitalDif)
    {
        $this->capitalDif = $capitalDif;

        return $this;
    }

    /**
     * Get capitalDif.
     *
     * @return int
     */
    public function getCapitalDif()
    {
        return $this->capitalDif;
    }

    /**
     * Set capitalDifMobilisable.
     *
     * @param int $capitalDifMobilisable
     *
     * @return CrepMindef01
     */
    public function setCapitalDifMobilisable($capitalDifMobilisable)
    {
        $this->capitalDifMobilisable = $capitalDifMobilisable;

        return $this;
    }

    /**
     * Get capitalDifMobilisable.
     *
     * @return int
     */
    public function getCapitalDifMobilisable()
    {
        return $this->capitalDifMobilisable;
    }

    /**
     * Set evaluationGlobale.
     *
     * @param int $evaluationGlobale
     *
     * @return CrepMindef01
     */
    public function setEvaluationGlobale($evaluationGlobale)
    {
        $this->evaluationGlobale = $evaluationGlobale;

        return $this;
    }

    /**
     * Get evaluationGlobale.
     *
     * @return int
     */
    public function getEvaluationGlobale()
    {
        return $this->evaluationGlobale;
    }

    /**
     * Set aptitudesExercerFonctionsSupperieures.
     *
     * @param string $aptitudesExercerFonctionsSupperieures
     *
     * @return CrepMindef01
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
     * @return CrepMindef01
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
     * Add competencesManageriale.
     *
     * @param CrepMindef01CompetenceManageriale $competencesManageriale
     *
     * @return CrepMindef01
     */
    public function addCompetencesManageriale(CrepMindef01CompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales[] = $competencesManageriale;
        $competencesManageriale->setCrepMindef01($this);

        return $this;
    }

    /**
     * Remove competencesManageriale.
     *
     * @param CrepMindef01CompetenceManageriale $competencesManageriale
     */
    public function removeCompetencesManageriale(CrepMindef01CompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales->removeElement($competencesManageriale);
        $competencesManageriale->setCrepMindef01(null);
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
     * Add competencesTransverse.
     *
     * @param CrepMindef01CompetenceTransverse $competencesTransverse
     *
     * @return $this
     */
    public function addCompetencesTransverse(CrepMindef01CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepMindef01($this);

        return $this;
    }

    /**
     * Remove competencesTransverse.
     *
     * @param CrepMindef01CompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(CrepMindef01CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepMindef01(null);
    }

    /**
     * Get competencesTransverses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesTransverses()
    {
        return $this->competencesTransverses;
    }

    /**
     * Set categorieAgent.
     *
     * @param string $categorieAgent
     *
     * @return CrepMindef01
     */
    public function setCategorieAgent($categorieAgent)
    {
        $this->categorieAgent = $categorieAgent;

        return $this;
    }

    /**
     * Get categorieAgent.
     *
     * @return string
     */
    public function getCategorieAgent()
    {
        return $this->categorieAgent;
    }

    /**
     * Set categorieShd.
     *
     * @param string $categorieShd
     *
     * @return CrepMindef01
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

    public function getPointsActualisesFichePoste()
    {
        return $this->pointsActualisesFichePoste;
    }

    public function setPointsActualisesFichePoste($pointsActualisesFichePoste)
    {
        $this->pointsActualisesFichePoste = $pointsActualisesFichePoste;

        return $this;
    }

    /**
     * Set capitalDifEstimation.
     *
     * @param int $capitalDifEstimation
     *
     * @return CrepMindef01
     */
    public function setCapitalDifEstimation($capitalDifEstimation)
    {
        $this->capitalDifEstimation = $capitalDifEstimation;

        return $this;
    }

    /**
     * Get capitalDifEstimation.
     *
     * @return int
     */
    public function getCapitalDifEstimation()
    {
        return $this->capitalDifEstimation;
    }

    /**
     * Set souhaitEvolutionProfessionnelle.
     *
     * @param bool $souhaitEvolutionProfessionnelle
     *
     * @return CrepMindef01
     */
    public function setSouhaitEvolutionProfessionnelle($souhaitEvolutionProfessionnelle)
    {
        $this->souhaitEvolutionProfessionnelle = $souhaitEvolutionProfessionnelle;

        return $this;
    }

    /**
     * Get souhaitEvolutionProfessionnelle.
     *
     * @return bool
     */
    public function getSouhaitEvolutionProfessionnelle()
    {
        return $this->souhaitEvolutionProfessionnelle;
    }

    /**
     * Set mobiliteOrganisme1.
     *
     * @param string $mobiliteOrganisme1
     *
     * @return CrepMindef01
     */
    public function setMobiliteOrganisme1($mobiliteOrganisme1)
    {
        $this->mobiliteOrganisme1 = $mobiliteOrganisme1;

        return $this;
    }

    /**
     * Get mobiliteOrganisme1.
     *
     * @return string
     */
    public function getMobiliteOrganisme1()
    {
        return $this->mobiliteOrganisme1;
    }

    /**
     * Set mobiliteOrganisme2.
     *
     * @param string $mobiliteOrganisme2
     *
     * @return CrepMindef01
     */
    public function setMobiliteOrganisme2($mobiliteOrganisme2)
    {
        $this->mobiliteOrganisme2 = $mobiliteOrganisme2;

        return $this;
    }

    /**
     * Get mobiliteOrganisme2.
     *
     * @return string
     */
    public function getMobiliteOrganisme2()
    {
        return $this->mobiliteOrganisme2;
    }

    /**
     * Set mobiliteOrganisme3.
     *
     * @param string $mobiliteOrganisme3
     *
     * @return CrepMindef01
     */
    public function setMobiliteOrganisme3($mobiliteOrganisme3)
    {
        $this->mobiliteOrganisme3 = $mobiliteOrganisme3;

        return $this;
    }

    /**
     * Get mobiliteOrganisme3.
     *
     * @return string
     */
    public function getMobiliteOrganisme3()
    {
        return $this->mobiliteOrganisme3;
    }

    /**
     * Set mobiliteOrganisme4.
     *
     * @param string $mobiliteOrganisme4
     *
     * @return CrepMindef01
     */
    public function setMobiliteOrganisme4($mobiliteOrganisme4)
    {
        $this->mobiliteOrganisme4 = $mobiliteOrganisme4;

        return $this;
    }

    /**
     * Get mobiliteOrganisme4.
     *
     * @return string
     */
    public function getMobiliteOrganisme4()
    {
        return $this->mobiliteOrganisme4;
    }

    /**
     * Set mobilitePoste1.
     *
     * @param string $mobilitePoste1
     *
     * @return CrepMindef01
     */
    public function setMobilitePoste1($mobilitePoste1)
    {
        $this->mobilitePoste1 = $mobilitePoste1;

        return $this;
    }

    /**
     * Get mobilitePoste1.
     *
     * @return string
     */
    public function getMobilitePoste1()
    {
        return $this->mobilitePoste1;
    }

    /**
     * Set mobilitePoste2.
     *
     * @param string $mobilitePoste2
     *
     * @return CrepMindef01
     */
    public function setMobilitePoste2($mobilitePoste2)
    {
        $this->mobilitePoste2 = $mobilitePoste2;

        return $this;
    }

    /**
     * Get mobilitePoste2.
     *
     * @return string
     */
    public function getMobilitePoste2()
    {
        return $this->mobilitePoste2;
    }

    /**
     * Set mobilitePoste3.
     *
     * @param string $mobilitePoste3
     *
     * @return CrepMindef01
     */
    public function setMobilitePoste3($mobilitePoste3)
    {
        $this->mobilitePoste3 = $mobilitePoste3;

        return $this;
    }

    /**
     * Get mobilitePoste3.
     *
     * @return string
     */
    public function getMobilitePoste3()
    {
        return $this->mobilitePoste3;
    }

    /**
     * Set mobilitePoste4.
     *
     * @param string $mobilitePoste4
     *
     * @return CrepMindef01
     */
    public function setMobilitePoste4($mobilitePoste4)
    {
        $this->mobilitePoste4 = $mobilitePoste4;

        return $this;
    }

    /**
     * Get mobilitePoste4.
     *
     * @return string
     */
    public function getMobilitePoste4()
    {
        return $this->mobilitePoste4;
    }

    /**
     * Set mobiliteZoneGeo1.
     *
     * @param string $mobiliteZoneGeo1
     *
     * @return CrepMindef01
     */
    public function setMobiliteZoneGeo1($mobiliteZoneGeo1)
    {
        $this->mobiliteZoneGeo1 = $mobiliteZoneGeo1;

        return $this;
    }

    /**
     * Get mobiliteZoneGeo1.
     *
     * @return string
     */
    public function getMobiliteZoneGeo1()
    {
        return $this->mobiliteZoneGeo1;
    }

    /**
     * Set mobiliteZoneGeo2.
     *
     * @param string $mobiliteZoneGeo2
     *
     * @return CrepMindef01
     */
    public function setMobiliteZoneGeo2($mobiliteZoneGeo2)
    {
        $this->mobiliteZoneGeo2 = $mobiliteZoneGeo2;

        return $this;
    }

    /**
     * Get mobiliteZoneGeo2.
     *
     * @return string
     */
    public function getMobiliteZoneGeo2()
    {
        return $this->mobiliteZoneGeo2;
    }

    /**
     * Set mobiliteZoneGeo3.
     *
     * @param string $mobiliteZoneGeo3
     *
     * @return CrepMindef01
     */
    public function setMobiliteZoneGeo3($mobiliteZoneGeo3)
    {
        $this->mobiliteZoneGeo3 = $mobiliteZoneGeo3;

        return $this;
    }

    /**
     * Get mobiliteZoneGeo3.
     *
     * @return string
     */
    public function getMobiliteZoneGeo3()
    {
        return $this->mobiliteZoneGeo3;
    }

    /**
     * Set mobiliteZoneGeo4.
     *
     * @param string $mobiliteZoneGeo4
     *
     * @return CrepMindef01
     */
    public function setMobiliteZoneGeo4($mobiliteZoneGeo4)
    {
        $this->mobiliteZoneGeo4 = $mobiliteZoneGeo4;

        return $this;
    }

    /**
     * Get mobiliteZoneGeo4.
     *
     * @return string
     */
    public function getMobiliteZoneGeo4()
    {
        return $this->mobiliteZoneGeo4;
    }

//     /**
//      * Set motivationsMobilite
//      *
//      * @param \AppBundle\Entity\MotivationsMobilite $motivationsMobilite
//      *
//      * @return CrepMindef01
//      */
//     public function setMotivationsMobilite(\AppBundle\Entity\MotivationsMobilite $motivationsMobilite = null)
//     {
//         $this->motivationsMobilite = $motivationsMobilite;

//         return $this;
//     }

//     /**
//      * Get motivationsMobilite
//      *
//      * @return \AppBundle\Entity\MotivationsMobilite
//      */
//     public function getMotivationsMobilite()
//     {
//         return $this->motivationsMobilite;
//     }

    /**
     * Set demandeFormationProfessionnelle.
     *
     * @param \AppBundle\Entity\DemandeFormationProfessionnelle $demandeFormationProfessionnelle
     *
     * @return CrepMindef01
     */
    public function setDemandeFormationProfessionnelle(\AppBundle\Entity\DemandeFormationProfessionnelle $demandeFormationProfessionnelle = null)
    {
        $this->demandeFormationProfessionnelle = $demandeFormationProfessionnelle;

        return $this;
    }

    /**
     * Get demandeFormationProfessionnelle.
     *
     * @return \AppBundle\Entity\DemandeFormationProfessionnelle
     */
    public function getDemandeFormationProfessionnelle()
    {
        return $this->demandeFormationProfessionnelle;
    }

    /**
     * Add technique.
     *
     * @param \AppBundle\Entity\Technique $techniques
     *
     * @return CrepMindef01
     */
    public function addTechnique(Technique $techniques)
    {
        $this->techniques[] = $techniques;
        $techniques->setCrepMindef01($this);

        return $this;
    }

    /**
     * Remove technique.
     *
     * @param \AppBundle\Entity\Technique $technique
     */
    public function removeTechnique(Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
        $techniques->setCrepMindef01(null);
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
     * Add autreDomaine.
     *
     * @param \AppBundle\Entity\AutreDomaine $autreDomaine
     *
     * @return CrepMindef01
     */
    public function addAutresDomaine(AutreDomaine $autreDomaine)
    {
        $this->autresDomaines[] = $autreDomaine;
        $autreDomaine->setCrepMindef01($this);

        return $this;
    }

    /**
     * Remove autreDomaine.
     *
     * @param \AppBundle\Entity\AutreDomaine $autresDomaine
     */
    public function removeAutresDomaine(AutreDomaine $autresDomaine)
    {
        $this->autresDomaines->removeElement($autresDomaine);
        $autresDomaine->setCrepMindef01(null);
    }

    /**
     * Get $autresDomaines.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresDomaines()
    {
        return $this->autresDomaines;
    }

    /**
     * @Assert\Callback
     */
    public function validateCrepMindef01(ExecutionContextInterface $context)
    {
        /*  *****   VALIDATION: nbAgentsEncadresA   ***** */
        if (null !== $this->nbAgentsEncadresA && !preg_match('/^[0-9][0-9]*$/', $this->nbAgentsEncadresA)) {
            $context->buildViolation('Veuillez saisir un nombre')
            ->atPath('nbAgentsEncadresA')
            ->addViolation();
        }

        /*  *****   VALIDATION: nbAgentsEncadresB   ***** */
        if (null !== $this->nbAgentsEncadresB && !preg_match('/^[0-9][0-9]*$/', $this->nbAgentsEncadresB)) {
            $context->buildViolation('Veuillez saisir un nombre')
            ->atPath('nbAgentsEncadresB')
            ->addViolation();
        }

        /*  *****   VALIDATION: nbAgentsEncadresC   ***** */
        if (null !== $this->nbAgentsEncadresC && !preg_match('/^[0-9][0-9]*$/', $this->nbAgentsEncadresC)) {
            $context->buildViolation('Veuillez saisir un nombre')
            ->atPath('nbAgentsEncadresC')
            ->addViolation();
        }

        /*  *****   VALIDATION: ObjectifFutur   ***** */
        /* @var $objectifFutur ObjectifFutur */
        // 4 objectifs futurs au maximum
        $compteurObjectifsFuturs = 0;
        foreach ($this->objectifsFuturs as $objectifFutur) {
            ++$compteurObjectifsFuturs;

            // Ce modèle se limite à 4 objectifs
            if ($compteurObjectifsFuturs > 4) {
                $this->removeObjectifsFutur($objectifFutur);
                continue;
            }
        }

        /*  *****   VALIDATION: autresActivites   ***** */
        if (null !== $this->resultatAutresActivites && null === $this->autresActivites) {
            $context->buildViolation('Champ obligatoire')
            ->atPath('autresActivites')
            ->addViolation();
        }
    }

    //Fonction qui définit la règle de nommage du CREP pdf pour le ministère des Finances
    public function getPdfFileName()
    {
        $anneeEvaluation = $this->agent->getCampagnePnc()->getAnneeEvaluee();

        $filename = $this->matriculeAlliance.'_'.strtoupper(Converter::convertStringToProgressio($this->nomUsage)).'_CREP'.$anneeEvaluation.'.pdf';

        return $filename;
    }

    public function confidentialisationChampsShd()
    {
        $this->setfichePoseAJour(null);
        $this->setPointsActualisesFichePoste(null);

        $this->getObjectifsEvalues()->clear();

        $this->setAutresActivites(null);
        $this->setResultatAutresActivites(null);

        $this->setContexteObjectifsAnneeEnCours(null);

        $this->getObjectifsFuturs()->clear();

        /* @var $transverse CrepMindef01CompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }

        if ($this->getAutresDomaines()) {
            $this->getAutresDomaines()->clear();
        }

        if ($this->getTechniques()) {
            $this->getTechniques()->clear();
        }

        $this->setNbAgentsEncadresA(null);
        $this->setNbAgentsEncadresB(null);
        $this->setNbAgentsEncadresC(null);

        /* @var $competenceManageriale CrepMindef01CompetenceManageriale */
        foreach ($this->getCompetencesManageriales() as $competenceManageriale) {
            $competenceManageriale->setNiveauAcquis(6);
        }

        $this->getEmplois()->clear();

        $this->setSouhaitEvolutionProfessionnelle(null);

        $this->getMobiliteFonctionnelle()->setChoix(null);
        $this->getMobiliteFonctionnelle()->setFamilleProfessionnelle(null);
        $this->getMobiliteFonctionnelle()->setAnneeDepart(null);

        $this->getMobiliteGeographique()->setAnneeDepart(null);
        $this->getMobiliteGeographique()->setChoix(null);

        $this->setMobiliteOrganisme1(null);
        $this->setMobiliteOrganisme2(null);
        $this->setMobiliteOrganisme3(null);
        $this->setMobiliteOrganisme4(null);

        $this->setMobilitePoste1(null);
        $this->setMobilitePoste2(null);
        $this->setMobilitePoste3(null);
        $this->setMobilitePoste4(null);

        $this->setMobiliteZoneGeo1(null);
        $this->setMobiliteZoneGeo2(null);
        $this->setMobiliteZoneGeo3(null);
        $this->setMobiliteZoneGeo4(null);

        $this->getMotivationsMobilite()->setProjetProfessionnel(null);
        $this->getMotivationsMobilite()->setReorganisation(null);
        $this->getMotivationsMobilite()->setRapprochementFamilial(null);
        $this->getMotivationsMobilite()->setAutre(null);
        //         $this->getMotivationsMobilite()->setChoix(null);

        $this->setSouhaitEntretienCarriere(null);

        $this->getDemandeFormationProfessionnelle()->setTypeFormation(null);
        $this->getDemandeFormationProfessionnelle()->setChoix(null);

        $this->getFormationsSuivies()->clear();

        $this->getFormationsAVenir()->clear();

        $this->getFormationsDemandeesAdministration()->clear();

        $this->getFormationsReglementaires()->clear();

        $this->getFormationsDemandeesAgent()->clear();

        $this->setCapitalDif(null);
        $this->setCapitalDifMobilisable(null);
        $this->setCapitalDifEstimation(null);

        $this->setEvaluationGlobale(null);

        $this->setAptitudesExercerFonctionsSupperieures(null);

        $this->setAppreciationLitteraleShd(null);

        $this->setDateVisaShd(null);
        $this->setShdSignataire(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setObservationsAgentObjectifsPasses(null);

        $this->setObservationsVisaAgent(null);

//         $this->setDateVisaAgent(null);
//         $this->setDateRefusVisa(null);
    }

    public function confidentialisationChampsAh()
    {
        $this->setObservationsAh(null);
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
    }

    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this->setNomNaissanceShd($shd->getNomNaissance())
            ->setNomUsageShd($shd->getNom())
            ->setPrenomShd($shd->getPrenom())
            ->setCorpsShd($shd->getCorps())
            ->setGradeShd($shd->getGrade())
            ->setPosteOccupeShd($shd->getPosteOccupe())
            ->setCategorieShd($shd->getCategorieAgent());
        } else {
            $this->setNomNaissanceShd(null)
            ->setNomUsageShd(null)
            ->setPrenomShd(null)
            ->setCorpsShd(null)
            ->setGradeShd(null)
            ->setPosteOccupeShd(null)
            ->setCategorieShd(null);
        }
    }
}
