<?php

namespace AppBundle\Form\Crep\CrepAc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Entity\Crep\CrepAc\CrepAc;

class CrepAcType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepAc */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['selectTypologieFormation'] = $crep::$selectTypologieFormation;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $options['anneeEvaluation'] = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        parent::buildForm($builder, $options);

        $ministere = $options['ministere'];
        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
        $anneeEvaluation = $options['anneeEvaluation'];

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
                                    )
                                )
            ->add('grade', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('cadreEmploi', null, ['required' => false])
            ->add('gradeEmploi', null, ['required' => false])
            ->add(
                'emploiFonctionnel',
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
            ->add('affectationSigle', null, ['required' => false])
            ->add('nomUsageShd')
            ->add('prenomShd')
            ->add('corpsShd', null, ['required' => false])
            ->add('gradeShd', null, ['required' => false])
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
            ->add('groupeFonctions', null, ['required' => false])
            ->add('nbBureauxDirection', TextType::class)
            ->add('nbCadresEncadresA', TextType::class)
            ->add('nbTotalAgentsEncadres', TextType::class)
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
                            ]
            )
            ->add('observationsEffectifs', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add(
                'contraintesPoste',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcContraintePosteType::class,
                                ]
            )
            ->add(
                'autresContraintesPoste',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcAutreContraintePosteType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
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
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
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
            ->add('autresDossiers', null, [
                                'attr' => ['maxlength' => '4096'],
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
                                'attr' => ['maxlength' => '4096'],
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
                                    'entry_type' => CrepAcCompetenceTransverseRequiseType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add(
                'autresCompetencesTransversesRequises',

                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcAutreCompetenceTransverseRequiseType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
            ->add(
                'competencesTransversesProfessionnelles',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcCompetenceTransverseProfessionnelleType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
            ->add(
                'autresCompetencesTransversesProfessionnelles',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcAutreCompetenceTransverseProfessionnelleType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
            ->add(
                'competencesManageriales',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcCompetenceManagerialeExcluType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
            ->add(
                'autresCompetencesManageriales',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcAutreCompetenceManagerialeExcluType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add('souhaitEvolutionCarriere', null, ['required' => false])
            ->add('typeEvolutionCarriere', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('souhaitMobilite', null, ['required' => false])
            ->add('typeMobilite', null, [
                                'attr' => ['maxlength' => '4096'],
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
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
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
                'formationsAcSuivies',
                                CollectionType::class,
                                [
                                    'entry_type' => FormationAcSuivieType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                    'entry_options' => [
                                    'ministere' => $ministere,
                                    'anneeEvaluation' => $anneeEvaluation,
                                ],
                            ]
            )
            ->add('appreciationGenerale', null, [
                                'attr' => ['maxlength' => '4096'],
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
            ->add('propositionAvancement', ChoiceType::class, [
                                'choices' => [
                                    'Oui' => 0,
                                    'Non' => 1,
                                    'Sans objet' => 2,
                                ],
                                'expanded' => true,
                                'multiple' => false,
                            ])
            ->add(
                'techniques',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcTechniqueType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepAc\CrepAc',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
