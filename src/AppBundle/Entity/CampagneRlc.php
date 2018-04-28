<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CampagneRlc.
 *
 * @ORM\Table(name="campagne_rlc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampagneRlcRepository")
 */
class CampagneRlc extends Campagne
{
    /**
     * @var PerimetreRlc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreRlc", inversedBy="campagnesRlc")
     * @ORM\JoinColumn(nullable=false)
     */
    private $perimetreRlc;

    /**
     * @var CampagnePnc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagnePnc")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campagnePnc;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PerimetreBrhp", inversedBy="campagnesRlc")
     * @ORM\JoinTable(name="campagne_rlc_perimetres_brhp")
     * @ORM\OrderBy({"libelle" = "ASC"})
     * @Assert\Count(min = "1", minMessage  = "Périmètre obligatoire")
     */
    private $perimetresBrhp;

    /**
     * @ORM\ManyToMany(targetEntity="Document", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id", nullable=true)
     * @ORM\OrderBy({"nom" = "ASC"})
     * @Assert\Valid
     */
    private $documents;

    /**
     * @var Agent
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Agent", mappedBy="campagneRlc")
     * @ORM\OrderBy({"email" = "ASC"})
     */
    private $agents;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->perimetresBrhp = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add agent.
     *
     * @param \AppBundle\Entity\Agent $agent
     *
     * @return CampagneRlc
     */
    public function addAgent(\AppBundle\Entity\Agent $agent)
    {
        $this->agents[] = $agent;
        $agent->setCampagneRlc($this);

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
        $agent->setCampagneRlc(null);
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
     * Set perimetreRlc.
     *
     * @param PerimetreRlc $perimetreRlc
     *
     * @return Utilisateur
     */
    public function setPerimetreRlc(PerimetreRlc $perimetreRlc)
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
     * Get campagnePnc.
     *
     * @return CampagnePnc
     */
    public function getCampagnePnc()
    {
        return $this->campagnePnc;
    }

    /**
     * Set campagnePnc.
     *
     * @param CampagnePnc $campagnePnc
     *
     * @return Utilisateur
     */
    public function setCampagnePnc($campagnePnc)
    {
        $this->campagnePnc = $campagnePnc;
        $this->dateCloture = $this->campagnePnc->getDateCloture();

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return Ministere
     */
    public function getMinistere()
    {
        return $this->campagnePnc->getMinistere();
    }

    /**
     * Get anneeEvaluee.
     *
     * @return int
     */
    public function getAnneeEvaluee()
    {
        return $this->campagnePnc->getAnneeEvaluee();
    }

    /**
     * Add perimetresBrhp.
     *
     * @param \AppBundle\Entity\PerimetreBrhp $perimetresBrhp
     *
     * @return CampagneRlc
     */
    public function addPerimetresBrhp(\AppBundle\Entity\PerimetreBrhp $perimetresBrhp)
    {
        $this->perimetresBrhp[] = $perimetresBrhp;
        $perimetresBrhp->addCampagnesRlc($this);

        return $this;
    }

    /**
     * Remove perimetresBrhp.
     *
     * @param \AppBundle\Entity\PerimetreBrhp $perimetresBrhp
     */
    public function removePerimetresBrhp(\AppBundle\Entity\PerimetreBrhp $perimetresBrhp)
    {
        $this->perimetresBrhp->removeElement($perimetresBrhp);
    }

    /**
     * Get perimetresBrhp.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerimetresBrhp()
    {
        return $this->perimetresBrhp;
    }

    /**
     * Add document.
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return CampagneRlc
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
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->campagnePnc->getLibelle();
    }

    /**
     * Get dateDebutEntretien.
     *
     * @return \DateTime
     */
    public function getDateDebutEntretien()
    {
        return $this->getCampagnePnc()->getDateDebutEntretien();
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        // Vérification que les périmètres BRHP ne sont pas vides

        /* @var $perimetreBrhp PerimetreBrhp */
        foreach ($this->getPerimetresBrhp() as $perimetreBrhp) {
            if (0 === count($perimetreBrhp->getBrhps())) {
                $context
                ->buildViolation("Aucun BRHP n'est associé au périmètre ".$perimetreBrhp->getLibelle())
                ->atPath('perimetresBrhp')
                ->addViolation()
                ;
            }
        }
    }

    public function getDateFermeture()
    {
        return $this->campagnePnc->getDateFermeture();
    }

    public function getDateCloture()
    {
        return $this->campagnePnc->getDateCloture();
    }

    public function getDateDebut()
    {
        return $this->campagnePnc->getDateDebut();
    }
}
