<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CampagnePnc.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampagnePncRepository")
 * @UniqueEntity(fields={"libelle", "ministere", "anneeEvaluee"}, errorPath="libelle", message="Ce libellé existe déjà en base")
 */
class CampagnePnc extends Campagne
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\GreaterThanOrEqual("today", message = "La date de début des entretiens ne peut être antérieure à la date du jour", groups={"creation"})
     */
    protected $dateDebutEntretien;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCloture", type="datetime", nullable=true)
     */
    protected $dateCloture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\GreaterThanOrEqual("today", message = "La date de début de la campagne ne peut être antérieure à la date du jour" , groups={"creation"})
     */
    protected $dateDebut;

    /**
     * @var Ministere
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ministere;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFermeture;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Champ obligatoire")
     * @Assert\Range(
     *      min = 2000,
     *      max = 2050,
     *      minMessage = "Valeur non valide.",
     *      maxMessage = "Valeur non valide."
     *
     * )
     */
    private $anneeEvaluee;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerimetreRlc", inversedBy="campagnesPnc")
     * @ORM\JoinTable(name="campagne_pnc_perimetres_rlc")
     * @ORM\OrderBy({"libelle" = "ASC"})
     * @Assert\Count(min = "1", minMessage  = "Périmètre obligatoire")
     */
    private $perimetresRlc;

    /**
     * @ORM\ManyToMany(targetEntity="Document", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({"nom" = "ASC"})
     * @Assert\Valid
     */
    private $documents;

    /**
     * @var Agent
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Agent", mappedBy="campagnePnc")
     * @ORM\OrderBy({"email" = "ASC"})
     */
    private $agents;

    /**
     * @var Document
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Document")
     * @ORM\JoinColumn(nullable=true)
     */
    private $docPopulation;

    /**
     * @var bool
     *
     *  @ORM\Column(type="boolean")
     */
    private $diffusee = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->perimetresRlc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * Add perimetreRlc.
     *
     * @param \AppBundle\Entity\PerimetreRlc $perimetreRlc
     *
     * @return Rlc
     */
    public function addPerimetresRlc(\AppBundle\Entity\PerimetreRlc $perimetreRlc)
    {
        $this->perimetresRlc[] = $perimetreRlc;
        $perimetreRlc->addCampagnePnc($this);

        return $this;
    }

    /**
     * Remove perimetreRlc.
     *
     * @param \AppBundle\Entity\PerimetreRlc $perimetreRlc
     */
    public function removePerimetresRlc(\AppBundle\Entity\PerimetreRlc $perimetreRlc)
    {
        $this->perimetresRlc->removeElement($perimetreRlc);
    }

    /**
     * Get perimetresRlc.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerimetresRlc()
    {
        return $this->perimetresRlc;
    }

    /**
     * Set ministere.
     *
     * @param Ministere $ministere
     *
     * @return Utilisateur
     */
    public function setMinistere(Ministere $ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return Ministere
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set anneeEvaluee.
     *
     * @param int $anneeEvaluee
     *
     * @return CampagnePnc
     */
    public function setAnneeEvaluee($anneeEvaluee)
    {
        $this->anneeEvaluee = $anneeEvaluee;

        return $this;
    }

    /**
     * Get anneeEvaluee.
     *
     * @return int
     */
    public function getAnneeEvaluee()
    {
        return $this->anneeEvaluee;
    }

    /**
     * Add document.
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return CampagnePnc
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
     * Set dateFermeture.
     *
     * @param \DateTime $dateFermeture
     *
     * @return CampagnePnc
     */
    public function setDateFermeture($dateFermeture)
    {
        $this->dateFermeture = $dateFermeture;

        return $this;
    }

    /**
     * Get dateFermeture.
     *
     * @return \DateTime
     */
    public function getDateFermeture()
    {
        return $this->dateFermeture;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return CampagnePnc
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set dateDebutEntretien.
     *
     * @param \DateTime $dateDebutEntretien
     *
     * @return CampagnePnc
     */
    public function setDateDebutEntretien($dateDebutEntretien)
    {
        $this->dateDebutEntretien = $dateDebutEntretien;

        return $this;
    }

    /**
     * Get dateDebutEntretien.
     *
     * @return \DateTime
     */
    public function getDateDebutEntretien()
    {
        return $this->dateDebutEntretien;
    }

    /**
     * Add agent.
     *
     * @param \AppBundle\Entity\Agent $agent
     *
     * @return CampagnePnc
     */
    public function addAgent(\AppBundle\Entity\Agent $agent)
    {
        $this->agents[] = $agent;
        $agent->setCampagnePnc($this);

        return $this;
    }

    /**
     * Remove agent.
     *
     * @param \AppBundle\Entity\Agent $agent
     */
    public function removeAgent(\AppBundle\Entity\Agent $agent)
    {
        $this->agents->removeElement($agent);
        $agent->setCampagnePnc(null);
    }

    /**
     * Get agents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAgents()
    {
        return $this->agents;
    }

    /**
     * Set docPopulation.
     *
     * @param \AppBundle\Entity\Document $docPopulation
     *
     * @return CampagnePnc
     */
    public function setDocPopulation(\AppBundle\Entity\Document $docPopulation = null)
    {
        $this->docPopulation = $docPopulation;

        return $this;
    }

    /**
     * Get docPopulation.
     *
     * @return \AppBundle\Entity\Document
     */
    public function getDocPopulation()
    {
        return $this->docPopulation;
    }

    public function getDiffusee()
    {
        return $this->diffusee;
    }

    public function setDiffusee($diffusee)
    {
        $this->diffusee = $diffusee;

        return $this;
    }

    /**
     * Set dateCloture.
     *
     * @param \DateTime $dateCloture
     *
     * @return CampagnePnc
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * Get dateCloture.
     *
     * @return \DateTime
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * Set dateDebut.
     *
     * @param \DateTime $dateDebut
     *
     * @return CampagnePnc
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut.
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        // Vérification que les périmètres RLC ne sont pas vides

        /* @var $perimetreRlc PerimetreRlc */
        foreach ($this->getPerimetresRlc() as $perimetreRlc) {
            if (0 === count($perimetreRlc->getRlcs())) {
                $context
                    ->buildViolation("Aucun RLC n'est associé au périmètre ".$perimetreRlc->getLibelle())
                    ->atPath('perimetresRlc')
                    ->addViolation()
                ;
            }
        }

        if ($this->dateCloture && $this->dateDebut && $this->dateDebut >= $this->dateCloture) {
            $context->buildViolation('La date de clôture prévisionnelle doit être postérieure à la date de début de la campagne')
            ->atPath('dateCloture')
            ->addViolation();
        }

        if ($this->dateDebut && $this->dateDebutEntretien && !($this->dateDebut <= $this->dateDebutEntretien)) {
            $context->buildViolation('La date de début des entretiens doit être postérieure à la date d\'ouverture de campagne')
            ->atPath('dateDebutEntretien')
            ->addViolation();
        }

        if ($this->dateDebutEntretien && $this->dateCloture && !($this->dateDebutEntretien <= $this->dateCloture)) {
            $context->buildViolation('La date de début des entretiens doit être antérieure à la date de clôture prévisionnelle de la campagne')
            ->atPath('dateDebutEntretien')
            ->addViolation();
        }
    }

    /**
     * @Assert\Callback(groups = {"modification"})
     */
    public function validateDates(ExecutionContextInterface $context, $payload)
    {
        if (strtotime(date('y/m/d', $this->dateDebut->getTimestamp())) < strtotime(date('y/m/d', $this->dateCreation->getTimestamp()))) {
            $context->buildViolation('La date de début ne peut être antérieure à la date de création de la campagne')
            ->atPath('dateDebut')
            ->addViolation();
        }

        if (strtotime(date('y/m/d', $this->dateDebutEntretien->getTimestamp())) < strtotime(date('y/m/d', $this->dateCreation->getTimestamp()))) {
            $context->buildViolation('La date de début des entretiens ne peut être antérieure à la date de création de la campagne')
            ->atPath('dateDebutEntretien')
            ->addViolation();
        }
    }
}
