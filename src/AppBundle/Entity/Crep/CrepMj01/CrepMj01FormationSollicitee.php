<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMj01FormationSollicitee.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01FormationSolliciteeRepository")
 */
class CrepMj01FormationSollicitee extends GenericEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj01", inversedBy="formationsSollicitees")
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
     * @ORM\Column(type="integer")
     */
    protected $origine;

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
     * @return CrepMj01FormationSollicitee
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
     * @return CrepMj01FormationSollicitee
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get origine.
     *
     * @return CrepMj01
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * Set origine.
     *
     * @param int $origne
     *
     * @return CrepMj01FormationSollicitee
     */
    public function setOrigine($origne)
    {
        $this->origine = $origne;

        return $this;
    }
}
