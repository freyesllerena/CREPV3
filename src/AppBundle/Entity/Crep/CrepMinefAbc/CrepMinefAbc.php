<?php

namespace AppBundle\Entity\Crep\CrepMinefAbc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;
use AppBundle\Entity\FormationSuivie;

/**
 * CrepMinefAbc.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMinefAbcRepository")
 */
class CrepMinefAbc extends Crep
{
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Nom obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
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
     */
    protected $dateNaissance;

    /**
     * @var string @ORM\Column(type="string", nullable=true)
     */
    protected $matricule;

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
     * @ORM\Column(type="string")
     */
    protected $directionAffectation;

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
    protected $motifRefusEntretien;

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
     * @var text
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
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $capaciteOrganiserAnimer;

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
    protected $capaciteDefinirObjectifs;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $typeEntretienCarriere;

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
    protected $commAgentEvolutionPro;

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
    protected $autresBesoinsFormation;

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
    protected $commentaireAgentFormation;

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
    protected $autresPointsAbordesShd;

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
    protected $autresPointsAbordesAgent;

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
    protected $appreciationLitteraleShd;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $precisionsFonctionsAgent;

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
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $fonctionLienAptitudeAgent;

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
    protected $commAptitudesAgent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $appreciationResultatsAgent;

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
    protected $commentaireResultatsAgent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $alaiseDansServiceAgent;

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
    protected $commServiceAgent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $souhaitAutreFonctionAgent;

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
    protected $commSouhaitFonctionAgent;

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
    protected $autresObservationsAgent;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsNotifAgent;

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
    protected $coordonneesEntretien;

    /**
     * @ORM\OneToMany(targetEntity="CrepMinefAbcCompetenceTransverse", mappedBy="crepMinefAbc", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransverses;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $qualiteShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $qualiteAh;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $typeCadenceAvancement;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $revisionGracieuse;

    /**
     * @var \DateTime @ORM\Column(type="date")
     *
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateCommunicationReponse;

    public static $selectTypologieFormation = [
        'Adaptation immédiate au poste de travail (T1)' => 0,
        'Evolution prévisible du métier (T2)' => 1,
        'Développement ou acquisition de nouvelles compétences s’inscrivant dans un projet professionnel (T3)' => 2,
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
        	
        	// Reprise des formations
        	foreach ($dernierCrep->getFormationsDemandeesAgent() as $formation){
        		$formationSuivie = new FormationSuivie();
        		$formationSuivie->setLibelle($formation->getLibelle());
        	
        		$this->addFormationsSuivy($formationSuivie);
        	}
        	
        	// Reprise des fonctions exercees
        	$this->setDescriptionFonctions($dernierCrep->getDescriptionFonctions());
        	
        	// Reprise des acquis de l'expérience professionnelle
        	$this->setAcquisExperiencePro($dernierCrep->getAcquisExperiencePro());
        }

        $transverses = $em
        ->getRepository('AppBundle:CompetenceTransverse')
        ->findByModeleCrep(Util::getClassName($this));

        foreach ($transverses as $transverse) {
            $competenceTransverse = new CrepMinefAbcCompetenceTransverse();
            $competenceTransverse->setCompetenceTransverse($transverse);
            $this->addCompetencesTransverse($competenceTransverse);
        }

        /* @var $crep crepMinefAbc */
        $this->setMatricule($agent->getMatricule());
        $this->setNomUsage($agent->getNom());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDirectionAffectation($agent->getAffectation());
        $this->setDescriptionFonctions($agent->getPosteOccupe());
        $this->setDatePriseFonctions($agent->getDateEntreePosteOccupe());
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
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param
     *            $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

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
    public function getDirectionAffectation()
    {
        return $this->directionAffectation;
    }

    /**
     * @param
     *            $directionAffectation
     */
    public function setDirectionAffectation($directionAffectation)
    {
        $this->directionAffectation = $directionAffectation;

        return $this;
    }

    /**
     * @return the text
     */
    public function getMotifRefusEntretien()
    {
        return $this->motifRefusEntretien;
    }

    /**
     * @param
     *            $motifRefusEntretien
     */
    public function setMotifRefusEntretien($motifRefusEntretien)
    {
        $this->motifRefusEntretien = $motifRefusEntretien;

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
     * @return the text
     */
    public function getAcquisExperiencePro()
    {
        return $this->acquisExperiencePro;
    }

    /**
     * @param
     *            $acquisExperiencePro
     */
    public function setAcquisExperiencePro($acquisExperiencePro)
    {
        $this->acquisExperiencePro = $acquisExperiencePro;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCapaciteOrganiserAnimer()
    {
        return $this->capaciteOrganiserAnimer;
    }

    /**
     * @param
     *            $capaciteOrganiserAnimer
     */
    public function setCapaciteOrganiserAnimer($capaciteOrganiserAnimer)
    {
        $this->capaciteOrganiserAnimer = $capaciteOrganiserAnimer;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCapaciteDefinirObjectifs()
    {
        return $this->capaciteDefinirObjectifs;
    }

    /**
     * @param
     *            $capaciteDefinirObjectifs
     */
    public function setCapaciteDefinirObjectifs($capaciteDefinirObjectifs)
    {
        $this->capaciteDefinirObjectifs = $capaciteDefinirObjectifs;

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
     * @return the string
     */
    public function getTypeEntretienCarriere()
    {
        return $this->typeEntretienCarriere;
    }

    /**
     * @param
     *            $typeEntretienCarriere
     */
    public function setTypeEntretienCarriere($typeEntretienCarriere)
    {
        $this->typeEntretienCarriere = $typeEntretienCarriere;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCommAgentEvolutionPro()
    {
        return $this->commAgentEvolutionPro;
    }

    /**
     * @param
     *            $commAgentEvolutionPro
     */
    public function setCommAgentEvolutionPro($commAgentEvolutionPro)
    {
        $this->commAgentEvolutionPro = $commAgentEvolutionPro;

        return $this;
    }

    /**
     * @return the text
     */
    public function getAutresBesoinsFormation()
    {
        return $this->autresBesoinsFormation;
    }

    /**
     * @param
     *            $autresBesoinsFormation
     */
    public function setAutresBesoinsFormation($autresBesoinsFormation)
    {
        $this->autresBesoinsFormation = $autresBesoinsFormation;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCommentaireAgentFormation()
    {
        return $this->commentaireAgentFormation;
    }

    /**
     * @param
     *            $commentaireAgentFormation
     */
    public function setCommentaireAgentFormation($commentaireAgentFormation)
    {
        $this->commentaireAgentFormation = $commentaireAgentFormation;

        return $this;
    }

    /**
     * @return the text
     */
    public function getAutresPointsAbordesShd()
    {
        return $this->autresPointsAbordesShd;
    }

    /**
     * @param
     *            $autresPointsAbordesShd
     */
    public function setAutresPointsAbordesShd($autresPointsAbordesShd)
    {
        $this->autresPointsAbordesShd = $autresPointsAbordesShd;

        return $this;
    }

    /**
     * @return the text
     */
    public function getAutresPointsAbordesAgent()
    {
        return $this->autresPointsAbordesAgent;
    }

    /**
     * @param
     *            $autresPointsAbordesAgent
     */
    public function setAutresPointsAbordesAgent($autresPointsAbordesAgent)
    {
        $this->autresPointsAbordesAgent = $autresPointsAbordesAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getAppreciationLitteraleShd()
    {
        return $this->appreciationLitteraleShd;
    }

    /**
     * @param
     *            $appreciationLitteraleShd
     */
    public function setAppreciationLitteraleShd($appreciationLitteraleShd)
    {
        $this->appreciationLitteraleShd = $appreciationLitteraleShd;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getPrecisionsFonctionsAgent()
    {
        return $this->precisionsFonctionsAgent;
    }

    /**
     * @param
     *            $precisionsFonctionsAgent
     */
    public function setPrecisionsFonctionsAgent($precisionsFonctionsAgent)
    {
        $this->precisionsFonctionsAgent = $precisionsFonctionsAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCommentaireFonctionAgent()
    {
        return $this->commentaireFonctionAgent;
    }

    /**
     * @param
     *            $commentaireFonctionAgent
     */
    public function setCommentaireFonctionAgent($commentaireFonctionAgent)
    {
        $this->commentaireFonctionAgent = $commentaireFonctionAgent;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getFonctionLienAptitudeAgent()
    {
        return $this->fonctionLienAptitudeAgent;
    }

    /**
     * @param
     *            $fonctionLienAptitudeAgent
     */
    public function setFonctionLienAptitudeAgent($fonctionLienAptitudeAgent)
    {
        $this->fonctionLienAptitudeAgent = $fonctionLienAptitudeAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCommAptitudesAgent()
    {
        return $this->commAptitudesAgent;
    }

    /**
     * @param
     *            $commAptitudesAgent
     */
    public function setCommAptitudesAgent($commAptitudesAgent)
    {
        $this->commAptitudesAgent = $commAptitudesAgent;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getAppreciationResultatsAgent()
    {
        return $this->appreciationResultatsAgent;
    }

    /**
     * @param
     *            $appreciationResultatsAgent
     */
    public function setAppreciationResultatsAgent($appreciationResultatsAgent)
    {
        $this->appreciationResultatsAgent = $appreciationResultatsAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCommentaireResultatsAgent()
    {
        return $this->commentaireResultatsAgent;
    }

    /**
     * @param
     *            $commentaireResultatsAgent
     */
    public function setCommentaireResultatsAgent($commentaireResultatsAgent)
    {
        $this->commentaireResultatsAgent = $commentaireResultatsAgent;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getAlaiseDansServiceAgent()
    {
        return $this->alaiseDansServiceAgent;
    }

    /**
     * @param
     *            $alaiseDansServiceAgent
     */
    public function setAlaiseDansServiceAgent($alaiseDansServiceAgent)
    {
        $this->alaiseDansServiceAgent = $alaiseDansServiceAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCommServiceAgent()
    {
        return $this->commServiceAgent;
    }

    /**
     * @param
     *            $commServiceAgent
     */
    public function setCommServiceAgent($commServiceAgent)
    {
        $this->commServiceAgent = $commServiceAgent;

        return $this;
    }

    /**
     * @return the boolean
     */
    public function getSouhaitAutreFonctionAgent()
    {
        return $this->souhaitAutreFonctionAgent;
    }

    /**
     * @param
     *            $souhaitAutreFonctionAgent
     */
    public function setSouhaitAutreFonctionAgent($souhaitAutreFonctionAgent)
    {
        $this->souhaitAutreFonctionAgent = $souhaitAutreFonctionAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getCommSouhaitFonctionAgent()
    {
        return $this->commSouhaitFonctionAgent;
    }

    /**
     * @param
     *            $commSouhaitFonctionAgent
     */
    public function setCommSouhaitFonctionAgent($commSouhaitFonctionAgent)
    {
        $this->commSouhaitFonctionAgent = $commSouhaitFonctionAgent;

        return $this;
    }

    /**
     * @return the string
     */
    public function getAutresObservationsAgent()
    {
        return $this->autresObservationsAgent;
    }

    /**
     * @param
     *            $autresObservationsAgent
     */
    public function setAutresObservationsAgent($autresObservationsAgent)
    {
        $this->autresObservationsAgent = $autresObservationsAgent;

        return $this;
    }

    /**
     * @return the text
     */
    public function getObservationsNotifAgent()
    {
        return $this->observationsNotifAgent;
    }

    /**
     * @param
     *            $observationsNotifAgent
     */
    public function setObservationsNotifAgent($observationsNotifAgent)
    {
        $this->observationsNotifAgent = $observationsNotifAgent;

        return $this;
    }

    /**
     * @return the text
     */
    public function getCoordonneesEntretien()
    {
        return $this->coordonneesEntretien;
    }

    /**
     * @param
     *            $coordonneesEntretien
     */
    public function setCoordonneesEntretien($coordonneesEntretien)
    {
        $this->coordonneesEntretien = $coordonneesEntretien;

        return $this;
    }

    /**
     * Add competencesTransverse.
     *
     * @param CrepMinefAbcCompetenceTransverse $competencesTransverse
     *
     * @return CrepMinefAbc
     */
    public function addCompetencesTransverse(CrepMinefAbcCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepMinefAbc($this);

        return $this;
    }

    /**
     * Remove competencesTransverse.
     *
     * @param CrepMinefAbcCompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(CrepMinefAbcCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepMinefAbc(null);
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
    public function validateCrepMinefAbc(ExecutionContextInterface $context)
    {
        if ($this->souhaitEntretienCarriere && null === $this->typeEntretienCarriere) {
            $context->buildViolation("Veuillez préciser l'entité avec laquelle l'agent souhaite réaliser son entretien")
            ->atPath('typeEntretienCarriere')
            ->addViolation();
        }
    }

    /**
     * @return the string
     */
    public function getQualiteShd()
    {
        return $this->qualiteShd;
    }

    /**
     * @param
     *            $qualiteShd
     */
    public function setQualiteShd($qualiteShd)
    {
        $this->qualiteShd = $qualiteShd;

        return $this;
    }

    /**
     * @return the string
     */
    public function getQualiteAh()
    {
        return $this->qualiteAh;
    }

    /**
     * @param
     *            $qualiteAh
     */
    public function setQualiteAh($qualiteAh)
    {
        $this->qualiteAh = $qualiteAh;

        return $this;
    }

    /**
     * @return the integer
     */
    public function getTypeCadenceAvancement()
    {
        return $this->typeCadenceAvancement;
    }

    /**
     * @param
     *            $typeCadenceAvancement
     */
    public function setTypeCadenceAvancement($typeCadenceAvancement)
    {
        $this->typeCadenceAvancement = $typeCadenceAvancement;

        return $this;
    }

    public function confidentialisationChampsShd()
    {
        $this->setDescriptionFonctions(null);
        $this->setDatePriseFonctions(null);
        $this->getObjectifsEvalues()->clear();
        $this->setAcquisExperiencePro(null);
        $this->setCapaciteOrganiserAnimer(null);
        $this->setCapaciteDefinirObjectifs(null);
        $this->getObjectifsFuturs()->clear();
        $this->setSouhaitEvolutionCarriere(null);
        $this->setTypeEvolutionCarriere(null);
        $this->setSouhaitMobilite(null);
        $this->setTypeMobilite(null);
        $this->setSouhaitEntretienCarriere(null);
        $this->setTypeEntretienCarriere(null);
        $this->setCoordonneesEntretien(null);
        $this->getFormationsSuivies()->clear();
        $this->getFormationsDemandeesAgent()->clear();
        $this->setAutresBesoinsFormation(null);
        $this->setCommentaireAgentFormation(null);
        $this->setAutresPointsAbordesShd(null);
        $this->setAutresPointsAbordesAgent(null);
        /* @var $transverse CrepMinefAbcCompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }
        $this->setAppreciationLitteraleShd(null);
        $this->setTypeCadenceAvancement(null);
        $this->setRevisionGracieuse(null);
        $this->setDateCommunicationReponse(null);

        $this->setQualiteShd(null);
        $this->setDateVisaShd(null);
        $this->setShdSignataire(null);
    }

    public function confidentialisationChampsAgent()
    {
        $this->setCommAgentEvolutionPro(null);
        $this->setPrecisionsFonctionsAgent(null);
        $this->setCommentaireFonctionAgent(null);
        $this->setFonctionLienAptitudeAgent(null);
        $this->setCommAptitudesAgent(null);
        $this->setAppreciationResultatsAgent(null);
        $this->setCommentaireResultatsAgent(null);
        $this->setAlaiseDansServiceAgent(null);
        $this->setCommServiceAgent(null);
        $this->setSouhaitAutreFonctionAgent(null);
        $this->setCommSouhaitFonctionAgent(null);
        $this->setAutresObservationsAgent(null);

//         $this->setDateVisaAgent(null);
//         $this->setDateRefusVisa(null);

        $this->confidentialisationChampsAgentAvantNotification();
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
        $this->setObservationsNotifAgent(null);
    }

    public function confidentialisationChampsAh()
    {
        $this->setQualiteAh(null);
        $this->setObservationsAh(null);
    }

    public function actualiserDonneesShd()
    {
        // Ce modèle de CREP ne contient pas de champs liés au N+1
    }

    public function getRevisionGracieuse()
    {
        return $this->revisionGracieuse;
    }

    public function setRevisionGracieuse($revisionGracieuse)
    {
        $this->revisionGracieuse = $revisionGracieuse;

        return $this;
    }

    public function getDateCommunicationReponse()
    {
        return $this->dateCommunicationReponse;
    }

    public function setDateCommunicationReponse($dateCommunicationReponse)
    {
        $this->dateCommunicationReponse = $dateCommunicationReponse;

        return $this;
    }
}
