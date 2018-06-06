<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepEddCompetenceManagerialeExclu.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepositery\CrepEddRepositery\CrepEddCompetenceManagerialeExcluRepository")
 */
class CrepEddCompetenceManageriale extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="competencesManageriales")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauRequis;


     public function __construct($libelle){

        $this->libelle = $libelle;
    }

    public function getCrep()
    {
        return $this->crep;
    }

    public function setCrep($crep)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function getNiveauRequis()
    {
        return $this->niveauRequis;
    }

    /**
     * @param int $niveauRequis
     */
    public function setNiveauRequis($niveauRequis)
    {
        $this->niveauRequis = $niveauRequis;
    }
}
