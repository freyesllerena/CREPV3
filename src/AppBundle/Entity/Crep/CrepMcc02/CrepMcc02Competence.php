<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMcc02Competence
 * 
 * @ORM\Table(name="crep_mcc02_competence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppBundle\Repository\CrepMcc02CompetenceRepository\")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class CrepMcc02Competence extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
	 *      max = 255,
	 *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
	 * )
     * @Assert\NotBlank(message = "Libellé obligatoire")
     */
    protected $libelle;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;


    
    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return CompetenceTransverse
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
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return CrepMcc02CompetenceTransverse
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
}
