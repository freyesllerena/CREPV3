<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 14/06/2018
 * Time: 16:47
 */

namespace AppBundle\Form\Crep\CrepMj02;


use AppBundle\Entity\Crep;
use AppBundle\Form\Crep\CrepMj02\Competences\CrepMj02AppreciationGeneraleType;
use AppBundle\Form\Crep\CrepMj02\Competences\CrepMj02CompetenceEncadrementType;
use AppBundle\Form\Crep\CrepMj02\Competences\CrepMj02CompetenceJudiciaireType;
use AppBundle\Form\Crep\CrepMj02\Formations\CrepMj02FormationAnneeAvenirType;
use AppBundle\Form\Crep\CrepMj02\Formations\CrepMj02FormationAnneeEcouleeType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\ObjectifFuturType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\Crep\CrepMj02\CrepMj02;

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
        $options['globalObjectifEvalue'] = $crep::$globalObjectifEvalue;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $options['anneeEvaluee']  = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        parent::buildForm($builder, $options);

        $ministere = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
        $globalObjectifEvalue = $options['globalObjectifEvalue'];
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
                    'format' => 'MM/yyyy',
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
            ->add('nbAgentsEncadres', TextType::class, ['required' => false])
            ->add('nbAgentsEncadresA', TextType::class, ['required' => false])
            ->add('nbAgentsEncadresB', TextType::class, ['required' => false])
            ->add('nbAgentsEncadresC', TextType::class, ['required' => false])
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
            ->add('motifAbsenceEntretienShd', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('motifAbsenceEntretien', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
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
            ->add('appreciationsGenerales',
                CollectionType::class,
                [
                    'entry_type' => CrepMj02AppreciationGeneraleType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('observationsShd', TextareaType::class, [
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
            ->add('contexteResultats', ChoiceType::class,
                [
                    'choices' => $globalObjectifEvalue,
                    'placeholder' => false,
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false
                ])
            ->add('appreciationLitteraleShd', null, [
                'attr' => ['maxlength' => '4096'],
                'required' => false, ])
            ->add('dureeEntretien', null, ['attr' => ['maxlength' => '30'], 'required' => false])
            ->add('formationsEffectuees', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'required' => false
            ])
            ->add(
                'formationsAnneeEcoulee',
                CollectionType::class,
                [
                    'entry_type' => CrepMj02FormationAnneeEcouleeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluee']],
                ]
            )
            ->add(
                'formationsAnneeAvenir',
                CollectionType::class,
                [
                    'entry_type' => CrepMj02FormationAnneeAvenirType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['annee_evaluee' => $options['anneeEvaluee']],
                ]
            )
            ->add('typeAbsenceEntretien',
                ChoiceType::class, [
                'choices' => CrepMj02::$typesAbsenceEntretienCrepMj02,
                'expanded' => true,
                'multiple' => false,
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