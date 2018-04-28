<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Perimetre.
 *
 * @ORM\MappedSuperclass
 */
abstract class Perimetre extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(
     *      max = 80,
     *      maxMessage = "Le libellé est limité à {{ limit }} caractères"
     * )
     */
    protected $libelle;

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        //  Supprimer les espaces en trop dans une chaîne
        $this->libelle = preg_replace('/\s\s+/', ' ', $libelle);

        return $this;
    }
}
