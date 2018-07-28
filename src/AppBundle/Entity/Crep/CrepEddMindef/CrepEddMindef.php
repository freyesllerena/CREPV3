<?php

namespace AppBundle\Entity\Crep\CrepEddMindef;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Converter;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;
use AppBundle\Entity\Crep\CrepEdd\CrepEdd;

define('COMPETENCE_RELATION_EDDMINDEF', [
    'Force de conviction (leadership)' => 0,
    'Capacité à conduire le changement' => 1,
    'Écoute' => 2,
    'Capacité à développer les compétences et à déléguer' => 3,
    'Capacité à communiquer' => 4,
    'Capacité à coopérer avec l’environnement' => 5,
    'Capacité à conseiller' => 6,
]);
define('COMPETENCE_SITUATION_EDDMINDEF', [
    'Sens de l’intérêt général' => 0,
    'Capacité à développer une vision stratégique et à anticiper' => 1,
    'Ouverture d’esprit et capacité à se remettre en question' => 2,
    'Imagination et goût pour l’innovation' => 3,
]);

/**
 * CrepEddMindef.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepEddMindefRepository\CrepEddMindefRepository")
 */
class CrepEddMindef extends CrepEdd
{


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceAction", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesActions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceRelation", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesRelations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceSituation", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesSituations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceRequise", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesRequises;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceDemontree", mappedBy="crep", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    protected $competencesDemontrees;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_actions")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesActions;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_relations")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesRelations;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_situations")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesSituations;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_requises")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesRequises;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="obs_competences_demontrees")
     * @Assert\Length(
     *      max = 4096,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $observationsCompetencesDemontrees;


    /**
     * Add competenceAction
     *
     * @param CrepEddMindefCompetenceAction $competenceAction
     *
     * @return CrepEddMindef
     */
    public function addCompetencesAction(CrepEddMindefCompetenceAction $competenceAction)
    {
        $this->competencesActions[] = $competenceAction;
        $competenceAction->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceAction
     *
     * @param CrepEddMindefCompetenceAction $competenceAction
     */
    public function removeCompetencesAction(CrepEddMindefCompetenceAction $competenceAction)
    {
        $this->competencesActions->removeElement($competenceAction);
        $competenceAction->setCrep(null);
    }

    /**
     * Get competencesActions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesActions()
    {
        return $this->competencesActions;
    }

    /**
     * Get observationsCompetencesActions
     *
     * @return string
     */
    public function getObservationsCompetencesActions()
    {
        return $this->observationsCompetencesActions;
    }

    public static $niveauCompetence = [
        'exceptionnelle' => 0,
        'forte' => 1,
        'assez forte' => 2,
        'à développer' => 3,
        'non observée' => 4,
    ];

    /**
     * Set observationsCompetencesActions
     *
     * @param string $observationsCompetencesActions
     *
     * @return CrepEddMindef
     */
    public function setObservationsCompetencesActions($observationsCompetencesActions)
    {
        $this->observationsCompetencesActions = $observationsCompetencesActions;

        return $this;
    }

    /**
     * Add competenceRelation
     *
     * @param CrepEddMindefCompetenceRelation $competenceRelation
     *
     * @return CrepEddMindef
     */
    public function addCompetencesRelation(CrepEddMindefCompetenceRelation $competenceRelation)
    {
        $this->competencesRelations[] = $competenceRelation;
        $competenceRelation->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceRelation
     *
     * @param CrepEddMindefCompetenceRelation $competenceRelation
     */
    public function removeCompetencesRelation(CrepEddMindefCompetenceRelation $competenceRelation)
    {
        $this->competencesRelations->removeElement($competenceRelation);
        $competenceRelation->setCrep(null);
    }

    /**
     * Get competencesRelations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesRelations()
    {
        return $this->competencesRelations;
    }

    /**
     * Get observationsCompetencesRelations
     *
     * @return string
     */
    public function getObservationsCompetencesRelations()
    {
        return $this->observationsCompetencesRelations;
    }

    /**
     * Set observationsCompetencesRelations
     *
     * @param string $observationsCompetencesRelations
     *
     * @return CrepEddMindef
     */
    public function setObservationsCompetencesRelations($observationsCompetencesRelations)
    {
        $this->observationsCompetencesRelations = $observationsCompetencesRelations;

        return $this;
    }

    /**
     * Add competenceSituation
     *
     * @param CrepEddMindefCompetenceSituation $competenceSituation
     *
     * @return CrepEddMindef
     */
    public function addCompetencesSituation(CrepEddMindefCompetenceSituation $competenceSituation)
    {
        $this->competencesSituations[] = $competenceSituation;
        $competenceSituation->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceSituation
     *
     * @param CrepEddMindefCompetenceSituation $competenceSituation
     */
    public function removeCompetencesSituation(CrepEddMindefCompetenceSituation $competenceSituation)
    {
        $this->competencesSituations->removeElement($competenceSituation);
        $competenceSituation->setCrep(null);
    }

    /**
     * Get competencesSituations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesSituations()
    {
        return $this->competencesSituations;
    }

    /**
     * Get observationsCompetencesSituations
     *
     * @return string
     */
    public function getObservationsCompetencesSituations()
    {
        return $this->observationsCompetencesSituations;
    }

    /**
     * Set observationsCompetencesSituations
     *
     * @param string $observationsCompetencesSituations
     *
     * @return CrepEddMindef
     */
    public function setObservationsCompetencesSituations($observationsCompetencesSituations)
    {
        $this->observationsCompetencesSituations = $observationsCompetencesSituations;

        return $this;
    }

    /**
     * Add competenceRequise
     *
     * @param CrepEddMindefCompetenceRequise $competenceRequise
     *
     * @return CrepEddMindef
     */
    public function addCompetencesRequise(CrepEddMindefCompetenceRequise $competenceRequise)
    {
        $this->competencesRequises[] = $competenceRequise;
        $competenceRequise->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceRequise
     *
     * @param CrepEddMindefCompetenceRequise $competenceRequise
     */
    public function removeCompetencesRequise(CrepEddMindefCompetenceRequise $competenceRequise)
    {
        $this->competencesRequises->removeElement($competenceRequise);
        $competenceRequise->setCrep(null);
    }

    /**
     * Get competencesRequises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesRequises()
    {
        return $this->competencesRequises;
    }

    /**
     * Get observationsCompetencesRequises
     *
     * @return string
     */
    public function getObservationsCompetencesRequises()
    {
        return $this->observationsCompetencesRequises;
    }

    /**
     * Set observationsCompetencesRequises
     *
     * @param string $observationsCompetencesRequises
     *
     * @return CrepEddMindef
     */
    public function setObservationsCompetencesRequises($observationsCompetencesRequises)
    {
        $this->observationsCompetencesRequises = $observationsCompetencesRequises;

        return $this;
    }

    /**
     * Add competenceDemontree
     *
     * @param CrepEddMindefCompetenceDemontree $competenceDemontree
     *
     * @return CrepEddMindef
     */
    public function addCompetencesDemontree(CrepEddMindefCompetenceDemontree $competenceDemontree)
    {
        $this->competencesDemontrees[] = $competenceDemontree;
        $competenceDemontree->setCrep($this);

        return $this;
    }

    /**
     * Remove competenceDemontree
     *
     * @param CrepEddMindefCompetenceDemontree $competenceDemontree
     */
    public function removeCompetencesDemontree(CrepEddMindefCompetenceDemontree $competenceDemontree)
    {
        $this->competencesDemontrees->removeElement($competenceDemontree);
        $competenceDemontree->setCrep(null);
    }

    /**
     * Get competencesDemontrees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencesDemontrees()
    {
        return $this->competencesDemontrees;
    }

    /**
     * Get observationsCompetencesDemontrees
     *
     * @return string
     */
    public function getObservationsCompetencesDemontrees()
    {
        return $this->observationsCompetencesDemontrees;
    }

    /**
     * Set observationsCompetencesDemontrees
     *
     * @param string $observationsCompetencesDemontrees
     *
     * @return CrepEddMindef
     */
    public function setObservationsCompetencesDemontrees($observationsCompetencesDemontrees)
    {
        $this->observationsCompetencesDemontrees = $observationsCompetencesDemontrees;

        return $this;
    }

    public function initialiser(Agent $agent, $em)
    {
        parent::initialiser($agent, $em);

        // Initialisatiuon des compétences liées à l'action
        $competenceAction = new CrepEddMindefCompetenceAction();
        $competenceAction->setLibelle('Capacité à décider en situation complexe');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepEddMindefCompetenceAction();
        $competenceAction->setLibelle('Implication personnelle et engagement');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepEddMindefCompetenceAction();
        $competenceAction->setLibelle('Adaptabilité');
        $this->addCompetencesAction($competenceAction);
        $competenceAction = new CrepEddMindefCompetenceAction();
        $competenceAction->setLibelle('Contrôle de soi et exemplarité comportementale ');
        $this->addCompetencesAction($competenceAction);


        // Initialisatiuon des compétences liées à la relation
        foreach (COMPETENCE_RELATION_EDDMINDEF as $keyCR => $competenceRelationEddMindef) {
            $competenceRelation = new CrepEddMindefCompetenceRelation();
            $competenceRelation->setLibelle($keyCR);
            $this->addCompetencesRelation($competenceRelation);
        }

        // Initialisatiuon des compétences liées à l'intelligence des situations
        foreach (COMPETENCE_SITUATION_EDDMINDEF as $keyCR => $competenceSituationEddMindef) {
            $competenceSituation = new CrepEddMindefCompetenceSituation();
            $competenceSituation->setLibelle($keyCR);
            $this->addCompetencesSituation($competenceSituation);
        }
    }

    public function confidentialisationChampsShd()
    {
        parent::confidentialisationChampsShd();

        /** @var CrepEddMindefCompetenceAction $competenceAction */
    foreach ($this->competencesActions as $competenceAction) {
        $competenceAction->setNiveauAcquis(null);
    }
    /** @var CrepEddMindefCompetenceRelation $competenceRelation */
    foreach ($this->competencesRelations as $competenceRelation) {
        $competenceRelation->setNiveauAcquis(null);
    }
    /** @var CrepEddMindefCompetenceSituation $competenceSituation */
    foreach ($this->competencesSituations as $competenceSituation) {
        $competenceSituation->setNiveauAcquis(null);
    }
    /** @var CrepEddMindefCompetenceRelation $competenceRequise */
        foreach ($this->getCompetencesRequises() as $competenceRequise) {
            $this->removeCompetencesRequise($competenceRequise);
        }

/*    foreach ($this->competencesDemontrees as $competenceDemontree) {
        $competenceDemontree->setLibelle(null);
        $competenceDemontree->setNiveauAcquis(null);
    }*/

        /** @var CrepEddMindefCompetenceDemontree $competenceDemontree */
        foreach ($this->getCompetencesDemontrees() as $competenceDemontree) {
            $this->removeCompetencesDemontree($competenceDemontree);
        }

        $this->setObservationsCompetencesActions(null)
            ->setObservationsCompetencesRequises(null)
            ->setObservationsCompetencesDemontrees(null)
            ->setObservationsCompetencesSituations(null)
            ->setObservationsCompetencesRelations(null);
    }



    public function validateCrepEdd (ExecutionContextInterface $context, $autreCompetenceDetenue )
    {
        parent::validateCrepEdd( $context, $autreCompetenceDetenue);

        $nbrCompetenceNiveauExceptionnelle = 0;
        $errorObservationsCompetencesActions = false;
        $errorObservationsCompetencesRelation = false;
        $errorObservationsCompetencesSituation = false;

        /** @var  CrepEddMindefCompetenceAction $competenceAction */
        foreach ($this->competencesActions as $competenceAction) {
            if ($competenceAction->getLibelle()
                && null !== $competenceAction->getNiveauAcquis()
                && 0 == $competenceAction->getNiveauAcquis()) {
                if (!$this->observationsCompetencesActions) {
                    $errorObservationsCompetencesActions = true;
                }
                ++$nbrCompetenceNiveauExceptionnelle;
            }
        }

        /** @var  CrepEddMindefCompetenceRelation $competenceRelation */
        foreach ($this->competencesRelations as $competenceRelation) {
            if ($competenceRelation->getLibelle()
                && null !== $competenceRelation->getNiveauAcquis()
                && 0 == $competenceRelation->getNiveauAcquis()) {
                if (!$this->observationsCompetencesRelations) {
                    $errorObservationsCompetencesRelation = true;
                }
                ++$nbrCompetenceNiveauExceptionnelle;
            }
        }


        /** @var  CrepEddMindefCompetenceSituation $competenceSituation
         */
        foreach ($this->competencesSituations as $competenceSituation) {
            if ($competenceSituation->getLibelle()
                && null !== $competenceSituation->getNiveauAcquis()
                && 0 == $competenceSituation->getNiveauAcquis()) {
                if (!$this->observationsCompetencesSituations) {
                    $errorObservationsCompetencesSituation = true;
                }
                ++$nbrCompetenceNiveauExceptionnelle;
            }
        }

        /*  *****   VALIDATION: Nombre de compétences dont le niveau acquis est à Exceptionnel ne doit pas dépasser 5  ***** */
        if ($nbrCompetenceNiveauExceptionnelle > 5) {

            $context->buildViolation('   Le nombre total de selections sur la colonne « exceptionnelle » des 3 tableaux Compétences Managériales ne doit pas dépasser 5')
                ->setParameter('cause', 'nbrCompetenceNiveauExceptionnelle')
                ->addViolation();
        }

        /*  *****   VALIDATION Compétences action: Si l'observation est vide et qu'au moins 1e niveau acquis Exceptionnel est coché  ***** */
        if ($errorObservationsCompetencesActions) {

            $context->buildViolation('   L\'observation ayant un niveau exceptionnel doit être motivée')
                ->setParameter('cause_observation_action', 'errorObservationsCompetencesActions')
                ->addViolation();
        }

        /*  *****   VALIDATION Compétences action: Si l'observation est vide et qu'au moins 1e niveau acquis Exceptionnel est coché  ***** */
        if ($errorObservationsCompetencesRelation) {

            $context->buildViolation('   L\'observation ayant un niveau exceptionnel doit être motivée')
                ->setParameter('cause_observation_relation', 'errorObservationsCompetencesRelation')
                ->addViolation();
        }

        /*  *****   VALIDATION Compétences action: Si l'observation est vide et qu'au moins 1e niveau acquis Exceptionnel est coché  ***** */
        if ($errorObservationsCompetencesSituation) {

            $context->buildViolation('   L\'observation ayant un niveau exceptionnel doit être motivée')
                ->setParameter('cause_observation_situation', 'errorObservationsCompetencesSituation')
                ->addViolation();
        }


        /*  *****   VALIDATION: année   ***** */
        $anneeEvaluation = parent::getAgent()->getCampagnePnc()->getAnneeEvaluee();
        //L'année doit être soit N, N-1 ou N-2 (N : l'année d'évaluation)
        /** @var FormationSuivie $formation */
        foreach ($this->formationsSuivies as $formation) {
            if (is_null($formation->getAnnee()) || ($formation->getAnnee() && !in_array($formation->getAnnee(), array($anneeEvaluation, $anneeEvaluation - 1, $anneeEvaluation - 2)))) {
                $context->buildViolation('Veuillez saisir une année valide')
                    ->setParameter('cause_formation', 'annee')
                    ->addViolation();
            }
        }
    }
}
