<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/09/2018
 * Time: 03:15
 */

namespace AppBundle\Entity\Crep\CrepDgac;


use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepDgacMobilitePoste
 *
 * @ORM\Table(name="crep_dgac_mobilite_poste")
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository\CrepDgacMobilitePosteRepository")
 */
class CrepDgacMobilitePoste extends GenericEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $memeService;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $horsInterRegion;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $region;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $dansLeDepartement;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $dansInterRegion;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $international;




    /**
     * Get memeService
     *
     * @return bool
     */
    public function isMemeService()
    {
        return $this->memeService;
    }

    /**
     * Set memeService
     *
     * @param bool $memeService
     *
     * @return CrepDgacMobilitePoste
     */
    public function setMemeService($memeService)
    {
        $this->memeService = $memeService;

        return $this;
    }

    /**
     * Get horsInterRegion
     *
     * @return bool
     */
    public function isHorsInterRegion()
    {
        return $this->horsInterRegion;
    }

    /**
     * Set horsInterRegion
     *
     * @param bool horsInterRegion
     *
     * @return CrepDgacMobilitePoste
     */
    public function setHorsInterRegion($horsInterRegion)
    {
        $this->horsInterRegion = $horsInterRegion;

        return $this;
    }

    /**
     * Get region
     *
     * @return bool
     */
    public function isRegion()
    {
        return $this->region;
    }

    /**
     * Set region
     *
     * @param bool $region
     *
     * @return CrepDgacMobilitePoste
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get dansLeDepartement
     *
     * @return bool
     */
    public function isDansLeDepartement()
    {
        return $this->dansLeDepartement;
    }

    /**
     * Set dansLeDepartement
     *
     * @param bool $dansLeDepartement
     *
     * @return CrepDgacMobilitePoste
     */
    public function setDansLeDepartement($dansLeDepartement)
    {
        $this->dansLeDepartement = $dansLeDepartement;

        return $this;
    }

    /**
     * Get international
     *
     * @return bool
     */
    public function isDansInterRegion()
    {
        return $this->dansInterRegion;
    }

    /**
     * Set dansInterRegion
     *
     * @param bool $dansInterRegion
     *
     * @return CrepDgacMobilitePoste
     */
    public function setDansInterRegion($dansInterRegion)
    {
        $this->dansInterRegion = $dansInterRegion;

        return $this;
    }

    /**
     * Get international
     *
     * @return bool
     */
    public function isInternational()
    {
        return $this->international;
    }

    /**
     * Set international
     *
     * @param bool $international
     *
     * @return CrepDgacMobilitePoste
     */
    public function setInternational($international)
    {
        $this->international = $international;

        return $this;
    }
}
