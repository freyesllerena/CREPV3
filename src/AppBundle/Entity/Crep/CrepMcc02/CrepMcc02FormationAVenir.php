<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02FormationAVenir
 * 
 * @ORM\Table(name="crep_mcc02_formation_a_venir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMcc02FormationAVenirRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMcc02FormationAVenir extends GenericEntity
{
 
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $besoinAvere;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     * 
     */
    protected $libelle;
    
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $besoinToujoursAvere;
    
    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $origine;
    
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $cpf;
    
    /**
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        //Si le résultat, échéance ou observations sont renseignés,  l'intitulé de l'objectif est obligatoire
        if($this->libelle !== null && ($this->origine === null)){
            $context->buildViolation("L'origine de la demande est obligatoire")
            ->atPath('libelle')
            ->addViolation();
        }
    }

    /**
     * Set besoinAvere
     *
     * @param bool $besoinAvere
     * @return $this
     */
    public function setBesoinAvere($besoinAvere)
    {
        $this->besoinAvere = $besoinAvere;

        return $this;
    }

    /**
     * Get besoinAvere
     *
     * @return bool
     */
    public function getBesoinAvere()
    {
        return $this->besoinAvere;
    }

    /**
     * Set libelle
     *
     * @param $libelle
     * @return $this
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }
    
    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set besoinToujoursAvere
     *
     * @param $besoinToujoursAvere
     * @return $this
     */
    public function setBesoinToujoursAvere($besoinToujoursAvere)
    {
        $this->besoinToujoursAvere = $besoinToujoursAvere;
        return $this;
    }

    /**
     * Get besoinToujoursAvere
     *
     * @return bool
     */
    public function getBesoinToujoursAvere()
    {
        return $this->besoinToujoursAvere;
    }

    /**
     * @return mixed
     */
	public function getOrigine() {
		return $this->origine;
	}

    /**
     * @param $origne
     * @return $this
     */
	public function setOrigine($origne) {
		$this->origine = $origne;
		return $this;
	}

    /**
     * @return bool
     */
	public function getCpf() {
		return $this->cpf;
	}

    /**
     * @param $cpf
     * @return $this
     */
	public function setCpf($cpf) {
		$this->cpf = $cpf;
		return $this;
	}
	
    
}
