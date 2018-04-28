<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Converter;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;

/**
 * CrepAc.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepAcRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CrepAc extends Crep
{
    /**
     * @var string @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom obligatoire")
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
     *
     * @Assert\Date(message = "Date de naissance non valide")
     */
    protected $dateNaissance;

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
    protected $echelon;

    /**
     * @var string
     *
     * @ORM\Column(name="corps", type="string", nullable=true)
     */
    protected $corps;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cadreEmploi;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gradeEmploi;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $emploiFonctionnel;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $affectationSigle;

    /**
     * @var string @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom obligatoire")
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
    protected $posteOccupeShd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le poste non valide")
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
     */
    protected $datePriseFonctions;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $groupeFonctions;

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
    protected $nbBureauxDirection;

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
    protected $nbCadresEncadresA;

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
    protected $nbTotalAgentsEncadres;

    /**
     * @var bool
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
     * @var bool
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
     * @var bool
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
     * @ORM\OneToMany(targetEntity="CrepAcCompetenceTransverseProfessionnelle", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransversesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcAutreCompetenceTransverseProfessionnelle", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $autresCompetencesTransversesProfessionnelles;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcCompetenceManagerialeExclu", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcAutreCompetenceManagerialeExclu", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $autresCompetencesManageriales;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcCompetenceTransverseRequise", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransversesRequises;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcAutreCompetenceTransverseRequise", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $autresCompetencesTransversesRequises;

    /**
     * =====================================================================================================
     *                                      collections des techniques
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="CrepAcTechnique", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $techniques;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcCompetenceTransverseDetenue", mappedBy="crepAc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransversesDetenues;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $posteOccupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message = "Date d'entrée dans le poste non valide")
     */
    protected $dateEntreePosteOccupe;

    /**
     * @var bool
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
     * @var bool
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
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitEntretienCarriere;

    /**
     * @var bool
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
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $commAgentEvolution;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $docAnnexeBesoinsFormation;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $evolutionIndemnitaire;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $propositionAvancement;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcContraintePoste", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $contraintesPoste;

    /**
     * @ORM\OneToMany(targetEntity="CrepAcAutreContraintePoste", mappedBy="crep", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $autresContraintesPoste;

    /**
     * @ORM\OneToMany(targetEntity="FormationAcSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAcSuivies;

    /**
     * @ORM\OneToMany(targetEntity="ObjectifEvalueCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="ObjectifEvalueIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $objectifsEvaluesIndividuels;

    /**
     * @ORM\OneToMany(targetEntity="ObjectifFuturCollectif", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $objectifsFutursCollectifs;

    /**
     * @ORM\OneToMany(targetEntity="ObjectifFuturIndividuel", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $objectifsFutursIndividuels;

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
        $this->initialiserParent($agent, $em);

        //Initialisation du référentiel des contraintes du poste
        $this->addContraintesPoste(new CrepAcContraintePoste('Besoin d’accompagnement des agents aux missions de la structure'));
        $this->addContraintesPoste(new CrepAcContraintePoste('Relations avec des partenaires extérieurs'));
        $this->addContraintesPoste(new CrepAcContraintePoste('Tâches de gestion lourdes'));
        $this->addContraintesPoste(new CrepAcContraintePoste('Délais impératifs'));

        //Initialisation du référentiel des compétences requises
        $this->addCompetencesTransversesRequise(new CrepAcCompetenceTransverseRequise('Juridiques'));
        $this->addCompetencesTransversesRequise(new CrepAcCompetenceTransverseRequise('Budgétaires et financières'));
        $this->addCompetencesTransversesRequise(new CrepAcCompetenceTransverseRequise('Ressources humaines'));
        $this->addCompetencesTransversesRequise(new CrepAcCompetenceTransverseRequise('Internationales et européennes'));

        //Initialisation du référentiel des compétences professionnelles
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Capacité de synthèse'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Aptitude à communiquer'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Réactivité et respect des délais'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Autonomie et sens de l’organisation'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Capacité d’adaptation'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Capacité à conseiller et à apporter les éléments d’aide à la décision'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Aptitude au travail en équipe'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Capacité à travailler avec des partenaires'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Aptitude à évaluer les situations'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Aptitude à la négociation'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Créativité et sens de l’initiative'));
        $this->addCompetencesTransversesProfessionnelle(new CrepAcCompetenceTransverseProfessionnelle('Sens de l’intérêt général'));

        //Initialisation du référentiel des compétences managériales
        $this->addCompetencesManageriale(new CrepAcCompetenceManagerialeExclu('Capacité à encadrer et déléguer'));
        $this->addCompetencesManageriale(new CrepAcCompetenceManagerialeExclu('Capacité à piloter et à assurer le suivi des dossiers'));
        $this->addCompetencesManageriale(new CrepAcCompetenceManagerialeExclu('Aptitude à développer et à valoriser les compétences des collaborateurs'));
        $this->addCompetencesManageriale(new CrepAcCompetenceManagerialeExclu('Aptitude à la prise de décision, le cas échéant en situation complexe'));

        /* @var $crep CrepAc */
        $this->setPrenom($agent->getPrenom());
        $this->setNomUsage($agent->getNom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setCorps($agent->getCorps());
        $this->setGradeEmploi($agent->getGradeEmploi());
        $this->setAffectationSigle($agent->getAffectation());

        if ($agent->getShd()) {
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setNomUsageShd($agent->getShd()->getNom());
            $this->setCorpsShd($agent->getShd()->getCorps());
            $this->setGradeShd($agent->getShd()->getGrade());
            $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
            $this->setDateEntreePosteOccupeShd($agent->getShd()->getDateEntreePosteOccupe());
        }

        $this->setDescriptionFonctions($agent->getPosteOccupe());
        $this->setDatePriseFonctions($agent->getDateEntreePosteOccupe());
        $this->setPosteOccupe($agent->getPosteOccupe());
        $this->setDateEntreePosteOccupe($agent->getDateEntreePosteOccupe());
    }

    /**
     * Add competencesTransverseProfessionnelle.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseProfessionnelle $competencesTransverseProfessionnelle
     *
     * @return CrepAc
     */
    public function addCompetencesTransversesProfessionnelle(CrepAcCompetenceTransverseProfessionnelle $competencesTransverseProfessionnelle)
    {
        $this->competencesTransversesProfessionnelles[] = $competencesTransverseProfessionnelle;
        $competencesTransverseProfessionnelle->setCrepAc($this);

        return $this;
    }

    /**
     * Remove competencesTransverseProfessionnelle.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseProfessionnelle $competencesTransverseProfessionnelle
     */
    public function removeCompetencesTransversesProfessionnelle(CrepAcCompetenceTransverseProfessionnelle $competencesTransverseProfessionnelle)
    {
        $this->competencesTransversesProfessionnelles->removeElement($competencesTransverseProfessionnelle);
    }

    /**
     * Get competencesTransversesProfessionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesTransversesProfessionnelles()
    {
        return $this->competencesTransversesProfessionnelles;
    }

    /**
     * Add autresCompetencesTransverseProfessionnelle.
     *
     * @param \AppBundle\Entity\CrepAcAutreCompetenceTransverseProfessionnelle $autresCompetencesTransverseProfessionnelle
     *
     * @return CrepAc
     */
    public function addAutresCompetencesTransversesProfessionnelle(CrepAcAutreCompetenceTransverseProfessionnelle $autresCompetencesTransverseProfessionnelle)
    {
        $this->autresCompetencesTransversesProfessionnelles[] = $autresCompetencesTransverseProfessionnelle;
        $autresCompetencesTransverseProfessionnelle->setCrepAc($this);

        return $this;
    }

    /**
     * Remove autresCompetencesTransverseProfessionnelle.
     *
     * @param \AppBundle\Entity\CrepAcAutreCompetenceTransverseProfessionnelle $autresCompetencesTransverseProfessionnelle
     */
    public function removeAutresCompetencesTransversesProfessionnelle(CrepAcAutreCompetenceTransverseProfessionnelle $autresCompetencesTransverseProfessionnelle)
    {
        $this->autresCompetencesTransversesProfessionnelles->removeElement($autresCompetencesTransverseProfessionnelle);
        $autresCompetencesTransverseProfessionnelle->setCrepAc(null);
    }

    /**
     * Get autresCompetencesTransversesProfessionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresCompetencesTransversesProfessionnelles()
    {
        return $this->autresCompetencesTransversesProfessionnelles;
    }

    /**
     * Add competencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseRequise $competencesTransverseRequise
     *
     * @return CrepAc
     */
    public function addCompetencesTransversesRequise(CrepAcCompetenceTransverseRequise $competencesTransverseRequise)
    {
        $this->competencesTransversesRequises[] = $competencesTransverseRequise;
        $competencesTransverseRequise->setCrepAc($this);

        return $this;
    }

    /**
     * Remove competencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseRequise $competencesTransverseRequise
     */
    public function removeCompetencesTransversesRequise(CrepAcCompetenceTransverseRequise $competencesTransverseRequise)
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
     * Add autresCompetencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepAcAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise
     *
     * @return CrepAc
     */
    public function addAutresCompetencesTransversesRequise(CrepAcAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise)
    {
        $this->autresCompetencesTransversesRequises[] = $autresCompetencesTransverseRequise;
        $autresCompetencesTransverseRequise->setCrepAc($this);

        return $this;
    }

    /**
     * Remove autresCompetencesTransverseRequise.
     *
     * @param \AppBundle\Entity\CrepAcAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise
     */
    public function removeAutresCompetencesTransversesRequise(CrepAcAutreCompetenceTransverseRequise $autresCompetencesTransverseRequise)
    {
        $this->autresCompetencesTransversesRequises->removeElement($autresCompetencesTransverseRequise);
        $autresCompetencesTransverseRequise->setCrepAc(null);
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
     * Add competencesTransverseDetenue.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseDetenue $competencesTransverseDetenue
     *
     * @return CrepAc
     */
    public function addCompetencesTransversesDetenue(CrepAcCompetenceTransverseDetenue $competencesTransverseDetenue)
    {
        $this->competencesTransversesDetenues[] = $competencesTransverseDetenue;
        $competencesTransverseDetenue->setCrepAc($this);

        return $this;
    }

    /**
     * Remove competencesTransverseDetenue.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceTransverseDetenue $competencesTransverseDetenue
     */
    public function removeCompetencesTransversesDetenue(CrepAcCompetenceTransverseDetenue $competencesTransverseDetenue)
    {
        $this->competencesTransversesDetenues->removeElement($competencesTransverseDetenue);
        $competencesTransverseDetenue->setCrepAc(null);
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
     * Add competencesManageriale.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceManagerialeExclu $competencesManageriale
     *
     * @return CrepAc
     */
    public function addCompetencesManageriale(CrepAcCompetenceManagerialeExclu $competencesManageriale)
    {
        $this->competencesManageriales[] = $competencesManageriale;
        $competencesManageriale->setCrepAc($this);

        return $this;
    }

    /**
     * Remove competencesManageriale.
     *
     * @param \AppBundle\Entity\CrepAcCompetenceManagerialeExclu $competencesManageriale
     */
    public function removeCompetencesManageriale(CrepAcCompetenceManagerialeExclu $competencesManageriale)
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
     * @param \AppBundle\Entity\CrepAcAutreCompetenceManagerialeExclu $autresCompetencesManageriale
     *
     * @return CrepAc
     */
    public function addAutresCompetencesManageriale(CrepAcAutreCompetenceManagerialeExclu $autresCompetencesManageriale)
    {
        $this->autresCompetencesManageriales[] = $autresCompetencesManageriale;
        $autresCompetencesManageriale->setCrepAc($this);

        return $this;
    }

    /**
     * Remove autresCompetencesManageriale.
     *
     * @param \AppBundle\Entity\CrepAcAutreCompetenceManagerialeExclu $autresCompetencesManageriale
     */
    public function removeAutresCompetencesManageriale(CrepAcAutreCompetenceManagerialeExclu $autresCompetencesManageriale)
    {
        $this->autresCompetencesManageriales->removeElement($autresCompetencesManageriale);
        $autresCompetencesManageriale->setCrepAc(null);
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
     * @return the string
     */
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
     * @return the string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param
     *            $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

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

    /**
     * @return the string
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * @param
     *            $corps
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCadreEmploi()
    {
        return $this->cadreEmploi;
    }

    /**
     * @param
     *            $cadreEmploi
     */
    public function setCadreEmploi($cadreEmploi)
    {
        $this->cadreEmploi = $cadreEmploi;

        return $this;
    }

    /**
     * @return the string
     */
    public function getGradeEmploi()
    {
        return $this->gradeEmploi;
    }

    /**
     * @param
     *            $gradeEmploi
     */
    public function setGradeEmploi($gradeEmploi)
    {
        $this->gradeEmploi = $gradeEmploi;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getEmploiFonctionnel()
    {
        return $this->emploiFonctionnel;
    }

    /**
     * @param
     *            $emploiFonctionnel
     */
    public function setEmploiFonctionnel($emploiFonctionnel)
    {
        $this->emploiFonctionnel = $emploiFonctionnel;

        return $this;
    }

    /**
     * @return the string
     */
    public function getAffectationSigle()
    {
        return $this->affectationSigle;
    }

    /**
     * @param
     *            $affectationSigle
     */
    public function setAffectationSigle($affectationSigle)
    {
        $this->affectationSigle = $affectationSigle;

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
     * @param
     *            $nomUsageShd
     */
    public function setNomUsageShd($nomUsageShd)
    {
        $this->nomUsageShd = $nomUsageShd;

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

    /**
     * @return the string
     */
    public function getCorpsShd()
    {
        return $this->corpsShd;
    }

    /**
     * @param
     *            $corpsShd
     */
    public function setCorpsShd($corpsShd)
    {
        $this->corpsShd = $corpsShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getGradeShd()
    {
        return $this->gradeShd;
    }

    /**
     * @param
     *            $gradeShd
     */
    public function setGradeShd($gradeShd)
    {
        $this->gradeShd = $gradeShd;

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
     * @param
     *            $posteOccupeShd
     */
    public function setPosteOccupeShd($posteOccupeShd)
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
     * @return the text
     */
    public function getCommentaireAgentFonction()
    {
        return $this->commentaireAgentFonction;
    }

    /**
     * @param
     *            $commentaireAgentFonction
     */
    public function setCommentaireAgentFonction($commentaireAgentFonction)
    {
        $this->commentaireAgentFonction = $commentaireAgentFonction;

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
     * @return the string
     */
    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    /**
     * @param
     *            $posteOccupe
     */
    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;

        return $this;
    }

    /**
     * @return the DateTime
     */
    public function getDateEntreePosteOccupe()
    {
        return $this->dateEntreePosteOccupe;
    }

    /**
     * @param \DateTime $dateEntreePosteOccupe
     */
    public function setDateEntreePosteOccupe($dateEntreePosteOccupe)
    {
        $this->dateEntreePosteOccupe = $dateEntreePosteOccupe;

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
    public function getCommAgentEvolution()
    {
        return $this->commAgentEvolution;
    }

    /**
     * @param
     *            $commAgentEvolution
     */
    public function setCommAgentEvolution($commAgentEvolution)
    {
        $this->commAgentEvolution = $commAgentEvolution;

        return $this;
    }

    /**
     * @return the text
     */
    public function getAppreciationGenerale()
    {
        return $this->appreciationGenerale;
    }

    /**
     * @param
     *            $appreciationGenerale
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
     * @param
     *            $evolutionIndemnitaire
     */
    public function setEvolutionIndemnitaire($evolutionIndemnitaire)
    {
        $this->evolutionIndemnitaire = $evolutionIndemnitaire;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getPropositionAvancement()
    {
        return $this->propositionAvancement;
    }

    /**
     * @param
     *            $propositionAvancement
     */
    public function setPropositionAvancement($propositionAvancement)
    {
        $this->propositionAvancement = $propositionAvancement;

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

    /**
     * Add contraintesPoste.
     *
     * @param \AppBundle\Entity\CrepAcContraintePoste $contraintesPoste
     *
     * @return CrepAc
     */
    public function addContraintesPoste(CrepAcContraintePoste $contraintesPoste)
    {
        $this->contraintesPoste[] = $contraintesPoste;
        $contraintesPoste->setCrep($this);

        return $this;
    }

    /**
     * Remove contraintesPoste.
     *
     * @param \AppBundle\Entity\CrepAcContraintePoste $contraintesPoste
     */
    public function removeContraintesPoste(CrepAcContraintePoste $contraintesPoste)
    {
        $this->contraintesPoste->removeElement($contraintesPoste);
        $contraintesPoste->setCrep(null);
    }

    /**
     * Get contraintesPoste.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContraintesPoste()
    {
        return $this->contraintesPoste;
    }

    /**
     * Add autresContraintesPoste.
     *
     * @param \AppBundle\Entity\CrepAcAutreContraintePoste $autresContraintesPoste
     *
     * @return CrepAc
     */
    public function addAutresContraintesPoste(CrepAcAutreContraintePoste $autresContraintesPoste)
    {
        $this->autresContraintesPoste[] = $autresContraintesPoste;
        $autresContraintesPoste->setCrep($this);

        return $this;
    }

    /**
     * Remove autresContraintesPoste.
     *
     * @param \AppBundle\Entity\CrepAcAutreContraintePoste $autresContraintesPoste
     */
    public function removeAutresContraintesPoste(CrepAcAutreContraintePoste $autresContraintesPoste)
    {
        $this->autresContraintesPoste->removeElement($autresContraintesPoste);
        $autresContraintesPoste->setCrep(null);
    }

    /**
     * Get autresContraintesPoste.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutresContraintesPoste()
    {
        return $this->autresContraintesPoste;
    }

    /**
     * Add formationsAcSuivy.
     *
     * @param FormationAcSuivie $formationsAcSuivy
     *
     * @return CrepAc
     */
    public function addFormationsAcSuivy(FormationAcSuivie $formationsAcSuivy)
    {
        $this->formationsAcSuivies[] = $formationsAcSuivy;
        $formationsAcSuivy->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAcSuivy.
     *
     * @param FormationAcSuivie $formationsAcSuivy
     */
    public function removeFormationsAcSuivy(FormationAcSuivie $formationsAcSuivy)
    {
        $this->formationsAcSuivies->removeElement($formationsAcSuivy);
        $formationsAcSuivy->setCrep(null);
    }

    /**
     * Get formationsAcSuivies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsAcSuivies()
    {
        return $this->formationsAcSuivies;
    }

    public function confidentialisationChampsShd()
    {
        $this->setDescriptionFonctions(null);
        $this->setDatePriseFonctions(null);
        $this->setGroupeFonctions(null);
        $this->setNbBureauxDirection(null);
        $this->setNbCadresEncadresA(null);
        $this->setNbTotalAgentsEncadres(null);
        $this->setPresenceAdjoints(null);
        $this->setObservationsEffectifs(null);
        /* @var $contrainte CrepAcContraintePoste */
        foreach ($this->getContraintesPoste() as $contrainte) {
            $contrainte->setNiveauDifficulte(null);
            $contrainte->setObservations(null);
        }
        if ($this->getAutresContraintesPoste()) {
            $this->getAutresContraintesPoste()->clear();
        }

        $this->setDocAnnexeBilan(null);
        $this->setContexteObjectifsPasses(null);
        $this->getObjectifsEvaluesCollectifs()->clear();
        $this->getObjectifsEvaluesIndividuels()->clear();
        $this->setAutresDossiers(null);
        $this->setDocAnnexeObjectifsAvenir(null);
        $this->setContexteObjectifsAvenir(null);
        $this->getObjectifsFutursCollectifs()->clear();
        $this->getObjectifsFutursIndividuels()->clear();
        /* @var $competenceRequise CrepAcCompetenceTransverseRequise */
        foreach ($this->getCompetencesTransversesRequises() as $competenceRequise) {
            $competenceRequise->setNiveauAcquis(null);
            $competenceRequise->setObservations(null);
        }

        if ($this->getAutresCompetencesTransversesRequises()) {
            $this->getAutresCompetencesTransversesRequises()->clear();
        }

        /* @var $competenceProfessionnelle CrepAcCompetenceTransverseProfessionnelle */
        foreach ($this->getCompetencesTransversesProfessionnelles() as $competenceProfessionnelle) {
            $competenceProfessionnelle->setNiveauAcquis(null);
            $competenceProfessionnelle->setObservations(null);
        }

        if ($this->getAutresCompetencesTransversesProfessionnelles()) {
            $this->getAutresCompetencesTransversesProfessionnelles()->clear();
        }

        /* @var $competenceManageriale CrepAcCompetenceManageriale */
        foreach ($this->getCompetencesManageriales() as $competenceManageriale) {
            $competenceManageriale->setNiveauAcquis(null);
            $competenceManageriale->setObservations(null);
        }

        if ($this->getAutresCompetencesManageriales()) {
            $this->getAutresCompetencesManageriales()->clear();
        }

        $this->setSouhaitEvolutionCarriere(null);
        $this->setTypeEvolutionCarriere(null);
        $this->setSouhaitMobilite(null);
        $this->setTypeMobilite(null);
        $this->setSouhaitEntretienCarriere(null);
        $this->setApptitudeNiveauSup(null);
        $this->setObservationShdEvolution(null);
        $this->setDocAnnexeBesoinsFormation(null);

        if ($this->getFormationsAcSuivies()) {
            $this->getFormationsAcSuivies()->clear();
        }

        if ($this->getFormationsDemandeesAgent()) {
            $this->getFormationsDemandeesAgent()->clear();
        }

        $this->setAppreciationGenerale(null);
        $this->setEvolutionIndemnitaire(null);
        $this->setPropositionAvancement(null);

        if ($this->getTechniques()) {
            $this->getTechniques()->clear();
        }
    }

    public function confidentialisationChampsAgent()
    {
        $this->setCommentaireAgentFonction(null);
        $this->getCompetencesTransversesDetenues()->clear();
        $this->setCommAgentEvolution(null);
        $this->setObservationsVisaAgent(null);
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
            $this->setDateEntreePosteOccupeShd($shd->getDateEntreePosteOccupe())
            ->setGradeShd($shd->getGrade())
            ->setNomUsageShd($shd->getNom())
            ->setPosteOccupeShd($shd->getPosteOccupe())
            ->setPrenomShd($shd->getPrenom())
            ->setCorpsShd($shd->getCorps());
        } else {
            $this->setDateEntreePosteOccupeShd(null)
            ->setGradeShd(null)
            ->setNomUsageShd(null)
            ->setPosteOccupeShd(null)
            ->setPrenomShd(null)
            ->setCorpsShd(null);
        }
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

    /**
     * Add objectifsEvalueCollectif.
     *
     * @param \AppBundle\Entity\ObjectifEvalueCollectif $objectifsEvalueCollectif
     *
     * @return Crep
     */
    public function addObjectifsEvaluesCollectif(ObjectifEvalueCollectif $objectifsEvalueCollectif)
    {
        $this->objectifsEvaluesCollectifs[] = $objectifsEvalueCollectif;
        $objectifsEvalueCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueCollectif.
     *
     * @param ObjectifEvalueCollectif $objectifsEvalueCollectif
     */
    public function removeObjectifsEvaluesCollectif(ObjectifEvalueCollectif $objectifsEvalueCollectif)
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
     * @param ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     *
     * @return Crep
     */
    public function addObjectifsEvaluesIndividuel(ObjectifEvalueIndividuel $objectifsEvalueIndividuel)
    {
        $this->objectifsEvaluesIndividuels[] = $objectifsEvalueIndividuel;
        $objectifsEvalueIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalueIndividuel.
     *
     * @param ObjectifEvalueIndividuel $objectifsEvalueIndividuel
     */
    public function removeObjectifsEvaluesIndividuel(ObjectifEvalueIndividuel $objectifsEvalueIndividuel)
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
     * @param ObjectifFuturCollectif $objectifsFuturCollectif
     *
     * @return Crep
     */
    public function addObjectifsFutursCollectif(ObjectifFuturCollectif $objectifsFuturCollectif)
    {
        $this->objectifsFutursCollectifs[] = $objectifsFuturCollectif;
        $objectifsFuturCollectif->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturCollectif.
     *
     * @param ObjectifFuturCollectif $objectifsFuturCollectif
     */
    public function removeObjectifsFutursCollectif(ObjectifFuturCollectif $objectifsFuturCollectif)
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
     * @param \AppBundle\Entity\ObjectifFuturIndividuel $objectifsFuturIndividuel
     *
     * @return Crep
     */
    public function addObjectifsFutursIndividuel(ObjectifFuturIndividuel $objectifsFuturIndividuel)
    {
        $this->objectifsFutursIndividuels[] = $objectifsFuturIndividuel;
        $objectifsFuturIndividuel->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFuturIndividuel.
     *
     * @param \AppBundle\Entity\ObjectifFuturIndividuel $objectifsFuturIndividuel
     */
    public function removeObjectifsFutursIndividuel(ObjectifFuturIndividuel $objectifsFuturIndividuel)
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
     * Add technique.
     *
     * @param \AppBundle\Entity\CrepAcTechnique $techniques
     *
     * @return CrepAc
     */
    public function addTechnique(CrepAcTechnique $techniques)
    {
        $this->techniques[] = $techniques;
        $techniques->setCrepAc($this);

        return $this;
    }

    /**
     * Remove technique.
     *
     * @param \AppBundle\Entity\CrepAcTechnique $techniques
     */
    public function removeTechnique(CrepAcTechnique $techniques)
    {
        $this->techniques->removeElement($techniques);
        $techniques->setCrepAc(null);
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
     * @Assert\Callback
     */
    public function validateCrepAc(ExecutionContextInterface $context)
    {
        // Cette variable calucle le nombre de compétences (requises, professionnelles et manageriales) dont le niveau acquis est exceptionnelle
        $nbCompetenceNiveauExceptionnelle = 0;

        /* @var $competenceRequise CrepAcCompetenceTransverseRequise  */
        foreach ($this->competencesTransversesRequises as $competenceRequise) {
            if (null !== $competenceRequise->getNiveauAcquis()
                    && 0 == $competenceRequise->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $autreCompetenceRequise CrepAcAutreCompetenceTransverseRequise  */
        foreach ($this->autresCompetencesTransversesRequises as $autreCompetenceRequise) {
            if ($autreCompetenceRequise->getLibelle()
                        && null !== $autreCompetenceRequise->getNiveauAcquis()
                        && 0 == $autreCompetenceRequise->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $competenceProfessionnelle CrepAcCompetenceTransverseProfessionnelle  */
        foreach ($this->competencesTransversesProfessionnelles as $competenceProfessionnelle) {
            if (null !== $competenceProfessionnelle->getNiveauAcquis()
                    && 0 == $competenceProfessionnelle->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $autreCompetenceProfessionnelle CrepAcAutreCompetenceTransverseProfessionnelle  */
        foreach ($this->autresCompetencesTransversesProfessionnelles as $autreCompetenceProfessionnelle) {
            if ($autreCompetenceProfessionnelle->getLibelle()
                        && null !== $autreCompetenceProfessionnelle->getNiveauAcquis()
                        && 0 == $autreCompetenceProfessionnelle->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $competenceManageriale CrepAcCompetenceManageriale  */
        foreach ($this->competencesManageriales as $competenceManageriale) {
            if (null !== $competenceManageriale->getNiveauAcquis()
                    && 0 == $competenceManageriale->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $autreCompetenceManageriale CrepAcAutreCompetenceManagerialeExclu  */
        foreach ($this->autresCompetencesManageriales as $autreCompetenceManageriale) {
            if ($autreCompetenceManageriale->getLibelle()
                        && null !== $autreCompetenceManageriale->getNiveauAcquis()
                        && 0 == $autreCompetenceManageriale->getNiveauAcquis()) {
                ++$nbCompetenceNiveauExceptionnelle;
            }
        }

        /* @var $technique CrepAcTechnique */
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
