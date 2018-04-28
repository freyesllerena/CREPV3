<?php

namespace AppBundle\Entity\Crep\CrepMindef;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Emploi;
use AppBundle\Entity\ObjectifEvalue;
use AppBundle\Entity\FormationSuivie;
use AppBundle\Entity\MotivationsMobilite;
use AppBundle\Entity\MobiliteFonctionnelle;
use AppBundle\Entity\MobiliteGeographique;
use AppBundle\Entity\MobiliteExterne;

/**
 * CrepMindef.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMindefRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CrepMindef extends Crep
{
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

    /**
     * @var string @ORM\Column(type="string", nullable=true)
     */
    protected $matriculeAlliance;

    /**
     * @var string @ORM\Column(type="string")
     *
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomNaissance;

    /**
     * @var string @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
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
     * @Assert\NotBlank(message = "Date de naissance obligatoire")
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $gradeEmploi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntreeGradeEmploi;

    /**
     * @ORM\Column(type="string")
     */
    protected $etablissement;

    /**
     * @ORM\Column(type="string")
     */
    protected $departement;

    /**
     * @ORM\Column(type="string")
     */
    protected $codePosteAlliance;

    /**
     * @ORM\Column(type="string")
     */
    protected $codePosteCredo;

    /**
     * @var string @ORM\Column(type="string")
     *
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
     * @Assert\NotBlank(message = "Nom usuel obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $nomUsageShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Prénom obligatoire")
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
    protected $etablissementShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $affectationAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $affectationShd;

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
     * @var string
     *
     * @ORM\Column(type="text", name="cadre_mise_en_oeuvre_obj")
     */
    protected $cadreMiseEnOeuvreObjectifs;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $fichePoseAJour;

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
     * @ORM\Column(type="text")
     */
    protected $autresFonctionsManageriales;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="ctx_obj_annee_en_cours")
     */
    protected $contexteObjectifsAnneeEnCours;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_objectifs_futurs")
     */
    protected $observationsAgentObjectifsFuturs;

    /**
     * @var bool
     *
     * @ORM\Column(name="souhait_ent_carriere_mindef", type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_projet_pro")
     */
    protected $observationsAgentProjetProfessionnel;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_shd_projet_pro")
     */
    protected $observationsShdProjetProfessionnel;

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
     * @ORM\OneToMany(targetEntity="CrepMindefCompetenceManageriale", mappedBy="crepMindef", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepMindefCompetenceTransverse", mappedBy="crepMindef", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransverses;

    public static $echelleObjectifEvalue = [
                        'Dépassé' => 0,
                        'Atteint' => 1,
                        'Partiellement Atteint' => 2,
                        'Non atteint' => 3,
                        'Devenu non pertinent' => 4,
                    ];

    public function __construct()
    {
        parent::init();
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);
        // Ajouter 3 emplois
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());
        $this->addEmplois(new Emploi());

        $transverses = $em
        ->getRepository('AppBundle:CompetenceTransverse')
        ->findByModeleCrep(Util::getClassName($this));

        $manageriales = $em
        ->getRepository('AppBundle:competenceManageriale')
        ->findByModeleCrep(Util::getClassName($this));

        // Reprise des données de l'année 2016 pour l'année 2017
        if (2017 == $agent->getCampagnePnc()->getAnneeEvaluee()) {
            // Récupération des objectifs futurs 2016
            $objectifsFuturs2016 = $em
            ->getRepository('AppBundle:RepriseMINDEF2016\ObjectifFutur2016')
            ->findByEmail($agent->getEmail());

            // Récupération des formations à venir 2016
            $formationsAVenir2016 = $em
            ->getRepository('AppBundle:RepriseMINDEF2016\FormationAVenir2016')
            ->findByEmail($agent->getEmail());

            // Récupération des formations demandées administration 2016
            $formationsDemandeesAdministration2016 = $em
            ->getRepository('AppBundle:RepriseMINDEF2016\FormationDemandeeAdministration2016')
            ->findByEmail($agent->getEmail());

            // Récupération des formations réglementaires 2016
            $formationsReglementaires2016 = $em
            ->getRepository('AppBundle:RepriseMINDEF2016\FormationReglementaire2016')
            ->findByEmail($agent->getEmail());

            // Récupération des formations demandées par l'agent en 2016
            $formationsDemandeesAgent2016 = $em
            ->getRepository('AppBundle:RepriseMINDEF2016\FormationDemandeeAgent2016')
            ->findByEmail($agent->getEmail());

            /* @var $objectif ObjectifFutur2016 */
            foreach ($objectifsFuturs2016 as $objectif) {
                $objectif2017 = new ObjectifEvalue();
                $objectif2017->setLibelle($objectif->getLibelle())
                            ->setResultatObtenu($this::$echelleObjectifEvalue['Atteint']);

                $this->addObjectifsEvalue($objectif2017);
            }

            /* @var $formation FormationAVenir */
            foreach ($formationsAVenir2016 as $formation) {
                $formationSuivie = new FormationSuivie();
                $formationSuivie->setLibelle($formation->getLibelle());
                $this->addFormationsSuivy($formationSuivie);
            }

            /* @var $formation FormationDemandeeAdministration */
            foreach ($formationsDemandeesAdministration2016 as $formation) {
                $formationSuivie = new FormationSuivie();
                $formationSuivie->setLibelle($formation->getLibelle());
                $this->addFormationsSuivy($formationSuivie);
            }

            /* @var $formation FormationReglementaire */
            foreach ($formationsReglementaires2016 as $formation) {
                $formationSuivie = new FormationSuivie();
                $formationSuivie->setLibelle($formation->getLibelle());
                $this->addFormationsSuivy($formationSuivie);
            }

            /* @var $formation FormationDemandeeAgent */
            foreach ($formationsDemandeesAgent2016 as $formation) {
                $formationSuivie = new FormationSuivie();
                $formationSuivie->setLibelle($formation->getLibelle());
                $this->addFormationsSuivy($formationSuivie);
            }
        }
        // Fin de la partie reprise des données de l'année 2016 pour l'année 2017

        foreach ($transverses as $transverse) {
            $competenceTransverse = new CrepMindefCompetenceTransverse();
            $competenceTransverse->setCompetenceTransverse($transverse);
            $this->addCompetencesTransverse($competenceTransverse);
        }

        foreach ($manageriales as $manageriale) {
            $competenceManageriale = new CrepMindefCompetenceManageriale();
            $competenceManageriale->setCompetenceManageriale($manageriale);
            $this->addCompetencesManageriale($competenceManageriale);
        }

        $motivationsMobilite = new MotivationsMobilite();
        $this->setMotivationsMobilite($motivationsMobilite);

//     	$demandeFormationProfessionnelle = new DemandeFormationProfessionnelle();
//     	$this->setDemandeFormationProfessionnelle($demandeFormationProfessionnelle);

        ///  FIN Valable pour XP ///

        /* @var $crep CrepMindef01 */

        // Bloc identification de l'agent évalué
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
        $this->setGradeEmploi($agent->getGradeEmploi());
        $this->setDateEntreeGradeEmploi($agent->getDateEntreeGradeEmploi());
        $this->setEtablissement($agent->getEtablissement());
        $this->setDepartement($agent->getDepartement());
        $this->setAffectationAgent($agent->getAffectation());
        $this->setPosteOccupeAgent($agent->getPosteOccupe());
        $this->setDateEntreePosteOccupeAgent($agent->getDateEntreePosteOccupe());
        $this->setCodePosteAlliance($agent->getCodeSirh1());
        $this->setCodePosteCredo($agent->getCodeSirh2());

        // Bloc identification de l'évaluateur
        $this->setNomNaissanceShd($agent->getShd()->getNomNaissance());
        $this->setNomUsageShd($agent->getShd()->getNom());
        $this->setPrenomShd($agent->getShd()->getPrenom());
        $this->setCorpsShd($agent->getShd()->getCorps());
        $this->setGradeShd($agent->getShd()->getGrade());
        $this->setEtablissementShd($agent->getShd()->getEtablissement());
        $this->setAffectationShd($agent->getShd()->getAffectation());
        $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());

        $this->setCapitalDif($agent->getCapitalDif());
        $this->setCapitalDifMobilisable($agent->getCapitalDifMobilisable());

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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * Set gradeEmploi.
     *
     * @param string $gradeEmploi
     *
     * @return CrepMindef
     */
    public function setGradeEmploi($gradeEmploi)
    {
        $this->gradeEmploi = $gradeEmploi;

        return $this;
    }

    /**
     * Get gradeEmploi.
     *
     * @return string
     */
    public function getGradeEmploi()
    {
        return $this->gradeEmploi;
    }

    /**
     * Set dateEntreeGradeEmploi.
     *
     * @param \DateTime $dateEntreeGradeEmploi
     *
     * @return CrepMindef
     */
    public function setDateEntreeGradeEmploi($dateEntreeGradeEmploi)
    {
        $this->dateEntreeGradeEmploi = $dateEntreeGradeEmploi;

        return $this;
    }

    /**
     * Get dateEntreeGradeEmploi.
     *
     * @return \DateTime
     */
    public function getDateEntreeGradeEmploi()
    {
        return $this->dateEntreeGradeEmploi;
    }

    /**
     * Set etablissement.
     *
     * @param string $etablissement
     *
     * @return CrepMindef
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement.
     *
     * @return string
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set departement.
     *
     * @param string $departement
     *
     * @return CrepMindef
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement.
     *
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set codePosteAlliance.
     *
     * @param string $codePosteAlliance
     *
     * @return CrepMindef
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
     * Set codePosteCredo.
     *
     * @param string $codePosteCredo
     *
     * @return CrepMindef
     */
    public function setCodePosteCredo($codePosteCredo)
    {
        $this->codePosteCredo = $codePosteCredo;

        return $this;
    }

    /**
     * Get codePosteCredo.
     *
     * @return string
     */
    public function getCodePosteCredo()
    {
        return $this->codePosteCredo;
    }

    /**
     * Set nomNaissanceShd.
     *
     * @param string $nomNaissanceShd
     *
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * Set etablissementShd.
     *
     * @param string $etablissementShd
     *
     * @return CrepMindef
     */
    public function setEtablissementShd($etablissementShd)
    {
        $this->etablissementShd = $etablissementShd;

        return $this;
    }

    /**
     * Get etablissementShd.
     *
     * @return string
     */
    public function getEtablissementShd()
    {
        return $this->etablissementShd;
    }

    /**
     * Set affectationAgent.
     *
     * @param string $affectationAgent
     *
     * @return CrepMindef
     */
    public function setAffectationAgent($affectationAgent)
    {
        $this->affectationAgent = $affectationAgent;

        return $this;
    }

    /**
     * Get affectationAgent.
     *
     * @return string
     */
    public function getAffectationAgent()
    {
        return $this->affectationAgent;
    }

    /**
     * Set affectationShd.
     *
     * @param string $affectationShd
     *
     * @return CrepMindef
     */
    public function setAffectationShd($affectationShd)
    {
        $this->affectationShd = $affectationShd;

        return $this;
    }

    /**
     * Get affectationShd.
     *
     * @return string
     */
    public function getAffectationShd()
    {
        return $this->affectationShd;
    }

    /**
     * Set posteOccupeAgent.
     *
     * @param string $posteOccupeAgent
     *
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * Set cadreMiseEnOeuvreObjectifs.
     *
     * @param string $cadreMiseEnOeuvreObjectifs
     *
     * @return CrepMindef
     */
    public function setCadreMiseEnOeuvreObjectifs($cadreMiseEnOeuvreObjectifs)
    {
        $this->cadreMiseEnOeuvreObjectifs = $cadreMiseEnOeuvreObjectifs;

        return $this;
    }

    /**
     * Get cadreMiseEnOeuvreObjectifs.
     *
     * @return string
     */
    public function getCadreMiseEnOeuvreObjectifs()
    {
        return $this->cadreMiseEnOeuvreObjectifs;
    }

    /**
     * Set fichePoseAJour.
     *
     * @param bool $fichePoseAJour
     *
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * Set autresFonctionsManageriales.
     *
     * @param string $autresFonctionsManageriales
     *
     * @return CrepMindef
     */
    public function setAutresFonctionsManageriales($autresFonctionsManageriales)
    {
        $this->autresFonctionsManageriales = $autresFonctionsManageriales;

        return $this;
    }

    /**
     * Get autresFonctionsManageriales.
     *
     * @return string
     */
    public function getAutresFonctionsManageriales()
    {
        return $this->autresFonctionsManageriales;
    }

    /**
     * Set contexteObjectifsAnneeEnCours.
     *
     * @param string $contexteObjectifsAnneeEnCours
     *
     * @return CrepMindef
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
     * Set observationsAgentObjectifsFuturs.
     *
     * @param string $observationsAgentObjectifsFuturs
     *
     * @return CrepMindef
     */
    public function setObservationsAgentObjectifsFuturs($observationsAgentObjectifsFuturs)
    {
        $this->observationsAgentObjectifsFuturs = $observationsAgentObjectifsFuturs;

        return $this;
    }

    /**
     * Get observationsAgentObjectifsFuturs.
     *
     * @return string
     */
    public function getObservationsAgentObjectifsFuturs()
    {
        return $this->observationsAgentObjectifsFuturs;
    }

    /**
     * Set souhaitEntretienCarriere.
     *
     * @param bool $souhaitEntretienCarriere
     *
     * @return CrepMindef
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
     * Set observationsAgentProjetProfessionnel.
     *
     * @param string $observationsAgentProjetProfessionnel
     *
     * @return CrepMindef
     */
    public function setObservationsAgentProjetProfessionnel($observationsAgentProjetProfessionnel)
    {
        $this->observationsAgentProjetProfessionnel = $observationsAgentProjetProfessionnel;

        return $this;
    }

    /**
     * Get observationsAgentProjetProfessionnel.
     *
     * @return string
     */
    public function getObservationsAgentProjetProfessionnel()
    {
        return $this->observationsAgentProjetProfessionnel;
    }

    /**
     * Set observationsShdProjetProfessionnel.
     *
     * @param string $observationsShdProjetProfessionnel
     *
     * @return CrepMindef
     */
    public function setObservationsShdProjetProfessionnel($observationsShdProjetProfessionnel)
    {
        $this->observationsShdProjetProfessionnel = $observationsShdProjetProfessionnel;

        return $this;
    }

    /**
     * Get observationsShdProjetProfessionnel.
     *
     * @return string
     */
    public function getObservationsShdProjetProfessionnel()
    {
        return $this->observationsShdProjetProfessionnel;
    }

    /**
     * Set capitalDif.
     *
     * @param int $capitalDif
     *
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @return CrepMindef
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
     * @param CrepMindefCompetenceManageriale $competencesManageriale
     *
     * @return CrepMindef
     */
    public function addCompetencesManageriale(CrepMindefCompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales[] = $competencesManageriale;
        $competencesManageriale->setCrepMindef($this);

        return $this;
    }

    /**
     * Remove competencesManageriale.
     *
     * @param CrepMindefCompetenceManageriale $competencesManageriale
     */
    public function removeCompetencesManageriale(CrepMindefCompetenceManageriale $competencesManageriale)
    {
        $this->competencesManageriales->removeElement($competencesManageriale);
        $competencesManageriale->setCrepMindef(null);
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
     * @param CrepMindefCompetenceTransverse $competencesTransverse
     *
     * @return CrepMindef
     */
    public function addCompetencesTransverse(CrepMindefCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepMindef($this);

        return $this;
    }

    /**
     * Remove competencesTransverse.
     *
     * @param CrepMindefCompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(CrepMindefCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepMindef(null);
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
     * @Assert\Callback
     */
    public function validateCrepMindef(ExecutionContextInterface $context)
    {
        /*  *****   VALIDATION: objectifsEvalues   ***** */

        /* @var $objectif ObjectifEvalue */

        // 4 objectifs évalués au maximum
        $compteurObjectifsEvalues = 0;
        foreach ($this->objectifsEvalues as $objectif) {
            ++$compteurObjectifsEvalues;

            // Ce modèle se limite à 4 objectifs
            if ($compteurObjectifsEvalues > 4) {
                $this->removeObjectifsEvalue($objectif);
                continue;
            }

            //Si l'intitulé de l'objectif et le résultat sont null, on ne les insère pas dans la base
            if (!$objectif->getLibelle() && !$objectif->getResultat()) {
                $this->removeObjectifsEvalue($objectif);
            }
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

            if (!$objectifFutur->getLibelle() && !$objectifFutur->getResultat() && !$objectifFutur->getEcheance() && !$objectifFutur->getObservationsEventuelles()) {
                //Si l'intitulé de l'objectif et le résultat sont null, on ne les insère pas dans la base
                $this->removeObjectifsFutur($objectifFutur);
            }
        }

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

        /*  *****   VALIDATION: competencesPostes   ***** */
        /* @var competencePoste CompetencePoste */
        foreach ($this->competencesPostes as $competencePoste) {
            if (!$competencePoste->getLibelle() && null === $competencePoste->getNiveauAcquis() && null === $competencePoste->getNiveauRequis()) {
                $this->removeCompetencesPoste($competencePoste);
            }
        }

        /*  *****   VALIDATION: ObjectifFutur   ***** */
        /* @var $competenceDeclaree CompetenceDeclaree  */
        foreach ($this->competencesDeclarees as $competenceDeclaree) {
            if (!$competenceDeclaree->getLibelle() && null === $competenceDeclaree->getNiveauAcquis()) {
                //Si c'est une ligne vide (libellé et niveau = null), on ne l'insère pas dans la base
                $this->removeCompetencesDeclaree($competenceDeclaree);
            }
        }

        /*  *****   VALIDATION: FormationSuivie   ***** */
        /* @var $formationSuivie FormationSuivie  */
        foreach ($this->formationsSuivies as $formationSuivie) {
            if (!$formationSuivie->getLibelle()) {
                $this->removeFormationsSuivy($formationSuivie);
            }
        }

        /*  *****   VALIDATION: FormationAVenir   ***** */
        /* @var $formationAvenir FormationAVenir  */
        foreach ($this->formationsAVenir as $formationAvenir) {
            if (!$formationAvenir->getLibelle()) {
                $this->removeFormationsAVenir($formationAvenir);
            }
        }

        /*  *****   VALIDATION: FormationDemandeeAdministration   ***** */
        /* @var $formationDemandeeAdministration FormationDemandeeAdministration  */
        foreach ($this->formationsDemandeesAdministration as $formationDemandeeAdministration) {
            if (!$formationDemandeeAdministration->getLibelle()) {
                $this->removeFormationsDemandeesAdministration($formationDemandeeAdministration);
            }
        }

        /*  *****   VALIDATION: FormationDemandeeAgent   ***** */
        /* @var $formationDemandeeAgent FormationDemandeeAgent  */
        foreach ($this->formationsDemandeesAgent as $formationDemandeeAgent) {
            if (!$formationDemandeeAgent->getLibelle()) {
                $this->removeFormationsDemandeesAgent($formationDemandeeAgent);
            }
        }

        /*  *****   VALIDATION: FormationDemandeeEmployeur   ***** */
        /* @var $formationDemandeeEmployeur FormationDemandeeEmployeur  */
        foreach ($this->formationsDemandeesEmployeur as $formationDemandeeEmployeur) {
            if (!$formationDemandeeEmployeur->getLibelle()) {
                $this->removeFormationsDemandeesEmployeur($formationDemandeeEmployeur);
            }
        }
    }

    public function confidentialisationChampsShd()
    {
        $this->setCadreMiseEnOeuvreObjectifs(null);
        $this->setFichePoseAJour(null);
        $this->objectifsEvalues->clear();
        $this->setAutresActivites(null);
        $this->setResultatAutresActivites(null);
        $this->setContexteObjectifsAnneeEnCours(null);
        $this->objectifsFuturs->clear();

        $this->competencesPostes->clear();
        /* @var $transverse  CrepMindefCompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }
        $this->setNbAgentsEncadresA(null);
        $this->setNbAgentsEncadresB(null);
        $this->setNbAgentsEncadresC(null);
        $this->setAutresFonctionsManageriales(null);

        /* @var $manageriale  CrepMindefCompetenceManageriale */
        foreach ($this->getCompetencesManageriales() as $manageriale) {
            $manageriale->setNiveauAcquis(6);
        }
        $this->getEmplois()->clear();
        $this->getCompetencesDeclarees()->clear();

        $this->getMotivationsMobilite()->setChoix(null);
        $this->getMotivationsMobilite()->setEcheance(null);

        $this->getMobiliteFonctionnelle()->setChoix(null);
        $this->getMobiliteFonctionnelle()->setFamilleProfessionnelle(null);
        $this->getMobiliteFonctionnelle()->setAnneeDepart(null);
        $this->getMobiliteFonctionnelle()->setPriorite(null);
        $this->getMobiliteFonctionnelle()->setFiliere(null);

        $this->getMobiliteGeographique()->setAnneeDepart(null);
        $this->getMobiliteGeographique()->setChoix(null);
        $this->getMobiliteGeographique()->setPriorite(null);
        $this->getMobiliteGeographique()->setRegion(null);
        $this->getMobiliteGeographique()->setDepartement(null);
        $this->getMobiliteGeographique()->setVille(null);

        $this->getMobiliteExterne()->setChoix(null);
        $this->getMobiliteExterne()->setMinistere(null);
        $this->getMobiliteExterne()->setHorsMinistere(null);
        $this->getMobiliteExterne()->setPriorite(null);
        $this->getMobiliteExterne()->setAnneeDepart(null);

        $this->setSouhaitEntretienCarriere(null);

        $this->setObservationsShdProjetProfessionnel(null);
        $this->getFormationsSuivies()->clear();
        $this->getFormationsAVenir()->clear();
        $this->getFormationsDemandeesAdministration()->clear();
        $this->getFormationsDemandeesAgent()->clear();
        $this->getFormationsDemandeesEmployeur()->clear();
        $this->setCapitalDif(null);
        $this->setCapitalDifMobilisable(null);
        $this->setEvaluationGlobale(null);
        $this->setAptitudesExercerFonctionsSupperieures(null);
        $this->setAppreciationLitteraleShd(null);
        $this->setDateEntretien(null);
        $this->setDateVisaShd(null);
        $this->setShdSignataire(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setObservationsAgentObjectifsFuturs(null);
        $this->setObservationsAgentProjetProfessionnel(null);

        $this->setDateVisaAgent(null);
        $this->setDateRefusVisa(null);
    }

    public function confidentialisationChampsAh()
    {
        $this->setObservationsAh(null);

        $this->setDateVisaAh(null);
        $this->setAhSignataire(null);
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
            ->setEtablissementShd($shd->getEtablissement())
            ->setAffectationShd($shd->getAffectation())
            ->setPosteOccupeShd($shd->getPosteOccupe());
        } else {
            $this->setNomNaissanceShd(null)
            ->setNomUsageShd(null)
            ->setPrenomShd(null)
            ->setCorpsShd(null)
            ->setGradeShd(null)
            ->setEtablissementShd(null)
            ->setAffectationShd(null)
            ->setPosteOccupeShd(null);
        }
    }
}
