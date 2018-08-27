<?php

namespace AppBundle\Form\Crep\CrepMso5;

use AppBundle\Form\Crep\CrepMso5\Competences\CrepMso5CompetenceTransverseType;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationSuivieType;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationT1Type;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationT2Type;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationT3Type;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationPreparationConcoursType;
use AppBundle\Form\Crep\CrepMso5\Formations\CrepMso5FormationAutreType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Crep\CrepMso5\CrepMso5;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepType;


class CrepMso5Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMso5 */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;

        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $options['anneeEvaluation'] = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];

        parent::buildForm($builder, $options);

        $builder
            ->add('nomUsage')
            ->add('prenom')
            ->add(
                'dateNaissance',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    ))
            ->add('categorie', null, ['required' => false])
            ->add('grade', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('directionAffectation', null, [
                'attr' => ['maxlength' => '4096'],
                'required' => false, ])
            ->add(
                'datePriseFonctions',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
        ->add('nomUsageShd')
        ->add('prenomShd')
        ->add('posteOccupeShd', null, ['required' => false])
        ->add('telephoneShd', null, ['required' => false])
        ->add('emailShd', null, ['required' => false])
        ->add('posteOccupeAgent', null, ['required' => false])
        ->add('fonctionsExercees', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('postionDansStructure', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('commentaireFonctionAgent', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('agentsEncadres', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('perspectivesEvolutionFonction', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('observationsAgentSurSonActivite', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add('observationsShd', TextareaType::class, [
            'attr' => ['maxlength' => '4096'],
            'required' => false
        ])
        ->add(
            'objectifsEvaluesCollectifs',
            CollectionType::class,
            [
                'entry_type' => CrepMso5ObjectifEvalueCollectifType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
            ]
        )
        ->add(
            'objectifsEvaluesIndividuels',
            CollectionType::class,
            [
                'entry_type' => CrepMso5ObjectifEvalueIndividuelType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
            ]
        )
            ->add(
                'autresObjectifsEvalues',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5AutreObjectifEvalueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
                ]
            )
            ->add('appreciationEvaluateur', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('elementsParticuliers', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('observationsAgentObjectifsPasses', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('observationsObjectifsPasses', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add(
                'objectifsFutursCollectifs',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5ObjectifFuturCollectifType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'objectifsFutursIndividuels',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5ObjectifFuturIndividuelType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'autresObjectifsFuturs',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5AutreObjectifFuturType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesDemontrees', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('autresCompetencesPro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('evolutionsPro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('echeanceEvolutionsPro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('observationsEvolutionsPro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('echeanceObservationsEvolutionsPro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('avisShdAvancementGrade', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesRequisesImmediatement', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesRequisesFutur', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add(
                'formationsSuivies',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationSuivieType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $options['ministere'],
                        'anneeEvaluation' => $options['anneeEvaluation'],
                    ],
                ]
            )
            ->add(
                'formationsT1',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationT1Type::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluation']],
                ]
            )
            ->add(
                'formationsT2',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationT2Type::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluation']],
                ]
            )
            ->add(
                'formationsT3',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationT3Type::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluation']],
                ]
            )
            ->add(
                'formationsPreparationConcours',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationPreparationConcoursType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluation']],
                ]
            )
            ->add(
                'formationsAutres',
                CollectionType::class,
                [
                    'entry_type' => CrepMso5FormationAutreType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluation']],
                ]
            )
            ->add('competencesTransverses',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepMso5CompetenceTransverseType::class,
                ]
            )
            ->add('appreciationShd', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('appreciationAh', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('propositionPromotion', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso5\CrepMso5',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
