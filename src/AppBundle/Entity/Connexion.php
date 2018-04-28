<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connexion.
 *
 * @ORM\Table(name="connexion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConnexionRepository")
 */
class Connexion
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
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_connexion", type="datetime")
     */
    private $dateConnexion;

    /**
     * @var string
     *
     * @ORM\Column(name="navigateur", type="string")
     */
    private $navigateur;

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
     * Set utilisateur.
     *
     * @param string $utilisateur
     *
     * @return Connexion
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur.
     *
     * @return string
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set dateConnexion.
     *
     * @param \DateTime $dateConnexion
     *
     * @return Connexion
     */
    public function setDateConnexion($dateConnexion)
    {
        $this->dateConnexion = $dateConnexion;

        return $this;
    }

    /**
     * Get date_connexion.
     *
     * @return \DateTime
     */
    public function getDateConnexion()
    {
        return $this->dateConnexion;
    }

    /**
     * Set navigateur.
     *
     * @param string $navigateur
     *
     * @return Connexion
     */
    public function setNavigateur($navigateur)
    {
        $this->navigateur = $navigateur;

        return $this;
    }

    /**
     * Get navigateur.
     *
     * @return string
     */
    public function getNavigateur()
    {
        return $this->navigateur;
    }

    public function __construct($utilisateur)
    {
        $this->setUtilisateur($utilisateur);
        $this->dateConnexion = new \DateTime();
        $this->navigateur = $_SERVER['HTTP_USER_AGENT'];
    }
}
