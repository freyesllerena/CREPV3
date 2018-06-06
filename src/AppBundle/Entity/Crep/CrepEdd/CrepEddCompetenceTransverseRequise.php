<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepeEddCompetenceTransverseRequise.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddCompetenceTransverseRequiseRepository")
 */
class CrepEddCompetenceTransverseRequise extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepEdd", inversedBy="competencesTransversesRequises")
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
     * @return int
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
