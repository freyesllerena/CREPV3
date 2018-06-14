<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Util\Converter;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\EnumTypes\EnumStatutValidationAgent;

/**
 * Agent.
 *
 * @ORM\Table(name="agent", indexes = {	@ORM\Index(columns={"email"}),
 * 										@ORM\Index(columns={"civilite"}),
 * 										@ORM\Index(columns={"nom"}),
 * 										@ORM\Index(columns={"prenom"}),
 * 										@ORM\Index(columns={"dtype"}),
 * 										@ORM\Index(columns={"evaluable"})
 * 							}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgentRepository")
 * @UniqueEntity(
 *     fields={"email", "campagnePnc"},
 *     errorPath="email",
 *     groups={"importCSV"},
 *     message="Cet agent existe déjà dans cette campagne, veuillez contacter l'instance supérieure"
 * )
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\HasLifecycleCallbacks
 */
class Agent extends Personne
{
    /**
     * @var Utilisateur
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $utilisateur;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $matricule;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nomNaissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nomMarital;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date de naissance non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV"})
     * @Assert\LessThanOrEqual(value = "today", message = "La date de naissance ne peut pas être supérieure à la date du jour", groups={"importCSV"})
     */
    protected $dateNaissance;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Crep")
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $corps;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le corps non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
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
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le grade non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreeGrade;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $echelon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans l'échelon non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreeEchelon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gradeEmploi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le grade d'emploi non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreeGradeEmploi;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $etablissement;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $departement;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $affectation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $affectationClairAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $posteOccupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreePosteOccupe;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeSirh1; //Pour le mindef, ce code correspond au code Alliance

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeSirh2; //Pour le mindef, ce code correspond au code CREDO

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Cette valeur n'est pas valide.",
     *      maxMessage = "Cette valeur n'est pas valide.",
     *      invalidMessage = "Cette valeur n'est pas valide.",
     *      groups={"importCSV", "Default"}
     * )
     */
    protected $capitalDif;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Cette valeur n'est pas valide.",
     *      maxMessage = "Cette valeur n'est pas valide.",
     *      invalidMessage = "Cette valeur n'est pas valide.",
     *      groups={"importCSV", "Default"}
     * )
     */
    protected $capitalDifMobilisable;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    protected $evaluable = true;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $sansAh = false;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_non_evaluation", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 256,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifNonEvaluation;

    /**
     * @var CampagneBrhp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagneBrhp", inversedBy="agents")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $campagneBrhp;

    /**
     * @var CampagneRlc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagneRlc", inversedBy="agents")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $campagneRlc;

    /**
     * @var CampagnePnc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagnePnc", inversedBy="agents")
     * @ORM\JoinColumn(nullable=true)
     * // TODO : ne pas oublier de mettre nullable=false
     */
    protected $campagnePnc;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     */
    protected $shd;

    /**
     * @ORM\ManyToOne(targetEntity="Agent", cascade={"persist"})
     */
    protected $ah;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $categorieAgent;

    protected $ligne;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"rattachement validé","rattachement rejeté", "rattachement en attente de validation"}, message = "Statut non valide. Valeurs acceptées : 'rattachement validé','rattachement rejeté', 'rattachement en attente de validation'")
     */
    protected $statutValidation;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $validationShd = true;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"Mauvais rattachement N+1", "Mauvais rattachement N+2","Autre"}, message = "Statut non valide. Valeurs acceptées : 'Mauvais rattachement N+1', 'Mauvais rattachement N+2','Autre'")
     */
    protected $erreurSignalee;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 256,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $commentaireValidation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 64,
     *      maxMessage = "Le code UO est limité à {{ limit }} caractères"
     * )
     */
    protected $codeUo;

    /**
     * @var PerimetreBrhp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreBrhp")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $perimetreBrhp;

    /**
     * @var PerimetreRlc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreRlc")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $perimetreRlc;

    /**
     * @var UniteOrganisationnelle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UniteOrganisationnelle")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $uniteOrganisationnelle;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    protected $ajouteManuellement = false;

    /**
     * TODO: champs à déplacer dans AgentMcc.php.
     */
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $titulaire = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée au ministère non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreeMinistere;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"cdi", "cdd", "titulaire", null}, message = "Type de contrat non valide. Les valeurs possibles sont : 'CDI', 'CDD', 'Titulaire'", groups={"importCSV", "Default"})
     */
    protected $contrat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date de début du contrat non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateDebutContrat;

    /**
     * @ORM\ManyToMany(targetEntity="Document", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({"nom" = "ASC"})
     * @Assert\Valid
     */
    private $documents;

    /**
     * @var ModeleCrep
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ModeleCrep")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $modeleCrep;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->statutValidation = EnumStatutValidationAgent::EN_COURS;
    }

    /**
     * Set utilisateur.
     *
     * @param Utilisateur $utilisateur
     *
     * @return Rlc
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur.
     *
     * @return Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set matricule.
     *
     * @param string $matricule
     *
     * @return Agent
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule.
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set nomNaissance.
     *
     * @param string $nomNaissance
     *
     * @return Agent
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
     * Set nomMarital.
     *
     * @param string $nomMarital
     *
     * @return Agent
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
     * Set dateNaissance.
     *
     * @param \DateTime $dateNaissance
     *
     * @return Agent
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = Converter::convertDate($dateNaissance);

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
     * Set campagneBrhp.
     *
     * @param \AppBundle\Entity\CampagneBrhp $campagneBrhp
     *
     * @return Agent
     */
    public function setCampagneBrhp($campagneBrhp)
    {
        $this->campagneBrhp = $campagneBrhp;

        if ($campagneBrhp) {
            $this->setPerimetreBrhp($campagneBrhp->getPerimetreBrhp());
            $this->campagneRlc = $campagneBrhp->getCampagneRlc();
        }

        return $this;
    }

    /**
     * Get campagneBrhp.
     *
     * @return \AppBundle\Entity\CampagneBrhp
     */
    public function getCampagneBrhp()
    {
        return $this->campagneBrhp;
    }

    /**
     * Set campagneRlc.
     *
     * @param \AppBundle\Entity\CampagneRlc $campagneRlc
     *
     * @return Agent
     */
    public function setCampagneRlc($campagneRlc)
    {
        $this->campagneRlc = $campagneRlc;

        return $this;
    }

    /**
     * Get campagneRlc.
     *
     * @return \AppBundle\Entity\CampagneRlc
     */
    public function getCampagneRlc()
    {
        return $this->campagneRlc;
    }

    /**
     * Set campagnePnc.
     *
     * @param \AppBundle\Entity\CampagnePnc $campagnePnc
     *
     * @return Agent
     */
    public function setCampagnePnc(\AppBundle\Entity\CampagnePnc $campagnePnc)
    {
        $this->campagnePnc = $campagnePnc;

        return $this;
    }

    /**
     * Get campagnePnc.
     *
     * @return \AppBundle\Entity\CampagnePnc
     */
    public function getCampagnePnc()
    {
        return $this->campagnePnc;
    }

    /**
     * Set shd.
     *
     * @param \AppBundle\Entity\Agent $shd
     *
     * @return Agent
     */
    public function setShd(\AppBundle\Entity\Agent $shd = null)
    {
        $this->shd = $shd;

        return $this;
    }

    /**
     * Get shd.
     *
     * @return \AppBundle\Entity\Agent
     */
    public function getShd()
    {
        return $this->shd;
    }

    /**
     * Set ah.
     *
     * @param \AppBundle\Entity\Agent $ah
     *
     * @return Agent
     */
    public function setAh(\AppBundle\Entity\Agent $ah = null)
    {
        $this->ah = $ah;
        if ($ah) {
            $this->setSansAh(false);
        }

        return $this;
    }

    /**
     * Get ah.
     *
     * @return \AppBundle\Entity\Agent
     */
    public function getAh()
    {
        return $this->ah;
    }

    /**
     * Set crep.
     *
     * @param Crep $crep
     *
     * @return Agent
     */
    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return Crep
     */
    public function getCrep()
    {
        return $this->crep;
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

    public function setDateEntreeCorps($dateEntreeCorps)
    {
        $this->dateEntreeCorps = Converter::convertDate($dateEntreeCorps);

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

    public function setDateEntreeGrade($dateEntreeGrade)
    {
        $this->dateEntreeGrade = Converter::convertDate($dateEntreeGrade);

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

    public function setDateEntreeEchelon($dateEntreeEchelon)
    {
        $this->dateEntreeEchelon = Converter::convertDate($dateEntreeEchelon);

        return $this;
    }

    public function getGradeEmploi()
    {
        return $this->gradeEmploi;
    }

    public function setGradeEmploi($gradeEmploi)
    {
        $this->gradeEmploi = $gradeEmploi;

        return $this;
    }

    public function getDateEntreeGradeEmploi()
    {
        return $this->dateEntreeGradeEmploi;
    }

    public function setDateEntreeGradeEmploi($dateEntreeGradeEmploi)
    {
        $this->dateEntreeGradeEmploi = Converter::convertDate($dateEntreeGradeEmploi);

        return $this;
    }

    public function getEtablissement()
    {
        return $this->etablissement;
    }

    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getDepartement()
    {
        return $this->departement;
    }

    public function setDepartement($departement)
    {
        $this->departement = $departement;

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

    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;

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

    public function getCodeSirh1()
    {
        return $this->codeSirh1;
    }

    public function setCodeSirh1($codeSirh1)
    {
        $this->codeSirh1 = $codeSirh1;

        return $this;
    }

    public function getCodeSirh2()
    {
        return $this->codeSirh2;
    }

    public function setCodeSirh2($codeSirh2)
    {
        $this->codeSirh2 = $codeSirh2;

        return $this;
    }

    public function getCapitalDif()
    {
        return $this->capitalDif;
    }

    public function setCapitalDif($capitalDif)
    {
        $this->capitalDif = $capitalDif;

        return $this;
    }

    public function getCapitalDifMobilisable()
    {
        return $this->capitalDifMobilisable;
    }

    public function setCapitalDifMobilisable($capitalDifMobilisable)
    {
        $this->capitalDifMobilisable = $capitalDifMobilisable;

        return $this;
    }

    public function getEvaluable()
    {
        return $this->evaluable;
    }

    public function setEvaluable($evaluable)
    {
        $this->evaluable = $evaluable;

        return $this;
    }

    public function getLigne()
    {
        return $this->ligne;
    }

    public function setLigne($ligne)
    {
        $this->ligne = $ligne;

        return $this;
    }

    /**
     * Set categorieAgent.
     *
     * @param string $categorieAgent
     *
     * @return Agent
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

    public function getMotifNonEvaluation()
    {
        return $this->motifNonEvaluation;
    }

    public function setMotifNonEvaluation($motifNonEvaluation)
    {
        $this->motifNonEvaluation = $motifNonEvaluation;

        return $this;
    }

    public function getErreurSignalee()
    {
        return $this->erreurSignalee;
    }

    public function setErreurSignalee($erreurSignalee)
    {
        $this->erreurSignalee = $erreurSignalee;

        return $this;
    }

    /**
     * Set perimetreBrhp.
     *
     * @param PerimetreBrhp $perimetreBrhp
     *
     * @return Agent
     */
    public function setPerimetreBrhp($perimetreBrhp)
    {
        $this->perimetreBrhp = $perimetreBrhp;

        if ($perimetreBrhp) {
            $this->perimetreRlc = $perimetreBrhp->getPerimetreRlc();
        }

        return $this;
    }

    /**
     * Get perimetreBrhp.
     *
     * @return PerimetreBrhp
     */
    public function getPerimetreBrhp()
    {
        return $this->perimetreBrhp;
    }

    /**
     * Set perimetreRlc.
     *
     * @param PerimetreRlc $perimetreRlc
     *
     * @return Agent
     */
    public function setPerimetreRlc($perimetreRlc)
    {
        $this->perimetreRlc = $perimetreRlc;

        return $this;
    }

    /**
     * Get perimetreRlc.
     *
     * @return PerimetreRlc
     */
    public function getPerimetreRlc()
    {
        return $this->perimetreRlc;
    }

    /**
     * Set uniteOrganisationnelle.
     *
     * @param UniteOrganisationnelle $uniteOrganisationnelle
     *
     * @return Agent
     */
    public function setUniteOrganisationnelle($uniteOrganisationnelle)
    {
        $this->uniteOrganisationnelle = $uniteOrganisationnelle;

        return $this;
    }

    /**
     * Get uniteOrganisationnelle.
     *
     * @return UniteOrganisationnelle
     */
    public function getUniteOrganisationnelle()
    {
        return $this->uniteOrganisationnelle;
    }

    /**
     * @Assert\Callback(groups={"importCSV", "Default"})
     */
    public function validateAgent(ExecutionContextInterface $context)
    {
        // Un agent ne peut pas s'autoévaluer : son adresse mail ne doit pas appraître sur la colonne adresse mail du N+1 de la même ligne
        if (null !== $this->getEmail() && $this->getShd() && $this->getEmail() === $this->getShd()->getEmail()) {
            $context->buildViolation('Un agent ne peut pas s\'autoévaluer')
            ->atPath('shd')
            ->addViolation();
        }

        // Un agent ne peut pas s'autoévaluer : son adresse mail ne doit pas appraître sur la colonne adresse mail du N+2 de la même ligne
        if (null !== $this->getEmail() && $this->getAh() && $this->getEmail() === $this->getAh()->getEmail()) {
            $context->buildViolation('Un agent ne peut pas s\'autoévaluer')
            ->atPath('ah')
            ->addViolation();
        }

        // Un agent ayant un CREP ne peut pas être sans N+1
        if ($this->getCrep() && !$this->getShd()) {
            $context->buildViolation('Un agent ayant un CREP ne peut pas être sans N+1')
            ->atPath('shd')
            ->addViolation();
        }
    }

    /**
     * @Assert\Callback(groups={"validationShd"})
     */
    public function validationShd(ExecutionContextInterface $context)
    {
        // Si le statut est valide, on ignore le champ erreur signalée et commentaire statut validation
        if (EnumStatutValidationAgent::VALIDE == $this->getStatutValidation()) {
            $this->erreurSignalee = null;
            $this->commentaireValidation = null;
        }

        // Si le statut est rejeté, il faut préciser l'erreur
        if (0 == $this->getValidationShd() && !$this->getErreurSignalee()) {
            $context->buildViolation('Veuillez préciser la nature de l\'erreur')
            ->atPath('erreurSignalee')
            ->addViolation();
        }
    }

    public function getCodeUo()
    {
        return $this->codeUo;
    }

    public function setCodeUo($codeUo)
    {
        $this->codeUo = $codeUo;

        return $this;
    }

    public function getStatutValidation()
    {
        return $this->statutValidation;
    }

    public function setStatutValidation($statutValidation)
    {
        $this->statutValidation = $statutValidation;

        return $this;
    }

    public function getCommentaireValidation()
    {
        return $this->commentaireValidation;
    }

    public function setCommentaireValidation($commentaireValidation)
    {
        $this->commentaireValidation = $commentaireValidation;

        return $this;
    }

    public function __toString()
    {
        return $this->nom.' '.$this->prenom;
    }

    public function getAjouteManuellement()
    {
        return $this->ajouteManuellement;
    }

    public function setAjouteManuellement($ajouteManuellement)
    {
        $this->ajouteManuellement = $ajouteManuellement;

        return $this;
    }

    public function getSansAh()
    {
        return $this->sansAh;
    }

    public function setSansAh($sansAh)
    {
        $this->sansAh = $sansAh;
        if ($sansAh) {
            $this->ah = null;
        }

        return $this;
    }

    public function getValidationShd()
    {
        return $this->validationShd;
    }

    public function setValidationShd($validationShd)
    {
        $this->validationShd = $validationShd;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTitulaire()
    {
        return $this->titulaire;
    }

    /**
     * @param bool $titulaire
     *
     * @return $this
     */
    public function setTitulaire($titulaire)
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEntreeMinistere()
    {
        return $this->dateEntreeMinistere;
    }

    /**
     * @param \DateTime $dateEntreeMinistere
     *
     * @return $this
     */
    public function setDateEntreeMinistere($dateEntreeMinistere)
    {
        $this->dateEntreeMinistere = Converter::convertDate($dateEntreeMinistere);

        return $this;
    }

    /**
     * @return string
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param string $contrat
     *
     * @return $this
     */
    public function setContrat($contrat)
    {
        if ($contrat) {
            $this->contrat = strtolower($contrat);

            if ('titulaire' == $contrat) {
                $this->setTitulaire(true);
            } else {
                $this->setTitulaire(false);
            }
        } else {
            $this->contrat = $contrat;

            if ($this->campagnePnc && 3 == $this->campagnePnc->getMinistere()->getId()) {
                $this->setTitulaire(true);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebutContrat()
    {
        return $this->dateDebutContrat;
    }

    /**
     * @param \DateTime $dateDebutContrat
     */
    public function setDateDebutContrat($dateDebutContrat)
    {
        $this->dateDebutContrat = Converter::convertDate($dateDebutContrat);

        return $this;
    }

    /**
     * Add document.
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return Agent
     */
    public function addDocument(Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document.
     *
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return ModeleCrep
     */
    public function getModeleCrep()
    {
        return $this->modeleCrep;
    }

    /**
     * @param ModeleCrep $modeleCrep
     */
    public function setModeleCrep($modeleCrep)
    {
        $this->modeleCrep = $modeleCrep;

        return $this;
    }

    //Fonction qui définit le nom par défaut du CREP pdf (nom_prenom_CREP_anneeEvaluation.pdf)
    public function getPdfFileName()
    {
        $matriculeAgent = $this->matricule;
        $nomAgent = $this->getNom();
        $prenomAgent = $this->getPrenom();
        $anneeEvaluation = $this->getCampagnePnc()->getAnneeEvaluee();

        //Si c'est le ministère de la défense, on applique leur règle de nommage
        if (4 == $this->campagnePnc->getMinistere()->getId()) {
            $filename = $matriculeAgent.'_'.strtoupper(Converter::convertStringToProgressio($nomAgent)).'_CREP'.$anneeEvaluation.'.pdf';
        } else {
            $filename = strtoupper(Converter::convertStringToProgressio($nomAgent)).'_'.strtoupper(Converter::convertStringToProgressio($prenomAgent)).'_CREP'.$anneeEvaluation.'.pdf';
        }

        return $filename;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * Si l'agent est titulaire, on set les champs dateEntreeMinistere, type du contrat et début du contrat à null
     */
    public function miseAJourChampsContrat()
    {
        if ($this->isTitulaire()) {
            $this
            ->setDateEntreeMinistere(null)
            ->setContrat(null)
            ->setDateDebutContrat(null);
        }
    }
}
