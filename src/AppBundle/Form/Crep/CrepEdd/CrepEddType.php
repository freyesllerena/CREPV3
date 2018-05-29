<?php

namespace AppBundle\Form\Crep\CrepEdd;

use AppBundle\Entity\Crep\CrepEdd\CrepEddFormationSuivie;
use AppBundle\Form\Crep\CrepEdd\CrepEddFormationSuivieType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Form\Crep\CrepType;

class CrepEddType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepEdd */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['selectTypologieFormation'] = $crep::$selectTypologieFormation;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $options['anneeEvaluation'] = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        parent::buildForm($builder, $options);

        $ministere = $options['ministere'];
        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
        $anneeEvaluation = $options['anneeEvaluation'];
        $echelleNiveauSame = $options['echelleNiveauSame'];
        $selectTypologieFormation = $options['selectTypologieFormation'];

        $builder
            ->add('civilite', ChoiceType::class, ['choices' => ['M.' => EnumCivilite::MONSIEUR,
                'Mme' => EnumCivilite::MADAME, ],
                'expanded' => false,
                'multiple' => false,
                'choices_as_values' => true,
            ])
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
                                    )
                                )

//            ->add(
//                'anneeEvaluation',
//                DateType::class,
//                array(
//                    'label' => false,
//                    'widget' => 'single_text',
//                    'input' => 'datetime',
//                    'format' => 'yyyy',
//                    'required' => false,
//                )
//            )
            ->add('posteOccupeAgent', null, ['required' => false])
            ->add('grade', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('direction', null, ['required' => false])
            ->add('echelonOrigine', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('civiliteShd')
            ->add('prenomShd')
            ->add('nomUsageShd')
            ->add('posteOccupeShd', null, ['required' => false])
            ->add(
                'dateEntreePosteOccupeShd',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add('descriptionFonctions', null, [
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
            ->add('groupeFonctions', null, ['required' => false])
            ->add('nbBureauxDirection', TextType::class,
                array(
                    'label' => false,
                    'required' => false
                ))

            ->add('nbCadresEncadresA', TextType::class,
                array(
                    'label' => false,
                    'required' => false
                ))
            ->add('nbTotalAgentsEncadres', TextType::class,
                array(
                    'label' => false,
                    'required' => false
                ))
            ->add(
                'presenceAdjoints',
                ChoiceType::class,
                                [
                                    'choices' => [
                                        'Oui' => true,
                                        'Non' => false,
                                ],
                                'expanded' => true,
                                'placeholder' => null,
                                'required' => false,
                                'multiple' => false,
                                'label'=> false
                            ]
            )
            ->add('observationsEffectifs', null, [
                                'required' => false, ])



            ->add(
                'contraintesPostes',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddContraintePosteType::class,
                                ]
            )
            ->add(
                'autresContraintesPostes',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddAutreContraintePosteType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add(
                'docAnnexeBesoinsFormation',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' => false,
                    'multiple' => false,
                ]
            )

            ->add(
                'docAnnexeBilan',
                ChoiceType::class,
                                [
                                    'choices' => [
                                        'Oui' => true,
                                        'Non' => false,
                                ],
                                'expanded' => true,
                                'placeholder' => null,
                                'required' => false,
                                'multiple' => false,
                            ]
            )
            ->add('contexteObjectifsPasses', null, [
                                'required' => false, ])
            ->add(
                'formationsSuivies',
                CollectionType::class,
                [
                    'entry_type' => CrepEddFormationSuivieType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                        'anneeEvaluation' => $anneeEvaluation,
                    ],
                ]
            )
            ->add(
                'objectifsEvaluesCollectifs',
                CollectionType::class,
                                [
                                    'entry_type' =>ObjectifEvalueCollectifType::class,
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
                                    'entry_type' =>ObjectifEvalueIndividuelType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                    'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
                                ]
                            )
            ->add('autresDossiers', null, [
                                'required' => false, ])
            ->add(
                'docAnnexeObjectifsAvenir',
                ChoiceType::class,
                                [
                                    'choices' => [
                                        'Oui' => true,
                                        'Non' => false,
                                ],
                                'expanded' => true,
                                'placeholder' => null,
                                'required' => false,
                                'multiple' => false,
                            ]
            )
            ->add('contexteObjectifsAvenir', null, [
                                'required' => false, ])
            ->add(
                'objectifsFutursCollectifs',
                CollectionType::class,
                                [
                                    'entry_type' => ObjectifFuturCollectifType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
                            )
            ->add(
                'objectifsFutursIndividuels',
                CollectionType::class,
                                [
                                    'entry_type' => ObjectifFuturIndividuelType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
                            )
            ->add(
                'competencesTransversesRequises',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddCompetenceTransverseRequiseType::class,
                                    'allow_add' => false,
                                    'allow_delete' => false,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsCompetencesTransversesRequises', null, [
                'required' => false, ])


            ->add(
                'autresCompetencesTransversesRequises',

                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddAutreCompetenceTransverseRequiseType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsAutresCompetencesTransversesRequises', null, [
                'required' => false, ])

            ->add(
                'competencesManageriales',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddCompetenceManagerialeType::class,
                                    'allow_add' => false,
                                    'allow_delete' => false,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsCompetencesManageriales', null, [
                'required' => false, ])

            ->add(
                'autresCompetencesManageriales',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddAutreCompetenceManagerialeType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsAutresCompetencesManageriales', null, [
                'required' => false, ])

            ->add('souhaitEvolutionCarriere', null, ['required' => false])
            ->add('typeEvolutionCarriere', null, [
                'required' => false, ])

            ->add('souhaitMobilite', null, ['required' => false])

            ->add('typeMobilite', null, [
                'required' => false, ])

            ->add(
                'souhaitEntretienCarriere',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' => false,
                    'multiple' => false,
                    'disabled' => false,
                ]
            )
            ->add(
                'apptitudeNiveauSup',
                                ChoiceType::class,
                [
                                    'choices' => [
                                        'Oui' => true,
                                        'Non' => false,
                                    ],
                                    'expanded' => true,
                                    'placeholder' => null,
                                    'required' => false,
                                    'multiple' => false,
                                    'disabled' => false,
                                ]
            )
            ->add('observationShdEvolution', null, [
                                'required' => false, ])
            

            ->add('appreciationGenerale', null, [
                                'required' => false, ])
            ->add('evolutionIndemnitaire', ChoiceType::class, [
                                'choices' => [
                                    'Augmentation' => 0,
                                    'Maintien' => 1,
                                    'Diminution' => 2,
                                ],
                                'expanded' => true,
                                'multiple' => false,
                            ])

            ->add(
                'techniques',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddTechniqueType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsTechniques', null, [
                'required' => false, ])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEdd',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
