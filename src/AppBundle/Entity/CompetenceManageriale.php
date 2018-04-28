<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceManageriale.
 *
 * @ORM\Table(name="competence_manageriale")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenceManagerialeRepository")
 */
class CompetenceManageriale
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
     * @return CompetenceManageriale
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
}
