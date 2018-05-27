<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMj01FormationSuivie.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01FormationSuivieRepository")
 */
class CrepMj01FormationSuivie extends GenericEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj01", inversedBy="crepMj01FormationsSuivies")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $duree;

    /**
     * Get crep.
     *
     * @return CrepMj01
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set crep.
     *
     * @param CrepMj01 $crep
     *
     * @return CrepMj01FormationSuivie
     */
    public function setCrep(CrepMj01 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * @return libelle
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param $libelle
     *
     * @return CrepMj01FormationSuivie
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return duree
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param $duree
     *
     * @return CrepMj01FormationSuivie
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }
}
