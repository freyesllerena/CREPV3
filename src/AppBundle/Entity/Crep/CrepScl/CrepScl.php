<?php

namespace AppBundle\Entity\Crep\CrepScl;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Agent;

/**
 * CrepScl.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepSclRepository")
 */
class CrepScl extends Crep
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
     * @ORM\Column(type="string")
     */
    protected $directionAffectation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $rang;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $echelonTerminal = false;

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
    protected $typeEvolutionCarriere;

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
     * @ORM\OneToMany(targetEntity="CrepSclCompetenceTransverse", mappedBy="crepScl", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $competencesTransverses;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $typeCadenceAvancement;

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
    protected $mentionAlerte;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $qualiteAh;

    public function __construct()
    {
        parent::init();
        $this->competencesTransverses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $this->addCompetencesTransverse(new CrepSclCompetenceTransverse("Connaissances professionnelles dans l'emploi occupé", 'Générale'));
        $this->addCompetencesTransverse(new CrepSclCompetenceTransverse('Compétences personnelles', 'Générale'));
        $this->addCompetencesTransverse(new CrepSclCompetenceTransverse('Sens du service public', 'Générale'));
        $this->addCompetencesTransverse(new CrepSclCompetenceTransverse('Capacité à organiser et animer une équipe', 'Encadrement'));
        $this->addCompetencesTransverse(new CrepSclCompetenceTransverse('Capacité à définir et à évaluer des objectifs', 'Encadrement'));

        /* @var $crep CrepScl */
        $this->setNomUsage($agent->getNom());
        $this->setPrenom($agent->getPrenom());
        $this->setDateNaissance($agent->getDateNaissance());
        $this->setGrade($agent->getGrade());
        $this->setEchelon($agent->getEchelon());
        $this->setDirectionAffectation($agent->getAffectation());
        $this->setDescriptionFonctions($agent->getPosteOccupe());
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
     * Add competencesTransverse.
     *
     * @param \AppBundle\Entity\Crep\CrepScl\CrepSclCompetenceTransverse $competencesTransverse
     *
     * @return CrepScl
     */
    public function addCompetencesTransverse(\AppBundle\Entity\Crep\CrepScl\CrepSclCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses[] = $competencesTransverse;
        $competencesTransverse->setCrepScl($this);

        return $this;
    }

    /**
     * Remove competencesTransverse.
     *
     * @param \AppBundle\Entity\Crep\CrepScl\CrepSclCompetenceTransverse $competencesTransverse
     */
    public function removeCompetencesTransverse(\AppBundle\Entity\Crep\CrepScl\CrepSclCompetenceTransverse $competencesTransverse)
    {
        $this->competencesTransverses->removeElement($competencesTransverse);
        $competencesTransverse->setCrepScl(null);
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
        $this->getObjectifsEvalues()->clear();
        $this->getObjectifsFuturs()->clear();
        $this->setAcquisExperiencePro(null);
        $this->getFormationsSuivies()->clear();
        $this->getFormationsDemandeesAgent()->clear();
        $this->setTypeEvolutionCarriere(null);
        $this->setTypeMobilite(null);
        $this->setAutresPointsAbordesShd(null);
        $this->setAutresPointsAbordesAgent(null);
        /* @var $transverse CrepSclCompetenceTransverse */
        foreach ($this->getCompetencesTransverses() as $transverse) {
            $transverse->setNiveauAcquis(null);
        }
        $this->setAppreciationLitteraleShd(null);
        $this->setTypeCadenceAvancement(null);
        $this->setMentionAlerte(null);

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
    }

    public function actualiserDonneesShd()
    {
        // Ce modèle de CREP ne contient pas de champs liés au N+1
    }

    public function getRang()
    {
        return $this->rang;
    }

    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    public function getEchelonTerminal()
    {
        return $this->echelonTerminal;
    }

    public function setEchelonTerminal($echelonTerminal)
    {
        $this->echelonTerminal = $echelonTerminal;

        return $this;
    }

    public function getMentionAlerte()
    {
        return $this->mentionAlerte;
    }

    public function setMentionAlerte($mentionAlerte)
    {
        $this->mentionAlerte = $mentionAlerte;

        return $this;
    }
}
