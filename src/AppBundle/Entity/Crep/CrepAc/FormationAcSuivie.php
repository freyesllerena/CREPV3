<?php

namespace AppBundle\Entity\Crep\CrepAc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\GenericEntity;

/**
 * FormationAcSuivie.
 *
 * @ORM\Table(name="formation_ac_suivie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationAcSuivieRepository")
 */
class FormationAcSuivie extends GenericEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $annee;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Le libellé est obligatoire")
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $duree;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )     *
     */
    protected $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="CrepAc", inversedBy="formationsAcSuivies")
     */
    protected $crep;

    /**
     * Set crep.
     *
     * @param CrepAc $crep
     *
     * @return FormationAcSuivie
     */
    public function setCrep(CrepAc $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return CrepAc
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * @return \DateTime
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param int
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param
     *            $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param
     *            $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param
     *            $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        /*  *****   VALIDATION: duree   ***** */
        $anneeEvaluation = $this->crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        //L'année doit être soit N, N-1 ou N-2 (N : l'année d'évaluation)
        if ($this->annee && !in_array($this->annee, array($anneeEvaluation, $anneeEvaluation - 1, $anneeEvaluation - 2))) {
            $context->buildViolation('Veuillez saisir une année valide')
            ->atPath('annee')
            ->addViolation();
        }
    }
}
