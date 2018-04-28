<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;

/**
 * Personne.
 *
 * @ORM\MappedSuperclass
 */
abstract class Personne extends GenericEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"m.", "mme"}, message = "Civilité non valide. Valeurs acceptées : 'M.', 'Mme'")
     */
    protected $civilite;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message = "Nom usuel obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nom; // nom usuel

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message = "Prénom obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Email obligatoire", groups={"Default", "importCSV"})
     * @Assert\Email(
     *     message = "{{ value }} n'est pas un email valide",
     *     checkMX = false,
     *     groups={"Default", "importCSV"}
     * )
     */
    protected $email;

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setCivilite($civilite)
    {
        $this->civilite = $civilite ? strtolower($civilite) : $civilite;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if ($email) {
            $this->email = strtolower($email);
        }

        return $this;
    }

    /**
     * @Assert\Callback (groups={"Default", "importCSV"})
     */
    public function validatePersonne(ExecutionContextInterface $context, $payload)
    {
        if (!$this->email) {
            return;
        }

        if (!Util::validerEmail($this->email)) {
            $context->buildViolation('L\'email n\'est pas valide')
            ->atPath('email')
            ->addViolation();
        }
    }
}
