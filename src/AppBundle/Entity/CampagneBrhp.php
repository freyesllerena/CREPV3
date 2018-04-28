<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CampagneBrhp.
 *
 * @ORM\Table(name="campagne_brhp")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampagneBrhpRepository")
 */
class CampagneBrhp extends Campagne
{
    /**
     * @var PerimetreBrhp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PerimetreBrhp", inversedBy="campagnesBrhp")
     * @ORM\JoinColumn(nullable=false)
     */
    private $perimetreBrhp;

    /**
     * @var CampagneRlc
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagneRlc")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campagneRlc;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Agent", mappedBy="campagneBrhp")
     * @ORM\OrderBy({"email" = "ASC"})
     */
    private $agents;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set perimetreBrhp.
     *
     * @param PerimetreBrhp $perimetreBrhp
     *
     * @return Utilisateur
     */
    public function setPerimetreBrhp(PerimetreBrhp $perimetreBrhp)
    {
        $this->perimetreBrhp = $perimetreBrhp;

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
     * Get campagneRlc.
     *
     * @return CampagneRlc
     */
    public function getCampagneRlc()
    {
        return $this->campagneRlc;
    }

    /**
     * Set campagneBrhp.
     *
     * @param CampagneRlc $campagneRlc
     *
     * @return Utilisateur
     */
    public function setCampagneRlc($campagneRlc)
    {
        $this->campagneRlc = $campagneRlc;
        $this->dateCloture = $this->campagneRlc->getDateCloture();

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return Ministere
     */
    public function getMinistere()
    {
        return $this->campagneRlc->getCampagnePnc()->getMinistere();
    }

    /**
     * Get anneeEvaluee.
     *
     * @return int
     */
    public function getAnneeEvaluee()
    {
        return $this->campagneRlc->getCampagnePnc()->getAnneeEvaluee();
    }

    /**
     * Add document.
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return CampagneBrhp
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
     * Add agent.
     *
     * @param \AppBundle\Entity\Agent $agent
     *
     * @return CampagneBrhp
     */
    public function addAgent(\AppBundle\Entity\Agent $agent)
    {
        $this->agents[] = $agent;
        $agent->setCampagneBrhp($this);

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
        $agent->setCampagneBrhp(null);
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

    public function getDateFermeture()
    {
        return $this->campagneRlc->getCampagnePnc()->getDateFermeture();
    }

    public function getDateCloture()
    {
        return $this->campagneRlc->getCampagnePnc()->getDateCloture();
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->campagneRlc->getCampagnePnc()->getLibelle();
    }

    /**
     * Get dateDebutEntretien.
     *
     * @return \DateTime
     */
    public function getDateDebutEntretien()
    {
        return $this->getCampagneRlc()->getCampagnePnc()->getDateDebutEntretien();
    }

    /**
     * Get campagnePnc (racourcis).
     *
     * @return CampagnePnc
     */
    public function getCampagnePnc()
    {
        return $this->getCampagneRlc()->getCampagnePnc();
    }

    public function getDateDebut()
    {
        return $this->getCampagneRlc()->getCampagnePnc()->getDateDebut();
    }
}
