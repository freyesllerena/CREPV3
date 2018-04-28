<?php

namespace AppBundle\Entity\RepriseMINDEF2016;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationAVenir2016.
 *
 * @ORM\Table(name="formation_a_venir_2016")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepriseMINDEF2016\FormationAVenir2016Repository")
 */
class FormationAVenir2016
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;

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
     * Set email.
     *
     * @param string $email
     *
     * @return FormationAVenir2016
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return FormationAVenir2016
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
}
