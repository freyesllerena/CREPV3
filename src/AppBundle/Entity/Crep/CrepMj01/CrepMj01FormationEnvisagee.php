<?php

namespace AppBundle\Entity\Crep\CrepMj01;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\GenericEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CrepMj01FormationEnvisagee.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj01Repository\CrepMj01FormationEnvisageeRepository")
 */
class CrepMj01FormationEnvisagee extends GenericEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMj01", inversedBy="formationsEnvisagees")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
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
     * @return CrepMj01FormationEnvisagee
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
     * @return CrepMj01FormationEnvisagee
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
     * @return CrepMj01FormationEnvisagee
     */
    public function setOrigine($origne)
    {
        $this->origine = $origne;

        return $this;
    }
}
