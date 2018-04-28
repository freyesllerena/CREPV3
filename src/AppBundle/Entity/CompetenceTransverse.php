<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceTransverse.
 *
 * @ORM\Table(name="competence_transverse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenceTransverseRepository")
 */
class CompetenceTransverse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="modele_crep", type="string")
     */
    protected $modeleCrep;

    /**
     * @var string
     *
     * @ORM\Column(name="type_competence", type="string", nullable=true)
     */
    protected $typeCompetence;

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
     * Set libelle.
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
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set modeleCrep.
     *
     * @param string $modeleCrep
     *
     * @return CompetenceTransverse
     */
    public function setModeleCrep($modeleCrep)
    {
        $this->modeleCrep = $modeleCrep;

        return $this;
    }

    /**
     * Get modeleCrep.
     *
     * @return string
     */
    public function getModeleCrep()
    {
        return $this->modeleCrep;
    }

    /**
     * Get string libelle.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getLibelle();
    }

    public function getTypeCompetence()
    {
        return $this->typeCompetence;
    }

    public function setTypeCompetence($typeCompetence)
    {
        $this->typeCompetence = $typeCompetence;

        return $this;
    }
}
