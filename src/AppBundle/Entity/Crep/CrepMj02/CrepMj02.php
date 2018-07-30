<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 14/06/2018
 * Time: 13:50
 */

namespace AppBundle\Entity\Crep\CrepMj02;

use AppBundle\Entity\FormationSuivie;
use AppBundle\Entity\ObjectifFutur;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;
use AppBundle\Util\Converter;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Class CrepMj02
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository")
 */
class CrepMj02 extends Crep
{
    public static $echelleObjectifEvalue = [
        'Atteint' => 0,
        'Partiellement' => 1,
        'Non atteint' => 2,
        'Devenu sans objet' => 3,
    ];

    public static $globalObjectifEvalue = [
        'Atteints' => 0,
        'Partiellement' => 1,
        'Non atteints' => 2,
        'Devenus sans objet' => 3,
    ];

    public static $niveauCompetence = [
        'Excellent' => 0,
        'Très bon' => 1,
        'Bon' => 2,
        'Convenable' => 3,
        'Insuffisant' => 4,
        'Très insuffisant' => 5,
    ];

    public static $thematiquesFormationsCrepMj02 = [
        'T1 : adaptation immédiate au poste de travail (missions actuelles imparties à l’agent)' => 'T1 : adaptation immédiate au poste de travail (missions actuelles imparties à l’agent)',
        'T2 : adaptation à l’évolution prévisible des métiers (compétences acquises)' => 'T2 : adaptation à l’évolution prévisible des métiers (compétences acquises)',
        'T3 : développement des compétences ou acquisition de nouvelles compétences (projet professionnel)' => 'T3 : développement des compétences ou acquisition de nouvelles compétences (projet professionnel)',
    ];

    public static $typesAbsenceEntretienCrepMj02 = [
        'Non activité (durée de l\'absence)' => 0,
        'Congés' => 1,
        'Autres' => 2,
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
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom de famille doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom de famille ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissance;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom marital doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom marital ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomMarital;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Champ obligatoire")
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
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA")
     */
    protected $dateEntreePosteOccupe;

    /**
     * @var bool
     *
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $activiteEncadrement;

    /**
     * @var bool
     *
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $titulaire;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $direction;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $departement;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $service;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $directionShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $departementShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $serviceShd;

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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissanceShd;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom marital doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom marital ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomMaritalShd;

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
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupeShd;

    /**
     * Motif d'abcense à l'entretien de l'agent
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifAbsenceEntretien;

    /**
     * Motif d'abcense à l'entretien du N+1
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifAbsenceEntretienShd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA")
     */
    protected $dateEntretien;

    /**
     * @var string @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsageShd;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMj02\CrepMj02CompetenceJudiciaire", mappedBy="crep",
     *     cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesJudiciaires;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMj02\CrepMj02CompetenceEncadrement", mappedBy="crep",
     *     cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesEncadrements;

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
     * @var string
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
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $acquisExperiencePro;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $vae;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Le champ ne doit pas faire plus de {{ limit }} caractères")
     */
    protected $commentaireVae;

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
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMj02\CrepMj02AppreciationGenerale", mappedBy="crep",
     *     cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $appreciationsGenerales;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, length=4096)
     */
    protected $contexteResultats;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $appreciationLitteraleShd;

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
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $formationsEffectuees;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMj02\CrepMj02FormationAnneeEcoulee",
     *     mappedBy="crep",
     *     orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsAnneeEcoulee;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepMj02\CrepMj02FormationAnneeAvenir",
     *     mappedBy="crep",
     *     orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsAnneeAvenir;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $typeAbsenceEntretien;


    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);
        $defaultNomAgent = ($agent->getNom()) ? $agent->getNom() : $agent->getNomNaissance();
        $this->setNomNaissance($defaultNomAgent);
        $this->setNomMarital($agent->getNomMarital());
        $this->setPrenom($agent->getPrenom());
        $this->setTitulaire($agent->isTitulaire());
        $this->setPosteOccupe($agent->getPosteOccupe());
        $this->setDateEntreePosteOccupe($agent->getDateEntreePosteOccupe());
        $this->setCorps($agent->getCorps());
        $this->setGrade($agent->getGrade());


        if ($agent->getShd()) {
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setNomNaissanceShd($agent->getShd()->getNomNaissance());
            $this->setNomMarital($agent->getShd()->getNomMarital());
            $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
//            $this->setDateEntreePosteOccupeShd($agent->getShd()->getDateEntreePosteOccupe());
        }

        // Initialisatiuon des compétences liées à la protection judiciaire de la jeuness
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Capacité à s’adapter aux exigences du poste et au contexte professionnel');
        $this->addCompetencesJudiciaire($competenceJudiciaire);
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Participation à la vie institutionnelle et implication dans les projets du service');
        $this->addCompetencesJudiciaire($competenceJudiciaire);
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Autonomie et sens de l’organisation');
        $this->addCompetencesJudiciaire($competenceJudiciaire);
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Capacité à travailler en équipe et capacité à coopérer avec les partenaires professionnels');
        $this->addCompetencesJudiciaire($competenceJudiciaire);
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Contribution à l’action éducative');
        $this->addCompetencesJudiciaire($competenceJudiciaire);
        $competenceJudiciaire = new CrepMj02CompetenceJudiciaire();
        $competenceJudiciaire->setLibelle('Autre élément d’appréciation, le cas échéant (exemples : délégation spécifique, assistant ou conseiller de prévention en matière de santé, sécurité au travail, tuteur…)');
        $this->addCompetencesJudiciaire($competenceJudiciaire);

        // Initialisatiuon des compétences liées à l'encadrement
        $competenceEncadrement = new CrepMj02CompetenceEncadrement();
        $competenceEncadrement->setLibelle('Pilotage de la politique de la direction de la protection judiciaire de la jeunesse ou suivi de son application dans les services et établissements');
        $this->addCompetencesEncadrement($competenceEncadrement);
        $competenceEncadrement = new CrepMj02CompetenceEncadrement();
        $competenceEncadrement->setLibelle('Contribution à la bonne organisation du service et participation à la politique des ressources humaines');
        $this->addCompetencesEncadrement($competenceEncadrement);
        $competenceEncadrement = new CrepMj02CompetenceEncadrement();
        $competenceEncadrement->setLibelle('Qualités managériales et relationnelles');
        $this->addCompetencesEncadrement($competenceEncadrement);

        // Initialisatiuon d appreciations generales
        $appreciationGenerale = new CrepMj02AppreciationGenerale();
        $appreciationGenerale->setLibelle('Niveau d’appréciation générale');
        $this->addAppreciationsGenerale($appreciationGenerale);
    }

    public function __construct()
    {
        parent::init();
        $this->competencesJudiciaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesEncadrements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appreciationsGenerales = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAnneeEcoulee = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAnneeAvenir = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     * @param $nomUsage
     *
     * @return CrepMj02
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * @return string
     */
    public function getNomNaissance()
    {
        return $this->nomNaissance;
    }

    /**
     * @param $nomNaissance
     *
     * @return $this
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    /**
     * Actualisation de données Shd
     */
    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this
                ->setNomNaissanceShd($shd->getNomNaissance())
//                ->setNomMarital($shd->getNomMarital())
                ->setPrenomShd($shd->getPrenom());
//                ->setPosteOccupeShd($shd->getPosteOccupe());
//                ->setAffectationShd($shd->getAffectation());
        } else {
            $this
                ->setNomNaissanceShd(null)
//                ->setPrenomShd(null)
//                ->setPosteOccupeShd(null)
//                ->setAffectationShd(null)
            ;
        }
    }

    /**
     * Confidentialisation des champs pour la session du SHD
     */
    public function confidentialisationChampsShd()
    {
        $this->getCompetencesJudiciaires()->clear();
        $this->getCompetencesEncadrements()->clear();
        /** @var  ObjectifFutur $objectifFutur */
        foreach ($this->getObjectifsFuturs() as $objectifFutur) {
            $this->removeObjectifsFutur($objectifFutur);
        }
        $this->setMobiliteGeographique(null);
        /** @var CrepMj02AppreciationGenerale $appreciationGenerale */
        foreach ($this->appreciationsGenerales as $appreciationGenerale) {
            $appreciationGenerale->setNiveauAcquis(null);
        }
        $this->setDureeEntretien(null);

        $this->setDateVisaShd(null)
            ->setShdSignataire(null);

        $this->setMotifAbsenceEntretien(null);

        $this->setDirectionShd(null);
        $this->setDepartementShd(null);
        $this->setServiceShd(null);
        $this->setMotifAbsenceEntretien(null);
        $this->setMotifAbsenceEntretienShd(null);
        $this->setDateEntretien(null);
        $this->getObjectifsEvalues()->clear();
        $this->setContexteResultats(null);
        $this->setObservationsShd(null);
        $this->setObservationsAgentNotif(null);
        $this->setObjectifsService(null);
        $this->setAcquisExperiencePro(null);
        $this->setVae(null);
        $this->setCommentaireVae(null);
        $this->setCapacitesDecisions(null);
        $this->setMobiliteGeographique(null);
        $this->setSouhaitEntretienCarriere(null);
        $this->setFormationsEffectuees(null);

        $this->getFormationsAnneeEcoulee()->clear();
        $this->getFormationsAnneeAvenir()->clear();
        $this->getAppreciationsGenerales()->clear();
        $this->setAppreciationLitteraleShd(null);
        $this->setDureeEntretien(null);

    }

    public function confidentialisationChampsAgent()
    {
        $this->setObservationsVisaAgent(null);
        $this->setObservationsAgentNotif(null);

    }

    public function confidentialisationChampsAgentAvantNotification()
    {
        // TODO: Implement confidentialisationChampsAgentAvantNotification() method.
    }

    public function confidentialisationChampsAh()
    {
        // TODO: Implement confidentialisationChampsAh() method.
    }

    /**
     * Set nomMarital.
     *
     * @param string $nomMarital
     *
     * @return $this
     */
    public function setNomMarital($nomMarital)
    {
        $this->nomMarital = $nomMarital;

        return $this;
    }

    /**
     * Get nomMarital.
     *
     * @return string
     */
    public function getNomMarital()
    {
        return $this->nomMarital;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return bool
     */
    public function getTitulaire()
    {
        return $this->titulaire;
    }

    /**
     * @param $titulaire
     * @return $this
     */
    public function setTitulaire($titulaire)
    {
        $this->titulaire = $titulaire;

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
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
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
     * @return \DateTime
     */
    public function getDateEntreePosteOccupe()
    {
        return $this->dateEntreePosteOccupe;
    }

    /**
     * @param $dateEntreePosteOccupe
     * @return $this
     */
    public function setDateEntreePosteOccupe($dateEntreePosteOccupe)
    {
        $this->dateEntreePosteOccupe = Converter::convertDate($dateEntreePosteOccupe);
        return $this;
    }

    /**
     * @return bool
     */
    public function isActiviteEncadrement()
    {
        return $this->activiteEncadrement;
    }

    /**
     * @param bool $activiteEncadrement
     */
    public function setActiviteEncadrement($activiteEncadrement)
    {
        $this->activiteEncadrement = $activiteEncadrement;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param mixed $departement
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresA()
    {
        return $this->nbAgentsEncadresA;
    }

    /**
     * @param int $nbAgentsEncadresA
     */
    public function setNbAgentsEncadresA($nbAgentsEncadresA)
    {
        $this->nbAgentsEncadresA = $nbAgentsEncadresA;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresB()
    {
        return $this->nbAgentsEncadresB;
    }

    /**
     * @param int $nbAgentsEncadresB
     */
    public function setNbAgentsEncadresB($nbAgentsEncadresB)
    {
        $this->nbAgentsEncadresB = $nbAgentsEncadresB;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresC()
    {
        return $this->nbAgentsEncadresC;
    }

    /**
     * @param int $nbAgentsEncadresC
     */
    public function setNbAgentsEncadresC($nbAgentsEncadresC)
    {
        $this->nbAgentsEncadresC = $nbAgentsEncadresC;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadres()
    {
        return $this->nbAgentsEncadres;
    }

    /**
     * @param int $nbAgentsEncadres
     */
    public function setNbAgentsEncadres($nbAgentsEncadres)
    {
        $this->nbAgentsEncadres = $nbAgentsEncadres;
    }

    /**
     * @return mixed
     */
    public function getNomNaissanceShd()
    {
        return $this->nomNaissanceShd;
    }

    /**
     * @param mixed $nomNaissanceShd
     */
    public function setNomNaissanceShd($nomNaissanceShd)
    {
        $this->nomNaissanceShd = $nomNaissanceShd;
    }

    /**
     * @return mixed
     */
    public function getNomMaritalShd()
    {
        return $this->nomMaritalShd;
    }

    /**
     * @param mixed $nomMaritalShd
     */
    public function setNomMaritalShd($nomMaritalShd)
    {
        $this->nomMaritalShd = $nomMaritalShd;
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
    public function getPosteOccupeShd()
    {
        return $this->posteOccupeShd;
    }

    /**
     * @param string $posteOccupeShd
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;
    }

    /**
     * @return mixed
     */
    public function getDirectionShd()
    {
        return $this->directionShd;
    }

    /**
     * @param mixed $directionShd
     */
    public function setDirectionShd($directionShd)
    {
        $this->directionShd = $directionShd;
    }

    /**
     * @return mixed
     */
    public function getDepartementShd()
    {
        return $this->departementShd;
    }

    /**
     * @param mixed $departementShd
     */
    public function setDepartementShd($departementShd)
    {
        $this->departementShd = $departementShd;
    }

    /**
     * @return mixed
     */
    public function getServiceShd()
    {
        return $this->serviceShd;
    }

    /**
     * @param mixed $serviceShd
     */
    public function setServiceShd($serviceShd)
    {
        $this->serviceShd = $serviceShd;
    }

    /**
     * @return mixed
     */
    public function getMotifAbsenceEntretien()
    {
        return $this->motifAbsenceEntretien;
    }

    /**
     * @param mixed $motifAbsenceEntretien
     */
    public function setMotifAbsenceEntretien($motifAbsenceEntretien)
    {
        $this->motifAbsenceEntretien = $motifAbsenceEntretien;
    }

    /**
     * @return mixed
     */
    public function getMotifAbsenceEntretienShd()
    {
        return $this->motifAbsenceEntretienShd;
    }

    /**
     * @param mixed $motifAbsenceEntretienShd
     */
    public function setMotifAbsenceEntretienShd($motifAbsenceEntretienShd)
    {
        $this->motifAbsenceEntretienShd = $motifAbsenceEntretienShd;
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
     * Add competenceJudiciaire
     *
     * @param CrepMj02CompetenceJudiciaire $competenceJudiciaire
     *
     * @return CrepMj02
     */
    public function addCompetencesJudiciaire(CrepMj02CompetenceJudiciaire $competenceJudiciaire)
    {
        $this->competencesJudiciaires[] = $competenceJudiciaire;
        $competenceJudiciaire->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceJudiciaire
     *
     * @param CrepMj02CompetenceJudiciaire $competenceJudiciaire
     */
    public function removeCompetencesJudiciaire(CrepMj02CompetenceJudiciaire $competenceJudiciaire)
    {
        $this->competencesJudiciaires->removeElement($competenceJudiciaire);
        $competenceJudiciaire->setCrep(null);
    }

    /**
     * Get competencesJudiciaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesJudiciaires()
    {
        return $this->competencesJudiciaires;
    }

    /**
     * Add competenceEncadrement
     *
     * @param CrepMj02CompetenceEncadrement $competenceEncadrement
     *
     * @return CrepMj02
     */
    public function addCompetencesEncadrement(CrepMj02CompetenceEncadrement $competenceEncadrement)
    {
        $this->competencesEncadrements[] = $competenceEncadrement;
        $competenceEncadrement->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceEncadrement
     *
     * @param CrepMj02CompetenceEncadrement $competenceEncadrement
     */
    public function removeCompetencesEncadrement(CrepMj02CompetenceEncadrement $competenceEncadrement)
    {
        $this->competencesEncadrements->removeElement($competenceEncadrement);
        $competenceEncadrement->setCrep(null);
    }

    /**
     * Get competencesEncadrements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesEncadrements()
    {
        return $this->competencesEncadrements;
    }

    /**
     * @return string
     */
    public function getObservationsAgentNotif()
    {
        return $this->observationsAgentNotif;
    }

    /**
     * @param $observationsAgentNotif
     * @return $this
     */
    public function setObservationsAgentNotif($observationsAgentNotif)
    {
        $this->observationsAgentNotif = $observationsAgentNotif;

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
     * @return string
     */
    public function getObjectifsService()
    {
        return $this->objectifsService;
    }

    /**
     * @param string $objectifsService
     */
    public function setObjectifsService($objectifsService)
    {
        $this->objectifsService = $objectifsService;
    }

    /**
     * @return string
     */
    public function getAcquisExperiencePro()
    {
        return $this->acquisExperiencePro;
    }

    /**
     * @param string $acquisExperiencePro
     */
    public function setAcquisExperiencePro($acquisExperiencePro)
    {
        $this->acquisExperiencePro = $acquisExperiencePro;
    }

    /**
     * @return bool
     */
    public function isVae()
    {
        return $this->vae;
    }

    /**
     * @param bool $vae
     */
    public function setVae($vae)
    {
        $this->vae = $vae;
    }

    /**
     * @return string
     */
    public function getCommentaireVae()
    {
        return $this->commentaireVae;
    }

    /**
     * @param string $commentaireVae
     */
    public function setCommentaireVae($commentaireVae)
    {
        $this->commentaireVae = $commentaireVae;
    }

    /**
     * @return string
     */
    public function getCapacitesDecisions()
    {
        return $this->capacitesDecisions;
    }

    /**
     * @param string $capacitesDecisions
     */
    public function setCapacitesDecisions($capacitesDecisions)
    {
        $this->capacitesDecisions = $capacitesDecisions;
    }

    /**
     * @return bool
     */
    public function isSouhaitEntretienCarriere()
    {
        return $this->souhaitEntretienCarriere;
    }

    /**
     * @param bool $souhaitEntretienCarriere
     */
    public function setSouhaitEntretienCarriere($souhaitEntretienCarriere)
    {
        $this->souhaitEntretienCarriere = $souhaitEntretienCarriere;
    }

    /**
     * Add appreciationGenerale
     *
     * @param CrepMj02AppreciationGenerale $appreciationGenerale
     *
     * @return CrepMj02
     */
    public function addAppreciationsGenerale(CrepMj02AppreciationGenerale $appreciationGenerale)
    {
        $this->appreciationsGenerales[] = $appreciationGenerale;
        $appreciationGenerale->setCrep($this);

        return $this;
    }

    /**
     * Remove appreciationGenerale
     *
     * @param CrepMj02AppreciationGenerale $appreciationGenerale
     */
    public function removeAppreciationsGenerale(CrepMj02AppreciationGenerale $appreciationGenerale)
    {
        $this->appreciationsGenerales->removeElement($appreciationGenerale);
        $appreciationGenerale->setCrep(null);
    }

    /**
     * Get appreciationsGenerales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppreciationsGenerales()
    {
        return $this->appreciationsGenerales;
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
     * @return string
     */
    public function getAppreciationLitteraleShd()
    {
        return $this->appreciationLitteraleShd;
    }

    /**
     * @param string $appreciationLitteraleShd
     */
    public function setAppreciationLitteraleShd($appreciationLitteraleShd)
    {
        $this->appreciationLitteraleShd = $appreciationLitteraleShd;
    }

    /**
     * @return string
     */
    public function getDureeEntretien()
    {
        return $this->dureeEntretien;
    }

    /**
     * @param string $dureeEntretien
     */
    public function setDureeEntretien($dureeEntretien)
    {
        $this->dureeEntretien = $dureeEntretien;
    }

    /**
     * @return bool
     */
    public function isFormationsEffectuees()
    {
        return $this->formationsEffectuees;
    }

    /**
     * @param bool $formationsEffectuees
     */
    public function setFormationsEffectuees($formationsEffectuees)
    {
        $this->formationsEffectuees = $formationsEffectuees;
    }

    /**
     * Add formationsAnneeEcoulee.
     *
     * @param CrepMj02FormationAnneeEcoulee $formationsAnneeEcoulee
     *
     * @return $this
     */
    public function addFormationsAnneeEcoulee($formationsAnneeEcoulee)
    {
        $this->formationsAnneeEcoulee[] = $formationsAnneeEcoulee;

        $formationsAnneeEcoulee->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAnneeEcoulee.
     *
     * @param CrepMj02FormationAnneeEcoulee $formationsAnneeEcoulee
     */
    public function removeFormationsAnneeEcoulee($formationsAnneeEcoulee)
    {
        $this->formationsAnneeEcoulee->removeElement($formationsAnneeEcoulee);

        $formationsAnneeEcoulee->setCrep(null);
    }

    /**
     * Get formationsAnneeEcoulee.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsAnneeEcoulee()
    {
        return $this->formationsAnneeEcoulee;
    }

    /**
     * Add formationsAnneeAvenir.
     *
     * @param CrepMj02FormationAnneeAvenir $formationsAnneeAvenir
     *
     * @return $this
     */
    public function addFormationsAnneeAvenir($formationsAnneeAvenir)
    {
        $this->formationsAnneeAvenir[] = $formationsAnneeAvenir;

        $formationsAnneeAvenir->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAnneeAvenir.
     *
     * @param CrepMj02FormationAnneeAvenir $formationsAnneeAvenir
     */
    public function removeFormationsAnneeAvenir($formationsAnneeAvenir)
    {
        $this->formationsAnneeAvenir->removeElement($formationsAnneeAvenir);

        $formationsAnneeAvenir->setCrep(null);
    }

    /**
     * Get formationsAnneeAvenir.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsAnneeAvenir()
    {
        return $this->formationsAnneeAvenir;
    }

    /**
     * @return int
     */
    public function getTypeAbsenceEntretien()
    {
        return $this->typeAbsenceEntretien;
    }

    /**
     * @param int $typeAbsenceEntretien
     */
    public function setTypeAbsenceEntretien($typeAbsenceEntretien)
    {
        $this->typeAbsenceEntretien = $typeAbsenceEntretien;
    }

    /**
     * Validation sur CrepMj02
     *
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validateCrepMj02(ExecutionContextInterface $context)
    {
        $isInsuffisant = false;
        /*  *****   VALIDATION: competences insuffisant et très insuffisant   ***** */
        /** @var CrepMj02CompetenceJudiciaire $competence */
        foreach ($this->competencesJudiciaires as $competence) {
            if (!is_null($competence->getNiveauAcquis())) {
                if (is_null($this->getObservationsShd())) {
                    if (self::$niveauCompetence ["Insuffisant"] === $competence->getNiveauAcquis() || self::$niveauCompetence ["Très insuffisant"] === $competence->getNiveauAcquis()) {
                        $isInsuffisant = true;
                    }
                }
            }
        }
        /** @var CrepMj02CompetenceEncadrement $competence */
        foreach ($this->competencesEncadrements as $competence) {
            if (!is_null($competence->getNiveauAcquis())) {
                if (is_null($this->getObservationsShd())) {
                    if (self::$niveauCompetence ["Insuffisant"] === $competence->getNiveauAcquis() || self::$niveauCompetence ["Très insuffisant"] === $competence->getNiveauAcquis()) {
                        $isInsuffisant = true;
                    }
                }
            }
        }

        if ($isInsuffisant) {
            $context->buildViolation('Les observations éventuelles du supérieur hiérarchique direct sont obligatoires : ')
                ->setParameter('cause_competance', 'niveau')
                ->addViolation();
        }

        /** Control motifs d'absence  **/
        $isTypeAbsence = false;
        if ('1' == $this->getRefusEntretienProfessionnel()) {
            if ('0' == $this->getTypeAbsenceEntretien()) {
                $isTypeAbsence = true;
            }
            if ('1' == $this->getTypeAbsenceEntretien()) {
                $isTypeAbsence = true;
            }
            if ('2' == $this->getTypeAbsenceEntretien()) {
                $isTypeAbsence = true;
            }

            if (false === $isTypeAbsence) {
                $context->buildViolation("Motif obligatoire ")
                    ->setParameter('cause_motif', 'absence')
                    ->addViolation();
            }
        }
    }
}
