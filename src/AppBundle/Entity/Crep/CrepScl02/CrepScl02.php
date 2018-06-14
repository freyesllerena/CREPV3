<?php

namespace AppBundle\Entity\Crep\CrepScl02;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;

/**
 * CrepScl02
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepScl02Repository")
 */
class CrepScl02 extends Crep
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
     *
     * @var \DateTime @ORM\Column(type="date")
     *
     * @Assert\Date(message = "Date de naissance non valide")
     */
    protected $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
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
     *
     */
    protected $directionAffectation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     */
    protected $rang;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":false})
     *
     */
    protected $echelonTerminal = false;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifRefusEntretien;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $descriptionFonctions;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $acquisExperiencePro;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $typeEvolutionCarriere;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="perspectives_evol_fonction")
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $perspectivesEvolutionFonction;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $typeMobilite;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $autresPointsAbordesShd;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $autresPointsAbordesAgent;

    /**
     * @ORM\OneToMany(targetEntity="CrepScl02CompetenceTransverse", mappedBy="crepScl02", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransverses;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $appreciationLitteraleShd;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     */
    protected $qualiteAh;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_agent_deroul_entretien")
     * @Assert\Length(
     *      max = 4090,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAgentDeroulementEntretien;

    public function __construct()
    {
        parent::init();
        $this->competencesTransverses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        // initialisation des competences transverses
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Connaissances professionnelles dans l’emploi occupé", "Générale"));
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Compétences personnelles", "Générale"));
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Implication professionnelle", "Générale"));
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Sens du service public", "Générale"));
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Capacité à organiser et animer une équipe", "Encadrement"));
        $this->addCompetencesTransverse(new CrepScl02CompetenceTransverse("Capacité à définir et à évaluer des objectifs", "Encadrement"));

        /* @var $crep CrepScl02*/
        $this->setNomUsage($agent->getNom());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDirectionAffectation($agent->getAffectation());
        $this->setDescriptionFonctions($agent->getPosteOccupe());

        /* @var $transverse CrepScl02CompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }
        $this->setAppreciationLitteraleShd(null);
    }

    /**
     *
     * @return string
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     *
     * @param $nomUsage
     *
     * @return CrepScl02
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     *
     * @param $prenom
     *
     * @return CrepScl02
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     *
     * @return CrepScl02
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param $grade
     *
     * @return CrepScl02
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * @param $echelon
     *
     * @return CrepScl02
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDirectionAffectation()
    {
        return $this->directionAffectation;
    }

    /**
     * @param $directionAffectation
     *
     * @return CrepScl02
     */
    public function setDirectionAffectation($directionAffectation)
    {
        $this->directionAffectation = $directionAffectation;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getMotifRefusEntretien()
    {
        return $this->motifRefusEntretien;
    }

    /**
     * @param $motifRefusEntretien
     *
     * @return CrepScl02
     */
    public function setMotifRefusEntretien($motifRefusEntretien)
    {
        $this->motifRefusEntretien = $motifRefusEntretien;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescriptionFonctions()
    {
        return $this->descriptionFonctions;
    }

    /**
     * @param $descriptionFonctions
     *
     * @return CrepScl02
     */
    public function setDescriptionFonctions($descriptionFonctions)
    {
        $this->descriptionFonctions = $descriptionFonctions;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAcquisExperiencePro()
    {
        return $this->acquisExperiencePro;
    }

    /**
     * @param $acquisExperiencePro
     *
     * @return CrepScl02
     */
    public function setAcquisExperiencePro($acquisExperiencePro)
    {
        $this->acquisExperiencePro = $acquisExperiencePro;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param $rang
     *
     * @return CrepScl02
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEchelonTerminal()
    {
        return $this->echelonTerminal;
    }

    /**
     * @param $echelonTerminal
     *
     * @return CrepScl02
     */
    public function setEchelonTerminal($echelonTerminal)
    {
        $this->echelonTerminal = $echelonTerminal;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTypeEvolutionCarriere()
    {
        return $this->typeEvolutionCarriere;
    }

    /**
     * @param $typeEvolutionCarriere
     *
     * @return CrepScl02
     */
    public function setTypeEvolutionCarriere($typeEvolutionCarriere)
    {
        $this->typeEvolutionCarriere = $typeEvolutionCarriere;
        return $this;
    }

    /**
     * @param $perspectivesEvolutionFonction
     *
     * @return CrepScl02
     */
    public function setPerspectivesEvolutionFonction($perspectivesEvolutionFonction)
    {
        $this->perspectivesEvolutionFonction = $perspectivesEvolutionFonction;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPerspectivesEvolutionFonction()
    {
        return $this->perspectivesEvolutionFonction;
    }

    /**
     *
     * @return string
     */
    public function getTypeMobilite()
    {
        return $this->typeMobilite;
    }

    /**
     * @param $typeMobilite
     *
     * @return CrepScl02
     */
    public function setTypeMobilite($typeMobilite)
    {
        $this->typeMobilite = $typeMobilite;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAutresPointsAbordesShd()
    {
        return $this->autresPointsAbordesShd;
    }

    /**
     * @param $autresPointsAbordesShd
     *
     * @return CrepScl02
     */
    public function setAutresPointsAbordesShd($autresPointsAbordesShd)
    {
        $this->autresPointsAbordesShd = $autresPointsAbordesShd;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAutresPointsAbordesAgent()
    {
        return $this->autresPointsAbordesAgent;
    }

    /**
     * @param $autresPointsAbordesAgent
     *
     * @return CrepScl02
     */
    public function setAutresPointsAbordesAgent($autresPointsAbordesAgent)
    {
        $this->autresPointsAbordesAgent = $autresPointsAbordesAgent;
        return $this;
    }

    /**
     * Add competencesTransverse
     *
     * @param \AppBundle\Entity\Crep\CrepScl02\CrepScl02CompetenceTransverse $competencesTransverse
     *
     * @return CrepScl02
     */
    public function addCompetencesTransverse(\AppBundle\Entity\Crep\CrepScl02\CrepScl02CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepScl02($this);

        return $this;
    }

    /**
     * Remove competencesTransverse
     *
     * @param \AppBundle\Entity\Crep\CrepScl02\CrepScl02CompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(\AppBundle\Entity\Crep\CrepScl02\CrepScl02CompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepScl02(null);
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
     *
     * @return string
     */
    public function getAppreciationLitteraleShd()
    {
        return $this->appreciationLitteraleShd;
    }

    /**
     * @param $appreciationLitteraleShd
     *
     * @return CrepScl02
     */
    public function setAppreciationLitteraleShd($appreciationLitteraleShd)
    {
        $this->appreciationLitteraleShd = $appreciationLitteraleShd;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getQualiteAh()
    {
        return $this->qualiteAh;
    }

    /**
     * @param $qualiteAh
     *
     * @return CrepScl02
     */
    public function setQualiteAh($qualiteAh)
    {
        $this->qualiteAh = $qualiteAh;
        return $this;
    }

    /**
     * Get observationsAgentDeroulementEntretien
     *
     * @return string
     */
    public function getObservationsAgentDeroulementEntretien()
    {
        return $this->observationsAgentDeroulementEntretien;
    }

    /**
     * Set observationsAgentDeroulementEntretien
     *
     * @param string $observationsAgentDeroulementEntretien
     *
     * @return CrepScl02
     */
    public function setObservationsAgentDeroulementEntretien($observationsAgentDeroulementEntretien)
    {
        $this->observationsAgentDeroulementEntretien = $observationsAgentDeroulementEntretien;
        return $this;
    }

    public function actualiserDonneesShd()
    {
    }

    public function confidentialisationChampsShd()
    {
        $this->setRefusEntretienProfessionnel(null);
        $this->setDateEntretien(null);
        $this->setMotifRefusEntretien(null);
        $this->setDescriptionFonctions(null);
        $this->getObjectifsEvalues()->clear();
        $this->getObjectifsFuturs()->clear();
        $this->setAcquisExperiencePro(null);
        $this->getFormationsSuivies()->clear();
        $this->getFormationsDemandeesAgent()->clear();
        $this->setTypeEvolutionCarriere(null);
        $this->setTypeMobilite(null);
        $this->setPerspectivesEvolutionFonction(null);
        $this->setAutresPointsAbordesShd(null);
        $this->setAutresPointsAbordesAgent(null);

        /* @var $transverse CrepScl02CompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }

        $this->setAppreciationLitteraleShd(null);

        $this->setDateVisaShd(null);
        $this->setShdSignataire(null);
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
        $this->setQualiteAh(null);
        $this->setObservationsAh(null);
        $this->setAhSignataire(null);
        $this->setDateVisaAh(null);
    }
}
