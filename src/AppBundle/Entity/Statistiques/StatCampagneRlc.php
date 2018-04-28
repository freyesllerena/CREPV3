<?php

namespace AppBundle\Entity\Statistiques;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CampagneRlc;

/**
 * StatCampagneRlc.
 *
 * @ORM\Table(name="stat_campagne_rlc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Statistiques\StatCampagneRlcRepository")
 */
class StatCampagneRlc
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Campagnerlc
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagneRlc")
     */
    private $campagneRlc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    protected $dateStat;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrep;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepNonRenseignes;

//     /**
//      * @var integer
//      *
//      * @ORM\Column(type="integer")
//      */
//     protected $nbCrepCrees;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepModifiesShd;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepSignesShd;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepVisesAgent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepRefusVisaAgent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepSignesAh;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepNotifiesAgent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepRefusNotifAgent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbCrepCasAbsence;

    public function __construct()
    {
        $this->dateStat = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateStat.
     *
     * @param \DateTime $dateStat
     *
     * @return StatCampagneRlc
     */
    public function setDateStat($dateStat)
    {
        $this->dateStat = $dateStat;

        return $this;
    }

    /**
     * Get dateStat.
     *
     * @return \DateTime
     */
    public function getDateStat()
    {
        return $this->dateStat;
    }

    /**
     * Set nbCrepNonRenseignes.
     *
     * @param int $nbCrepNonRenseignes
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepNonRenseignes($nbCrepNonRenseignes)
    {
        $this->nbCrepNonRenseignes = $nbCrepNonRenseignes;

        return $this;
    }

    /**
     * Get nbCrepNonRenseignes.
     *
     * @return int
     */
    public function getNbCrepNonRenseignes()
    {
        return $this->nbCrepNonRenseignes;
    }

    /**
     * Set nbCrepModifiesShd.
     *
     * @param int $nbCrepModifiesShd
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepModifiesShd($nbCrepModifiesShd)
    {
        $this->nbCrepModifiesShd = $nbCrepModifiesShd;

        return $this;
    }

    /**
     * Get nbCrepModifiesShd.
     *
     * @return int
     */
    public function getNbCrepModifiesShd()
    {
        return $this->nbCrepModifiesShd;
    }

    /**
     * Set nbCrepSignesShd.
     *
     * @param int $nbCrepSignesShd
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepSignesShd($nbCrepSignesShd)
    {
        $this->nbCrepSignesShd = $nbCrepSignesShd;

        return $this;
    }

    /**
     * Get nbCrepSignesShd.
     *
     * @return int
     */
    public function getNbCrepSignesShd()
    {
        return $this->nbCrepSignesShd;
    }

    /**
     * Set nbCrepVisesAgent.
     *
     * @param int $nbCrepVisesAgent
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepVisesAgent($nbCrepVisesAgent)
    {
        $this->nbCrepVisesAgent = $nbCrepVisesAgent;

        return $this;
    }

    /**
     * Get nbCrepVisesAgent.
     *
     * @return int
     */
    public function getNbCrepVisesAgent()
    {
        return $this->nbCrepVisesAgent;
    }

    /**
     * Set nbCrepRefusVisaAgent.
     *
     * @param int $nbCrepRefusVisaAgent
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepRefusVisaAgent($nbCrepRefusVisaAgent)
    {
        $this->nbCrepRefusVisaAgent = $nbCrepRefusVisaAgent;

        return $this;
    }

    /**
     * Get nbCrepRefusVisaAgent.
     *
     * @return int
     */
    public function getNbCrepRefusVisaAgent()
    {
        return $this->nbCrepRefusVisaAgent;
    }

    /**
     * Set nbCrepSignesAh.
     *
     * @param int $nbCrepSignesAh
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepSignesAh($nbCrepSignesAh)
    {
        $this->nbCrepSignesAh = $nbCrepSignesAh;

        return $this;
    }

    /**
     * Get nbCrepSignesAh.
     *
     * @return int
     */
    public function getNbCrepSignesAh()
    {
        return $this->nbCrepSignesAh;
    }

    /**
     * Set nbCrepNotifiesAgent.
     *
     * @param int $nbCrepNotifiesAgent
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepNotifiesAgent($nbCrepNotifiesAgent)
    {
        $this->nbCrepNotifiesAgent = $nbCrepNotifiesAgent;

        return $this;
    }

    /**
     * Get nbCrepNotifiesAgent.
     *
     * @return int
     */
    public function getNbCrepNotifiesAgent()
    {
        return $this->nbCrepNotifiesAgent;
    }

    /**
     * Set nbCrepRefusNotifAgent.
     *
     * @param int $nbCrepRefusNotifAgent
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepRefusNotifAgent($nbCrepRefusNotifAgent)
    {
        $this->nbCrepRefusNotifAgent = $nbCrepRefusNotifAgent;

        return $this;
    }

    /**
     * Get nbCrepRefusNotifAgent.
     *
     * @return int
     */
    public function getNbCrepRefusNotifAgent()
    {
        return $this->nbCrepRefusNotifAgent;
    }

    /**
     * Set nbCrepCasAbsence.
     *
     * @param int $nbCrepCasAbsence
     *
     * @return StatCampagneRlc
     */
    public function setNbCrepCasAbsence($nbCrepCasAbsence)
    {
        $this->nbCrepCasAbsence = $nbCrepCasAbsence;

        return $this;
    }

    /**
     * Get nbCrepCasAbsence.
     *
     * @return int
     */
    public function getNbCrepCasAbsence()
    {
        return $this->nbCrepCasAbsence;
    }

    /**
     * Set campagneRlc.
     *
     * @param \AppBundle\Entity\CampagneRlc $campagneRlc
     *
     * @return StatCampagneRlc
     */
    public function setCampagneRlc(\AppBundle\Entity\CampagneRlc $campagneRlc = null)
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
     * Set nbCrep.
     *
     * @param int $nbCrep
     *
     * @return StatCampagneRlc
     */
    public function setNbCrep($nbCrep)
    {
        $this->nbCrep = $nbCrep;

        return $this;
    }

    /**
     * Get nbCrep.
     *
     * @return int
     */
    public function getNbCrep()
    {
        return $this->nbCrep;
    }
}
