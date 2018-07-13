<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Util\Converter;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\EnumTypes\EnumStatutCrep;

/**
 * Crep.
 *
 * @ORM\Table(name="crep", indexes = {  @ORM\Index(columns={"statut"}),
 * 										@ORM\Index(columns={"dtype"})
 * 							}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Crep extends GenericEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visa_shd", type="datetime", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateVisaShd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visa_agent", type="datetime", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateVisaAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_refus_visa", type="datetime", nullable=true)
     */
    protected $dateRefusVisa;

    /**
     * @var string
     *
     * @ORM\Column(name="observations_visa_agent", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsVisaAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visa_ah", type="datetime", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateVisaAh;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_refus_notification", type="datetime", nullable=true)
     */
    protected $dateRefusNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="observations_ah", type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsAh;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_notification", type="datetime", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateNotification;

    /**
     * @var EnumStatutCrep
     *
     * @ORM\Column(name="statut", type="string")
     */
    protected $statut;

//     /**
//      * @var Agent
//      *
//      * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agent")
//      * @ORM\JoinColumn(name="shd_id", nullable=false)
//      */
//     protected $shd;

    /**
     * @var Agent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agent")
     * @ORM\JoinColumn(name="shd_signataire_id", nullable=true)
     */
    protected $shdSignataire;

//     /**
//      * @var Agent
//      *
//      * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agent")
//      * @ORM\JoinColumn(name="ah_id")
//      */
//     protected $ah;

    /**
     * @var Agent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agent")
     * @ORM\JoinColumn(name="ah_signataire_id", nullable=true)
     */
    protected $ahSignataire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entretien", type="date", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateEntretien;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":false})
     *
     */
    protected $refusEntretienProfessionnel = false;

    /**
     * @var Agent
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", nullable=false)
     */
    protected $agent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_renvoi_agent", type="datetime", nullable=true)
     */
    protected $dateRenvoiAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_renvoi_ah", type="datetime", nullable=true)
     */
    protected $dateRenvoiAh;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_renvoi_agent", type="text", nullable=true)
     * @Assert\NotBlank(
     * 		message = "Motif de renvoi au N+1 obligatoire",
     * 		groups = {"renvoiAgent"}
     * )
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Le motif ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifRenvoiAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_renvoi_ah", type="text", nullable=true)
     *
     * @Assert\NotBlank(
     * 		message = "Motif de renvoi au N+1 obligatoire",
     * 		groups = {"renvoiAh"}
     * )
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Le motif ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $motifRenvoiAh;

    /**
     * @var Document
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $crepPdf; // Crep au formatPDF (après signature définitive de l'agent)

    /**
     * @var Document
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\UploadeDocument", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, )
     * @Assert\Valid
     */
    protected $crepPapier;   // Crep au format papier

    /**
     * @var EnumStatutCrep
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $statutCrepAvantImport;

    /**
     * =====================================================================================================
     *                                        Liste des collections de compétences
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="CompetencePoste", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $competencesPostes;

    /**
     * @ORM\OneToMany(targetEntity="CompetenceDeclaree", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $competencesDeclarees;

    /**
     * =====================================================================================================
     *                                        Liste des collections des objectifs
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="ObjectifEvalue", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsEvalues;

    /**
     * @ORM\OneToMany(targetEntity="ObjectifFutur", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $objectifsFuturs;

    /**
     * =====================================================================================================
     *                                        Liste des collections formations
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="FormationSuivie", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $formationsSuivies;
    
    /**
     * @ORM\OneToMany(targetEntity="FormationDispensee", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsDispensees;
    
    /**
     * @ORM\OneToMany(targetEntity="FormationAVenir", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsAVenir;

    /**
     * @ORM\OneToMany(targetEntity="FormationDemandeeAdministration", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsDemandeesAdministration;

    /**
     * @ORM\OneToMany(targetEntity="FormationReglementaire", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsReglementaires;

    /**
     * @ORM\OneToMany(targetEntity="FormationDemandeeEmployeur", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsDemandeesEmployeur;

    /**
     * @ORM\OneToMany(targetEntity="FormationDemandeeAgent", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $formationsDemandeesAgent;

    /**
     * =====================================================================================================
     *                                   Liste des collections des souhaits
     * ======================================================================================================.
     */

    /**
//      * @ORM\OneToOne(targetEntity="MobiliteFonctionnelle", inversedBy="crep", cascade={"persist"},orphanRemoval=true)
     * @Assert\Valid
     */
    protected $mobiliteFonctionnelle;

    /**
     * @ORM\OneToOne(targetEntity="MobiliteGeographique", inversedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $mobiliteGeographique;

    /**
     * @ORM\OneToOne(targetEntity="MobiliteExterne", inversedBy="crep",  orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $mobiliteExterne;

    /**
     * @ORM\OneToOne(targetEntity="MotivationsMobilite", inversedBy="crep",  orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $motivationsMobilite;

    /**
     * =====================================================================================================
     *                                   Liste des collections des emplois
     * ======================================================================================================.
     */

    /**
     * @ORM\OneToMany(targetEntity="Emploi", mappedBy="crep", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $emplois;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notif_absence_visa_agent", type="boolean", options={"default":false})
     */
    protected $notificationAbsenceVisaAgent = false;

    /**
     * @var ModeleCrep
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ModeleCrep")
     */
    protected $modeleCrep;

    /**
     * @ORM\OneToMany(targetEntity="Recours", mappedBy="crep", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $recours;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Date(message = "Date non valide")
     */
    protected $dateConsultationAgent;

    abstract public function initialiser(Agent $agent, $em);

    /**
     * Méthode appelée lors d'un rattachement d'un nouveau N+1.
     */
    abstract public function actualiserDonneesShd();

    protected function initialiserParent(Agent $agent, $em)
    {
        $this->setAgent($agent);
        $this->setStatut(EnumStatutCrep::CREE);
    }

    /**
     * Constructor.
     */
    protected function init()
    {
        $this->competencesPostes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencesDeclarees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsEvalues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifsFuturs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsSuivies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsDispensees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsAVenir = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsDemandeesAdministration = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsReglementaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsDemandeesEmployeur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formationsDemandeesAgent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emplois = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set dateVisaShd
     *
     * @param \DateTime $dateVisaShd
     *
     * @return Crep
     */
    public function setDateVisaShd($dateVisaShd)
    {
        $this->dateVisaShd = $dateVisaShd;

        return $this;
    }

    /**
     * Get dateVisaShd
     *
     * @return \DateTime
     */
    public function getDateVisaShd()
    {
        return $this->dateVisaShd;
    }

    /**
     * Set dateVisaAgent
     *
     * @param \DateTime $dateVisaAgent
     *
     * @return Crep
     */
    public function setDateVisaAgent($dateVisaAgent)
    {
        $this->dateVisaAgent = $dateVisaAgent;

        return $this;
    }

    /**
     * Get dateVisaAgent
     *
     * @return \DateTime
     */
    public function getDateVisaAgent()
    {
        return $this->dateVisaAgent;
    }

    /**
     * Set observationsVisaAgent
     *
     * @param string $observationsVisaAgent
     *
     * @return Crep
     */
    public function setObservationsVisaAgent($observationsVisaAgent)
    {
        $this->observationsVisaAgent = $observationsVisaAgent;

        return $this;
    }

    /**
     * Get observationsVisaAgent
     *
     * @return string
     */
    public function getObservationsVisaAgent()
    {
        return $this->observationsVisaAgent;
    }

    /**
     * Set dateVisaAh
     *
     * @param \DateTime $dateVisaAh
     *
     * @return Crep
     */
    public function setDateVisaAh($dateVisaAh)
    {
        $this->dateVisaAh = $dateVisaAh;

        return $this;
    }

    /**
     * Get dateVisaAh
     *
     * @return \DateTime
     */
    public function getDateVisaAh()
    {
        return $this->dateVisaAh;
    }

    /**
     * Set observationsAh
     *
     * @param string $observationsAh
     *
     * @return Crep
     */
    public function setObservationsAh($observationsAh)
    {
        $this->observationsAh = $observationsAh;

        return $this;
    }

    /**
     * Get observationsAh
     *
     * @return string
     */
    public function getObservationsAh()
    {
        return $this->observationsAh;
    }

    /**
     * Set dateNotification
     *
     * @param \DateTime $dateNotification
     *
     * @return Crep
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;

        return $this;
    }

    /**
     * Get dateNotification
     *
     * @return \DateTime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }

    /**
     * Set statut
     *
     * @param enum_statut_crep $statut
     *
     * @return Crep
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return enum_statut_crep
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set dateEntretien
     *
     * @param \DateTime $dateEntretien
     *
     * @return Crep
     */
    public function setDateEntretien($dateEntretien)
    {
        $this->dateEntretien = $dateEntretien;

        return $this;
    }

    /**
     * Get dateEntretien
     *
     * @return \DateTime
     */
    public function getDateEntretien()
    {
        return $this->dateEntretien;
    }


    /**
     * Get shd
     *
     * @return \AppBundle\Entity\Agent
     */
    public function getShd()
    {
        return $this->getAgent()->getShd();
    }


    /**
     * Get ah
     *
     * @return \AppBundle\Entity\Agent
     */
    public function getAh()
    {
        return $this->getAgent()->getAh();
    }

    /**
     * Set agent
     *
     * @param \AppBundle\Entity\Agent $agent
     *
     * @return Crep
     */
    public function setAgent(\AppBundle\Entity\Agent $agent)
    {
        $this->agent = $agent;
        
        $agent->setCrep($this);

        return $this;
    }

    /**
     * Get agent
     *
     * @return \AppBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Add competencePoste
     *
     * @param \AppBundle\Entity\CompetencePoste $competencesPoste
     *
     * @return Crep
     */
    public function addCompetencesPoste(\AppBundle\Entity\CompetencePoste $competencePoste)
    {
        $this->competencesPostes[] = $competencePoste;
        $competencePoste->setCrep($this);

        return $this;
    }

    /**
     * Remove competencePoste
     *
     * @param \AppBundle\Entity\CompetencePoste $competencePoste
     */
    public function removeCompetencesPoste(\AppBundle\Entity\CompetencePoste $competencePoste)
    {
        $this->competencesPostes->removeElement($competencePoste);
        $competencePoste->setCrep(null);
    }

    /**
     * Get competencesPostes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesPostes()
    {
        return $this->competencesPostes;
    }

    /**
     * Add competenceDeclaree
     *
     * @param \AppBundle\Entity\CompetenceDeclaree $competenceDeclaree
     *
     * @return Crep
     */
    public function addCompetencesDeclaree(\AppBundle\Entity\CompetenceDeclaree $competenceDeclaree)
    {
        $this->competencesDeclarees[] = $competenceDeclaree;
        $competenceDeclaree->setCrep($this);

        return $this;
    }

    /**
     * Remove competencesDeclaree
     *
     * @param \AppBundle\Entity\CompetenceDeclaree $competencesDeclaree
     */
    public function removeCompetencesDeclaree(\AppBundle\Entity\CompetenceDeclaree $competencesDeclaree)
    {
        $this->competencesDeclarees->removeElement($competencesDeclaree);
        $competencesDeclaree->setCrep(null);
    }

    /**
     * Get competencesDeclarees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesDeclarees()
    {
        return $this->competencesDeclarees;
    }

    /**
     * Add objectifsEvalue
     *
     * @param \AppBundle\Entity\ObjectifEvalue $objectifsEvalue
     *
     * @return Crep
     */
    public function addObjectifsEvalue(\AppBundle\Entity\ObjectifEvalue $objectifsEvalue)
    {
        $this->objectifsEvalues[] = $objectifsEvalue;
        $objectifsEvalue->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsEvalue
     *
     * @param \AppBundle\Entity\ObjectifEvalue $objectifsEvalue
     */
    public function removeObjectifsEvalue(\AppBundle\Entity\ObjectifEvalue $objectifsEvalue)
    {
        $this->objectifsEvalues->removeElement($objectifsEvalue);
        $objectifsEvalue->setCrep(null);
    }

    /**
     * Get objectifsEvalues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsEvalues()
    {
        return $this->objectifsEvalues;
    }
    
   
    /**
     * Add objectifsFutur
     *
     * @param \AppBundle\Entity\ObjectifFutur $objectifsFutur
     *
     * @return Crep
     */
    public function addObjectifsFutur(\AppBundle\Entity\ObjectifFutur $objectifsFutur)
    {
        $this->objectifsFuturs[] = $objectifsFutur;
        $objectifsFutur->setCrep($this);

        return $this;
    }

    /**
     * Remove objectifsFutur
     *
     * @param \AppBundle\Entity\ObjectifFutur $objectifsFutur
     */
    public function removeObjectifsFutur(\AppBundle\Entity\ObjectifFutur $objectifsFutur)
    {
        $this->objectifsFuturs->removeElement($objectifsFutur);
        $objectifsFutur->setCrep(null);
    }

    /**
     * Get objectifsFuturs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifsFuturs()
    {
        return $this->objectifsFuturs;
    }
    
   
    
    /**
     * Add formationsSuivy
     *
     * @param \AppBundle\Entity\FormationSuivie $formationsSuivy
     *
     * @return Crep
     */
    public function addFormationsSuivy(\AppBundle\Entity\FormationSuivie $formationsSuivy)
    {
        $this->formationsSuivies[] = $formationsSuivy;
        $formationsSuivy->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsSuivy
     *
     * @param \AppBundle\Entity\FormationSuivie $formationsSuivy
     */
    public function removeFormationsSuivy(\AppBundle\Entity\FormationSuivie $formationsSuivy)
    {
        $this->formationsSuivies->removeElement($formationsSuivy);
        $formationsSuivy->setCrep(null);
    }

    /**
     * Get formationsSuivies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsSuivies()
    {
        return $this->formationsSuivies;
    }
    
    /**
     * Add formationsDispensee
     *
     * @param \AppBundle\Entity\FormationDispensee $formationsDispensee
     *
     * @return Crep
     */
    public function addFormationsDispensee(\AppBundle\Entity\FormationDispensee $formationDispensee)
    {
        $this->formationsDispensees[] = $formationDispensee;
        $formationDispensee->setCrep($this);
    
        return $this;
    }
    
    /**
     * Remove formationsDispensee
     *
     * @param \AppBundle\Entity\FormationDispensee $formationsDispensee
     */
    public function removeFormationsDispensee(\AppBundle\Entity\FormationDispensee $formationDispensee)
    {
        $this->formationsDispensees->removeElement($formationDispensee);
        $formationDispensee->setCrep(null);
    }
    
    /**
     * Get formationsDispensees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsDispensees()
    {
        return $this->formationsDispensees;
    }
    
    /**
     * Add formationsAVenir
     *
     * @param \AppBundle\Entity\FormationAVenir $formationsAVenir
     *
     * @return Crep
     */
    public function addFormationsAVenir(\AppBundle\Entity\FormationAVenir $formationsAVenir)
    {
        $this->formationsAVenir[] = $formationsAVenir;
        $formationsAVenir->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsAVenir
     *
     * @param \AppBundle\Entity\FormationAVenir $formationsAVenir
     */
    public function removeFormationsAVenir(\AppBundle\Entity\FormationAVenir $formationsAVenir)
    {
        $this->formationsAVenir->removeElement($formationsAVenir);
        $formationsAVenir->setCrep(null);
    }

    /**
     * Get formationsAVenir
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsAVenir()
    {
        return $this->formationsAVenir;
    }

//    /**
//     * @param FormationFuture $formation
//     * @return $this
//     */
//    public function addFormationsFuture(FormationFuture $formation)
//    {
//        $this->formationsFutures[] = $formation;
//        $formation->setCrep($this);
//
//        return $this;
//    }
//
//    /**
//     * @param FormationFuture $formation
//     */
//    public function removeFormationsFuture(FormationFuture $formation)
//    {
//        $this->formationsFutures->removeElement($formation);
//        $formation->setCrep(null);
//    }
//
//    /**
//     * Get formationsFutures
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getFormationsFutures()
//    {
//        return $this->formationsFutures;
//    }

    /**
     * Add formationsDemandeesAdministration
     *
     * @param \AppBundle\Entity\FormationDemandeeAdministration $formationsDemandeesAdministration
     *
     * @return Crep
     */
    public function addFormationsDemandeesAdministration(\AppBundle\Entity\FormationDemandeeAdministration $formationsDemandeesAdministration)
    {
        $this->formationsDemandeesAdministration[] = $formationsDemandeesAdministration;
        $formationsDemandeesAdministration->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsDemandeesAdministration
     *
     * @param \AppBundle\Entity\FormationDemandeeAdministration $formationsDemandeesAdministration
     */
    public function removeFormationsDemandeesAdministration(\AppBundle\Entity\FormationDemandeeAdministration $formationsDemandeesAdministration)
    {
        $this->formationsDemandeesAdministration->removeElement($formationsDemandeesAdministration);
        $formationsDemandeesAdministration->setCrep(null);
    }

    /**
     * Get formationsDemandeesAdministration
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsDemandeesAdministration()
    {
        return $this->formationsDemandeesAdministration;
    }
    
    
    /**
     * Add formationsReglementaire
     *
     * @param \AppBundle\Entity\FormationReglementaire $formationsReglementaire
     *
     * @return Crep
     */
    public function addFormationsReglementaire(\AppBundle\Entity\FormationReglementaire $formationsReglementaire)
    {
        $this->formationsReglementaires[] = $formationsReglementaire;
        $formationsReglementaire->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsReglementaire
     *
     * @param \AppBundle\Entity\FormationReglementaire $formationsReglementaire
     */
    public function removeFormationsReglementaire(\AppBundle\Entity\FormationReglementaire $formationsReglementaire)
    {
        $this->formationsReglementaires->removeElement($formationsReglementaire);
        $formationsReglementaire->setCrep(null);
    }

    /**
     * Get formationsReglementaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsReglementaires()
    {
        return $this->formationsReglementaires;
    }
	

    /**
     * Add formationsDemandeesEmployeur
     *
     * @param \AppBundle\Entity\FormationDemandeeEmployeur $formationsDemandeesEmployeur
     *
     * @return Crep
     */
    public function addFormationsDemandeesEmployeur(\AppBundle\Entity\FormationDemandeeEmployeur $formationsDemandeesEmployeur)
    {
        $this->formationsDemandeesEmployeur[] = $formationsDemandeesEmployeur;
        $formationsDemandeesEmployeur->setCrep($this);
    
        return $this;
    }
    
    /**
     * Remove formationsDemandeesEmployeur
     *
     * @param \AppBundle\Entity\FormationDemandeeEmployeur $formationsDemandeesEmployeur
     */
    public function removeFormationsDemandeesEmployeur(\AppBundle\Entity\FormationDemandeeEmployeur $formationsDemandeesEmployeur)
    {
        $this->formationsDemandeesEmployeur->removeElement($formationsDemandeesEmployeur);
        $formationsDemandeesEmployeur->setCrep(null);
    }
    
    /**
     * Get formationsDemandeesEmployeur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsDemandeesEmployeur()
    {
        return $this->formationsDemandeesEmployeur;
    }
    
    /**
     * Add formationsDemandeesAgent
     *
     * @param \AppBundle\Entity\FormationDemandeeAgent $formationsDemandeesAgent
     *
     * @return Crep
     */
    public function addFormationsDemandeesAgent(\AppBundle\Entity\FormationDemandeeAgent $formationsDemandeesAgent)
    {
        $this->formationsDemandeesAgent[] = $formationsDemandeesAgent;
        $formationsDemandeesAgent->setCrep($this);

        return $this;
    }

    /**
     * Remove formationsDemandeesAgent
     *
     * @param \AppBundle\Entity\FormationDemandeeAgent $formationsDemandeesAgent
     */
    public function removeFormationsDemandeesAgent(\AppBundle\Entity\FormationDemandeeAgent $formationsDemandeesAgent)
    {
        $this->formationsDemandeesAgent->removeElement($formationsDemandeesAgent);
        $formationsDemandeesAgent->setCrep(null);
    }

    /**
     * Get formationsDemandeesAgent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormationsDemandeesAgent()
    {
        return $this->formationsDemandeesAgent;
    }

    /**
     * Set mobiliteFonctionnelle
     *
     * @param \AppBundle\Entity\MobiliteFonctionnelle $mobiliteFonctionnelle
     *
     * @return Crep
     */
    public function setMobiliteFonctionnelle(\AppBundle\Entity\MobiliteFonctionnelle $mobiliteFonctionnelle = null)
    {
        $this->mobiliteFonctionnelle = $mobiliteFonctionnelle;

        return $this;
    }

    /**
     * Get mobiliteFonctionnelle
     *
     * @return \AppBundle\Entity\MobiliteFonctionnelle
     */
    public function getMobiliteFonctionnelle()
    {
        return $this->mobiliteFonctionnelle;
    }

    /**
     * Set mobiliteGeographique
     *
     * @param \AppBundle\Entity\MobiliteGeographique $mobiliteGeographique
     *
     * @return Crep
     */
    public function setMobiliteGeographique(\AppBundle\Entity\MobiliteGeographique $mobiliteGeographique = null)
    {
        $this->mobiliteGeographique = $mobiliteGeographique;

        return $this;
    }

    /**
     * Get mobiliteGeographique
     *
     * @return \AppBundle\Entity\MobiliteGeographique
     */
    public function getMobiliteGeographique()
    {
        return $this->mobiliteGeographique;
    }

    /**
     * Set mobiliteExterne
     *
     * @param \AppBundle\Entity\MobiliteExterne $mobiliteExterne
     *
     * @return Crep
     */
    public function setMobiliteExterne(\AppBundle\Entity\MobiliteExterne $mobiliteExterne = null)
    {
        $this->mobiliteExterne = $mobiliteExterne;

        return $this;
    }

    /**
     * Get mobiliteExterne
     *
     * @return \AppBundle\Entity\MobiliteExterne
     */
    public function getMobiliteExterne()
    {
        return $this->mobiliteExterne;
    }

    /**
     * Add emploi
     *
     * @param \AppBundle\Entity\Emploi $emploi
     *
     * @return Crep
     */
    public function addEmplois(\AppBundle\Entity\Emploi $emploi)
    {
        $this->emplois[] = $emploi;
        $emploi->setCrep($this);

        return $this;
    }

    /**
     * Remove emplois
     *
     * @param \AppBundle\Entity\Emploi $emplois
     */
    public function removeEmplois(\AppBundle\Entity\Emploi $emplois)
    {
        $this->emplois->removeElement($emplois);
        $emplois->setCrep(null);
    }

    /**
     * Get emplois
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplois()
    {
        return $this->emplois;
    }


    public function getDateRefusVisa()
    {
        return $this->dateRefusVisa;
    }

    public function setDateRefusVisa($dateRefusVisa)
    {
        $this->dateRefusVisa = $dateRefusVisa;
        
        return $this;
    }
    
    public function getDateRefusNotification()
    {
        return $this->dateRefusNotification;
    }

    public function setDateRefusNotification($dateRefusNotification)
    {
        $this->dateRefusNotification = $dateRefusNotification;
        
        return $this;
    }
     
    public function getDateRenvoiAgent()
    {
        return $this->dateRenvoiAgent;
    }

    public function setDateRenvoiAgent($dateRenvoiAgent)
    {
        $this->dateRenvoiAgent = $dateRenvoiAgent;
        return $this;
    }
    
    public function getDateRenvoiAh()
    {
        return $this->dateRenvoiAh;
    }
    
    public function setDateRenvoiAh($dateRenvoiAh)
    {
        $this->dateRenvoiAh = $dateRenvoiAh;
        return $this;
    }
    
    public function getMotifRenvoiAgent()
    {
        return $this->motifRenvoiAgent;
    }
    
    public function setMotifRenvoiAgent($motifRenvoiAgent)
    {
        $this->motifRenvoiAgent = $motifRenvoiAgent;
    
        return $this;
    }
    
    public function getMotifRenvoiAh()
    {
        return $this->motifRenvoiAh;
    }
    
    public function setMotifRenvoiAh($motifRenvoiAh)
    {
        $this->motifRenvoiAh = $motifRenvoiAh;
    
        return $this;
    }
    
    public function getShdSignataire ()
    {
    	return $this->shdSignataire;
    }
    
    public function setShdSignataire ($agent)
    {
    	$this->shdSignataire = $agent;
    	
    	return $this;
    }
    
    public function getAhSignataire ()
    {
    	return $this->ahSignataire;
    }
    
    public function setAhSignataire ($agent)
    {
    	$this->ahSignataire = $agent;
    	 
    	return $this;
    }
    
    public function getRefusEntretienProfessionnel()
    {
        return $this->refusEntretienProfessionnel;
    }
    
    public function setRefusEntretienProfessionnel($refusEntretienProfessionnel)
    {
        $this->refusEntretienProfessionnel = $refusEntretienProfessionnel;
        return $this;
    }
 
    public function getNotificationAbsenceVisaAgent()
    {
    	return $this->notificationAbsenceVisaAgent;
    }
    
    public function setNotificationAbsenceVisaAgent($notificationAbsenceVisaAgent)
    {
    	$this->notificationAbsenceVisaAgent = $notificationAbsenceVisaAgent;
    	return $this;
    }

    

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    { 
    	/*  *****   VALIDATION: FormationDemandeeEmployeur   ***** */
    	/* @var $formationDemandeeEmployeur FormationDemandeeEmployeur  */
    	foreach ($this->formationsDemandeesEmployeur as $formationDemandeeEmployeur) {
    		if (!$formationDemandeeEmployeur->getLibelle()) {
    			$this->removeFormationsDemandeesEmployeur($formationDemandeeEmployeur);
    		}
    	}
    	 
    	 
    	/*  *****   VALIDATION: FormationDispensee   ***** */
    	/* @var $formationDispensee FormationDispensee  */
    	foreach ($this->formationsDispensees as $formationDispensee) {
    		if (!$formationDispensee->getLibelle()) {
    			$this->removeFormationsDispensee($formationDispensee);
    		}
    	}
    	
    	
    	//On vérifie que le mimeType du file est bien un pdf et qu'il n'exede pas 5Mo
    	if ($this->getCrepPapier() && $this->getCrepPapier()->getFile() && ($this->getCrepPapier()->getFile()->getMimeType() != "application/pdf" || $this->getCrepPapier()->getFile()->getSize() >= 5000000))
    		$context->buildViolation("Merci d'importer un fichier pdf valide qui n'exède pas 5Mo")
    		->atPath('crepPapier')
    		->addViolation();
    	 
    	if ($this->getCrepPapier() && $this->getCrepPapier()->getFile() && !$this->getStatutCrepAvantImport()) {
    		$context->buildViolation("Merci d'indiquer le statut du CREP importé")
    		->atPath('statutCrepAvantImport')
    		->addViolation();
    	}
    	
    	// La date d'entretien doit être postérieure à la date des début des entretiens de la campagne
    	if($this->dateEntretien && $this->dateEntretien < $this->getAgent()->getCampagnePnc()->getDateDebutEntretien()){
    		$context->buildViolation("La date d'entretien doit être postérieure ou égale au ".$this->getAgent()->getCampagnePnc()->getDateDebutEntretien()->format("d/m/Y"))
    		->atPath('dateEntretien')
    		->addViolation();
    	}
    	
    	// La date d'entretien doit être antérieure à la date de fin de la campagne
    	if($this->dateEntretien && $this->dateEntretien > $this->getAgent()->getCampagnePnc()->getDateCloture()){
    		$context->buildViolation("La date d'entretien doit être antérieure ou égale au ".$this->getAgent()->getCampagnePnc()->getDateCloture()->format("d/m/Y"))
    		->atPath('dateEntretien')
    		->addViolation();
    	}
    	
        
    }

    public function getModeleCrep()
    {
        return $this->modeleCrep;
    }

    public function setModeleCrep(ModeleCrep $modeleCrep)
    {
        $this->modeleCrep = $modeleCrep;
        return $this;
    }
    
    /**
     * Set crepPdf
     *
     * @param \AppBundle\Entity\Document $crepPdf
     *
     * @return Crep
     */
    public function setCrepPdf(\AppBundle\Entity\Document $crepPdf = null)
    {
    	$this->crepPdf = $crepPdf;
    
    	return $this;
    }
    
    /**
     * Get crepPdf
     *
     * @return \AppBundle\Entity\Document
     */
    public function getCrepPdf()
    {
    	return $this->crepPdf;
    }
    
    //Fonction qui définit le nom par défaut du CREP pdf (nom_prenom_CREP_anneeEvaluation.pdf)
    // ... à redefinir dans chaque entité fille si règle de nommage spécifique !
    public function getPdfFileName()
    {
        return $this->agent->getPdfFileName();
    }
    
    //Fonctions de confidentialisation d'un CREP
    abstract public function confidentialisationChampsShd ();
    abstract public function confidentialisationChampsAgent ();
    abstract public function confidentialisationChampsAgentAvantNotification ();
    abstract public function confidentialisationChampsAh ();
	public function getMotivationsMobilite() {
		return $this->motivationsMobilite;
	}
	public function setMotivationsMobilite($motivationsMobilite) {
		$this->motivationsMobilite = $motivationsMobilite;
		return $this;
	}
	public function getCrepPapier() {
		return $this->crepPapier;
	}
	public function setCrepPapier(Document $crepPapier = null) {
		$this->crepPapier = $crepPapier;
		return $this;
	}
	public function getStatutCrepAvantImport() {
		return $this->statutCrepAvantImport;
	}
	public function setStatutCrepAvantImport($statutCrepAvantImport = null) {
		$this->statutCrepAvantImport = $statutCrepAvantImport;
		return $this;
	}
	
	
	/**
	 * Add recours
	 *
	 * @param \AppBundle\Entity\Recours $recours
	 *
	 * @return Crep
	 */
	public function addRecours(\AppBundle\Entity\Recours $recours)
	{
		$this->recours[] = $recours;
		$recours->setCrep($this);
	
		return $this;
	}
	
	/**
	 * Remove recours
	 *
	 * @param \AppBundle\Entity\Recours $recours
	 */
	public function removeRecours(\AppBundle\Entity\Recours $recours)
	{
		$this->recours->removeElement($recours);
		$recours->setCrep(null);
	}
	
	/**
	 * Get recours
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getRecours()
	{
		return $this->recours;
	}
	
	/**
	 * Retourne TRUE si le Crep contient des recours toujours en cours FALSE sinon
	 *
	 * @return boolean
	 */
	public function contientRecoursEnCours(){

		/* @var $recours Recours */
		foreach ($this->recours as $recours){
			if(!$recours->getDecisionPriseEnCompte())
				return true;
		}
		
		return false;
	}
 
	
	/**
	 * Get dateConsultationAgent
	 *
	 * @return \DateTime
	 */
	public function getDateConsultationAgent()
	{
		return $this->dateConsultationAgent;
	}
	
	/**
	 * Set dateConsultationAgent
	 *
	 * @param \DateTime $dateConsultationAgent
	 *
	 * @return Crep
	 */
	public function setDateConsultationAgent($dateConsultationAgent)
	{
		$this->dateConsultationAgent = $dateConsultationAgent;
	
		return $this;
	}
	

}

