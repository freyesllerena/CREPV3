<?php

namespace AppBundle\Entity\Statistiques;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CampagnePnc;

/**
 * StatCampagnePnc.
 *
 * @ORM\Table(name="stat_campagne_pnc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Statistiques\StatCampagnePncRepository")
 */
class StatCampagnePnc
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
     * @var CampagnePnc
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampagnePnc")
     */
    private $campagnePnc;

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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * @return StatCampagnePnc
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
     * Set campagnePnc.
     *
     * @param \AppBundle\Entity\CampagnePnc $campagnePnc
     *
     * @return StatCampagnePnc
     */
    public function setCampagnePnc(\AppBundle\Entity\CampagnePnc $campagnePnc = null)
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
     * Set nbCrep.
     *
     * @param int $nbCrep
     *
     * @return StatCampagnePnc
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
