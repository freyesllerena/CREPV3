<?php

namespace AppBundle\Entity\RepriseMINDEF2016;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjectifFutur2016.
 *
 * @ORM\Table(name="objectif_futur_2016")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepriseMINDEF2016\ObjectifFutur2016Repository")
 */
class ObjectifFutur2016
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
     * @var int
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $libelle;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
