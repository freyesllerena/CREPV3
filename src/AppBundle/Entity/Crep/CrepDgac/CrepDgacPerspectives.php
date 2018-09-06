<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 06/09/2018
 * Time: 11:45
 */

namespace AppBundle\Entity\Crep\CrepDgac;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CrepDgacPerspectives
 *
 * @ORM\Table(name="crep_dgac_perspectives")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository\CrepDgacMobilitePosteRepository")
 * @package AppBundle\Entity\Crep\CrepDgac
 */
class CrepDgacPerspectives extends GenericEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $tempsPartiel;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $congesFormation;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $retraite;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $disponibilite;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $concours;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $autres;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $detachement;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $cpa;

    /**
     * @return bool
     */
    public function isTempsPartiel()
    {
        return $this->tempsPartiel;
    }

    /**
     * @param bool $tempsPartiel
     */
    public function setTempsPartiel($tempsPartiel)
    {
        $this->tempsPartiel = $tempsPartiel;
    }

    /**
     * @return bool
     */
    public function isCongesFormation()
    {
        return $this->congesFormation;
    }

    /**
     * @param bool $congesFormation
     */
    public function setCongesFormation($congesFormation)
    {
        $this->congesFormation = $congesFormation;
    }

    /**
     * @return bool
     */
    public function isRetraite()
    {
        return $this->retraite;
    }

    /**
     * @param bool $retraite
     */
    public function setRetraite($retraite)
    {
        $this->retraite = $retraite;
    }

    /**
     * @return bool
     */
    public function isDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param bool $disponibilite
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    }

    /**
     * @return bool
     */
    public function isConcours()
    {
        return $this->concours;
    }

    /**
     * @param bool $concours
     */
    public function setConcours($concours)
    {
        $this->concours = $concours;
    }

    /**
     * @return bool
     */
    public function isAutres()
    {
        return $this->autres;
    }

    /**
     * @param bool $autres
     */
    public function setAutres($autres)
    {
        $this->autres = $autres;
    }

    /**
     * @return bool
     */
    public function isDetachement()
    {
        return $this->detachement;
    }

    /**
     * @param bool $detachement
     */
    public function setDetachement($detachement)
    {
        $this->detachement = $detachement;
    }

    /**
     * @return bool
     */
    public function isCpa()
    {
        return $this->cpa;
    }

    /**
     * @param bool $cpa
     */
    public function setCpa($cpa)
    {
        $this->cpa = $cpa;
    }
}
