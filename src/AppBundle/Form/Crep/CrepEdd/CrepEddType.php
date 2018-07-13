<?php

namespace AppBundle\Form\Crep\CrepEdd;

use AppBundle\Entity\Crep\CrepEdd\CrepEdd;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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

        $options['civiliteAgent'] = $crep->getCivilite();
        if (is_null($options['civiliteAgent'])) {
            $options['civiliteAgent'] = $crep->getAgent()->getCivilite();
        }

        $options['prenom'] = $crep->getPrenom();
        if (is_null($options['prenom'])) {
            $options['prenom'] = $crep->getAgent()->getPrenom();
        }

        $options['nomUsage'] = $crep->getNomUsage();
        if (is_null($options['nomUsage'])) {
            $options['nomUsage'] = $crep->getAgent()->getNom();
        }

        $options['dateNaissance'] = $crep->getDateNaissance();
        if (is_null($options['dateNaissance'])) {
            $options['dateNaissance'] = $crep->getAgent()->getDateNaissance();
        }

        $options['posteOccupe'] = $crep->getposteOccupeAgent();
        if (is_null($options['posteOccupe'])) {
            $options['posteOccupe'] = $crep->getAgent()->getPosteOccupe();
        }

        $options['echelon'] = $crep->getEchelon();
        if (is_null($options['echelon'])) {
            $options['echelon'] = $crep->getAgent()->getEchelon();
        }

        $options['corps'] = $crep->getCorps();
        if (is_null($options['corps'])) {
            $options['corps'] = $crep->getAgent()->getCorps();
        }

        $options['grade'] = $crep->getGrade();
        if (is_null($options['grade'])) {
            $options['grade'] = $crep->getAgent()->getGrade();
        }

        $options['civiliteShd'] = $crep->getCiviliteShd();
        if (is_null($options['civiliteShd'])) {
            $options['civiliteShd'] = $crep->getShd()->getCivilite();
        }

        $options['prenomShd'] = $crep->getPrenomShd();
        if (is_null($options['prenomShd'])) {
            $options['prenomShd'] = $crep->getShd()->getPrenom();
        }

        $options['nomShd'] = $crep->getNomUsageShd();
        if (is_null($options['nomShd'])) {
            $options['nomShd'] = $crep->getShd()->getNom();
        }

        $options['posteOccupeShd'] = $crep->getPosteOccupeShd();
        if (is_null($options['posteOccupeShd'])) {
            $options['posteOccupeShd'] = $crep->getShd()->getPosteOccupe();
        }

        $options['dateEntreePosteOccupe'] = $crep->getDateEntreePosteOccupeShd();
        if (is_null($options['dateEntreePosteOccupe'])) {
            $options['dateEntreePosteOccupe'] = $crep->getShd()->getDateEntreePosteOccupe();
        }

        $options['anneeEvaluation'] = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];

        parent::buildForm($builder, $options);

        $builder
            ->add('civilite', ChoiceType::class, ['choices' => ['M.' => EnumCivilite::MONSIEUR,
                'Mme' => EnumCivilite::MADAME, ],
                'expanded' => false,
                'multiple' => false,
                'choices_as_values' => true,
                'placeholder' => '',
                'data' => $options['civiliteAgent']
                ])
            ->add('nomUsage',TextType::class,['data' => $options['nomUsage']])
            ->add('prenom',TextType::class,['data' => $options['prenom']])
            ->add(
                'dateNaissance',
                                DateType::class,
                                array(
                                    'label' => false,
                                    'widget' => 'single_text',
                                    'input' => 'datetime',
                                    'format' => 'dd/MM/yyyy',
                                    'required' => false,
                                    'data' => $options['dateNaissance'],
                                    )
                                )
            ->add('posteOccupeAgent', null, ['required' => false, 'data' => $options['posteOccupe']])
            ->add('grade', null, ['required' => false, 'data' => $options['grade']])
            ->add('echelon', null, ['required' => false, 'data' => $options['echelon']])
            ->add('direction', null, ['required' => false])
            ->add('echelonOrigine', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('civiliteShd', ChoiceType::class, ['choices' => ['M.' => EnumCivilite::MONSIEUR,
                'Mme' => EnumCivilite::MADAME, ],
                'expanded' => false,
                'multiple' => false,
                'choices_as_values' => true,
                'placeholder' => ' ',
                'data' => $options['civiliteShd']]
            )
            ->add('prenomShd',TextType::class,['data' => $options['prenomShd']])
            ->add('nomUsageShd',TextType::class,['data' => $options['nomShd']])
            ->add('posteOccupeShd', null, ['required' => false, 'data' => $options['posteOccupeShd']])
            ->add(
                'dateEntreePosteOccupeShd',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'data' => $options['dateEntreePosteOccupe']
                )
            )
            ->add('descriptionFonctions', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
                    'required' => false,
                ))

            ->add('nbCadresEncadresA', TextType::class,
                array(
                    'label' => false,
                    'required' => false,
                ))
            ->add('nbTotalAgentsEncadres', TextType::class,
                array(
                    'label' => false,
                    'required' => false,
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
                                'label' => false,
                            ]
            )
            ->add('observationsEffectifs', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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

            ->add('contexteObjectifsPasses', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])

            ->add(
                'formationsSuivies',
                CollectionType::class,
                [
                    'entry_type' => CrepEddFormationSuivieType::class,
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
                'objectifsEvaluesCollectifs',
                CollectionType::class,
                                [
                                    'entry_type' => ObjectifEvalueCollectifType::class,
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
                                    'entry_type' => ObjectifEvalueIndividuelType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                    'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
                                ]
                            )
            ->add('autresDossiers', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('contexteObjectifsAvenir', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationsCompetencesTransversesRequises', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationsAutresCompetencesTransversesRequises', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationsCompetencesManageriales', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationsAutresCompetencesManageriales', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add(
                'competencesTransversesDetenues',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepEddCompetenceTransverseDetenueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesTransversesDetenues', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('typeEvolutionCarriere', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('typeMobilite', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationShdEvolution', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('appreciationGenerale', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
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
            ->add('observationsTechniques', TextareaType::class, [
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
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEdd',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
