<?php

namespace AppBundle\Entity\Crep\CrepMso5;

use AppBundle\Entity\FormationSuivie;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepMso5FormationSuivie.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMso5Repository\CrepMso5FormationSuivieRepository")
 */
class CrepMso5FormationSuivie extends FormationSuivie
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable = true)
     */
    protected $annee;


    /**
     * Get annee.
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set annee.
     *
     * @param string $annee
     *
     * @return CrepMso5FormationSuivie
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        /*  *****   VALIDATION: duree   ***** */
        $anneeEvaluation = $this->crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        //L'année doit être soit N, N-1  (N : l'année d'évaluation)
        if ($this->annee && !in_array($this->annee, array($anneeEvaluation, $anneeEvaluation - 1))) {
            $context->buildViolation('Veuillez saisir une année valide')
                ->atPath('annee')
                ->addViolation();
        }
    }
}
