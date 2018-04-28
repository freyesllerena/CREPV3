<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMcc02MobilitePoste
 * 
 * @ORM\Table(name="crep_mcc02_mobilite_poste")
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02MobilitePosteRepository")
 */
class CrepMcc02MobilitePoste extends GenericEntity
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
    protected $memeMinistere;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $autreMinistere;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $autreFonctionPublique;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $autreProjet;





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
     * @return CrepMcc02MobilitePoste
     */
    public function setMemeService($memeService)
    {
    	$this->memeService = $memeService;
    
    	return $this;
    }

    /**
     * Get memeMinistere
     *
     * @return bool
     */
    public function isMemeMinistere()
    {
        return $this->memeMinistere;
    }

    /**
     * Set memeMinistere
     *
     * @param bool $memeMinistere
     *
     * @return CrepMcc02MobilitePoste
     */
    public function setMemeMinistere($memeMinistere)
    {
        $this->memeMinistere = $memeMinistere;

        return $this;
    }

    /**
     * Get autreMinistere
     *
     * @return bool
     */
    public function isAutreMinistere()
    {
        return $this->autreMinistere;
    }

    /**
     * Set autreMinistere
     *
     * @param bool $autreMinistere
     *
     * @return CrepMcc02MobilitePoste
     */
    public function setAutreMinistere($autreMinistere)
    {
        $this->autreMinistere = $autreMinistere;

        return $this;
    }

    /**
     * Get autreFonctionPublique
     *
     * @return bool
     */
    public function isAutreFonctionPublique()
    {
        return $this->autreFonctionPublique;
    }

    /**
     * Set autreFonctionPublique
     *
     * @param bool $autreFonctionPublique
     *
     * @return CrepMcc02MobilitePoste
     */
    public function setAutreFonctionPublique($autreFonctionPublique)
    {
        $this->autreFonctionPublique = $autreFonctionPublique;

        return $this;
    }

    /**
     * Get autreProjet
     *
     * @return bool
     */
    public function isAutreProjet()
    {
        return $this->autreProjet;
    }

    /**
     * Set autreProjet
     *
     * @param bool $autreProjet
     *
     * @return CrepMcc02MobilitePoste
     */
    public function setAutreProjet($autreProjet)
    {
        $this->autreProjet = $autreProjet;

        return $this;
    }
}
