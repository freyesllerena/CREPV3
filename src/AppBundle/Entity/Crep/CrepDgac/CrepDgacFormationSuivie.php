<?php

namespace AppBundle\Entity\Crep\CrepDgac;;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Crep;
use AppBundle\Entity\GenericEntity;

/**
 * CrepDgacFormationSuivie.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository\CrepDgacFormationSuivieRepository")
 */
class CrepDgacFormationSuivie extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $satisfaction;
    
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $utilisationFormation;    
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $commentaireAgent;  
    
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $utilisationDocumentation;   
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $formationComplementaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $commentaireShd;    
    
    /**
     * @ORM\ManyToOne(targetEntity="CrepDgac", inversedBy="crepDgacFormationsSuivies")
     */
    protected $crep;

//################################################################################################################

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
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return FormationSuivieDgac
     */
    public function setLibelle($libelle)
    {
    	$this->libelle = $libelle;
    
    	return $this;
    }

    /**
     * Get satisfaction.
     *
     * @return int
     */
    public function getSatisfaction()
    {
    	return $this->satisfaction;
    }
    
    /**
     * Set satisfaction.
     *
     * @param int $satisfaction
     *
     * @return FormationSuivieDgac
     */    
    public function setSatisfaction($satisfaction)
    {
    	$this->satisfaction = $satisfaction;
    
    	return $this;
    }
    
    
    /**
     * Get utilisationFormation.
     *
     * @return bool
     */
    public function getUtilisationFormation()
    {
    	return $this->utilisationFormation;
    }    
    
    /**
     * Set utilisationFormation.
     *
     * @param bool $utilisationFormation
     *
     * @return FormationSuivieDgac
     */
    public function setUtilisationFormation($utilisationFormation)
    {
    	$this->utilisationFormation = $utilisationFormation;
    
    	return $this;
    }
    
    /**
     * Get commentaireAgent.
     *
     * @return string
     */
    public function getCommentaireAgent()
    {
    	return $this->commentaireAgent;
    }
    
    /**
     * Set CommentaireAgent.
     *
     * @param string $commentaireAgent
     *
     * @return FormationSuivieDgac
     */
    public function setCommentaireAgent($commentaireAgent)
    {
    	$this->commentaireAgent = $commentaireAgent;
    
    	return $this;
    }

    /**
     * Get utilisationDocumentation.
     *
     * @return bool
     */
    public function getUtilisationDocumentation()
    {
    	return $this->utilisationDocumentation;
    }
    
    /**
     * Set utilisationDocumentation.
     *
     * @param bool $utilisationDocumentation
     *
     * @return FormationSuivieDgac
     */
    public function setUtilisationDocumentation($utilisationDocumentation)
    {
    	$this->utilisationDocumentation = $utilisationDocumentation;
    
    	return $this;
    }

    /**
     * Get formationComplementaire.
     *
     * @return string
     */
    public function getFormationComplementaire()
    {
    	return $this->formationComplementaire;
    }
    
    /**
     * Set formationComplementaire.
     *
     * @param string $formationComplementaire
     *
     * @return FormationSuivieDgac
     */
    public function setFormationComplementaire($formationComplementaire)
    {
    	$this->formationComplementaire = $formationComplementaire;
    
    	return $this;
    }
    
    /**
     * Get commentaireShd.
     *
     * @return string
     */
    public function getCommentaireShd()
    {
    	return $this->commentaireShd;
    }
    
    /**
     * Set commentaireShd.
     *
     * @param string $commentaireShd
     *
     * @return FormationSuivieDgac
     */
    public function setCommentaireShd($commentaireShd)
    {
    	$this->commentaireShd = $commentaireShd;
    
    	return $this;
    }   

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep $crep
     *
     * @return FormationSuivieDgac
     */
    public function setCrep(\AppBundle\Entity\Crep $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep
     */
    public function getCrep()
    {
        return $this->crep;
    }

 
}
