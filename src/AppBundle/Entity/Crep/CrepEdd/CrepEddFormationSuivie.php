<?php

namespace AppBundle\Entity\Crep\CrepEdd;

use AppBundle\Entity\FormationSuivie;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * CrepEddFormationSuivie.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddRepository\CrepEddFormationSuivieRepository")
 */
class CrepEddFormationSuivie extends FormationSuivie
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable = true)
     */
    protected $annee;


    public function getAnnee()
    {
        return $this->annee;
    }

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
