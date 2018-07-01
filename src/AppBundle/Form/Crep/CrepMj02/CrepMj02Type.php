<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 14/06/2018
 * Time: 16:47
 */

namespace AppBundle\Form\Crep\CrepMj02;


use AppBundle\Entity\Crep;
use AppBundle\Form\Crep\CrepMj02\Competences\CrepMj02CompetenceEncadrementType;
use AppBundle\Form\Crep\CrepMj02\Competences\CrepMj02CompetenceJudiciaireType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\ObjectifFuturType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CrepMj02Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Crep\CrepMj02\CrepMj02 $crep */
        $crep = $builder->getData();
        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
//        $ministere = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $tableauNotesAgent = [];

        for($i=1 ; $i<=20 ; $i++){
            $tableauNotesAgent[$i.'/20'] = $i;
        }

        $builder
            ->add('nomNaissance', null, ['required' => true])
            ->add('nomMarital', null, ['required' => false])
            ->add('prenom', null, ['required' => true])

            ->add('titulaire', ChoiceType::class, [
                'choices' => [
                    'Titulaire' => 1,
                    'Non titulaire' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
            ])

            ->add('grade', null, ['required' => false])
            ->add('corps', null, ['required' => false])

            ->add('posteOccupe', null, ['required' => true])
            ->add('dateEntreePosteOccupe',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input'  => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add('activiteEncadrement', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
            ])

            ->add('nbAgentsEncadres', null, ['required' => false])
            ->add('nbAgentsEncadresA', null, ['required' => false])
            ->add('nbAgentsEncadresB', null, ['required' => false])
            ->add('nbAgentsEncadresC', null, ['required' => false])
            ->add('direction', null, ['required' => false])
            ->add('departement', null, ['required' => false])
            ->add('service', null, ['required' => false])

            ->add('nomNaissanceShd', null, ['required' => true])
            ->add('nomMaritalShd', null, ['required' => false])

            ->add('prenomShd', null, ['required' => true])
            ->add('posteOccupeShd', null, ['required' => true])

            ->add('directionShd', null, ['required' => false])
            ->add('departementShd', null, ['required' => false])
            ->add('serviceShd', null, ['required' => false])

            ->add('motifAbsenceEntretien', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('motifAbsenceAgent', ChoiceType::class, [
                'choices' => [
                    'non activité (durée de l\'absence)' => 0,
                    'congés' => 1,
                    'autres' => 2,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('dateEntretien',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input'  => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add(
                'objectifsEvalues',
                CollectionType::class,
                [
                    'entry_type' => ObjectifEvalueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
                ]
            )
            ->add('competencesJudiciaires',
                CollectionType::class,
                [
                    'entry_type' => CrepMj02CompetenceJudiciaireType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('competencesEncadrements',
                CollectionType::class,
                [
                    'entry_type' => CrepMj02CompetenceEncadrementType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('observationsShd', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('observationsAgentNotif', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('objectifsService', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('objectifsFuturs',
                CollectionType::class,
                [
                    'entry_type' => ObjectifFuturType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('acquisExperiencePro', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('vae', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
            ])

            ->add(
                'souhaitEntretienCarriere', ChoiceType::class, [
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

            ->add('commentaireVae', null, ['required' => false])
            ->add('capacitesDecisions', TextareaType::class, [
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
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
            'selectTypologieFormation' => null,
        ));
    }
}