<?php

namespace AppBundle\Form\Crep\CrepMcc02;

use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02;
use AppBundle\Form\AutreObjectifType;
//use AppBundle\Form\Crep\CrepMcc02\Competences\CrepMcc02CompetenceActionsType;
use AppBundle\Form\Crep\CrepMcc02\Competences\CrepMcc02CompetenceType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\ObjectifFuturType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMcc02Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMcc02 */
        $crep = $builder->getData();

        $options['$echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $tableauNotesAgent = [];
        
        for($i=1 ; $i<=20 ; $i++){
        	$tableauNotesAgent[$i.'/20'] = $i;
        }

        $builder
            ->add('nomUsage', null, ['required' => true])
            ->add('prenom')
            ->add('dateNaissance',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input'  => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
            ->add('grade', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('posteOccupe', null, ['required' => false])
            ->add('affectation', null, ['required' => false])
            ->add('emploiFonctionnel', ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' =>false,
                    'multiple' => false,
                ])
            ->add('libelleEmploiFonctionnel', null, ['required' => false])
            ->add('groupeEmploiFonctionnel', null, ['required' => false])
            ->add('groupeRifseep')
            ->add('fonctionsExercees', TextareaType::class, ['required' => false])
            ->add('groupeFonctions', TextareaType::class, ['required' => false])
            ->add('fichePosteAdaptee', ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' =>false,
                    'multiple' => false,
                ])
            ->add('pointsActualisesFichePoste', null, ['required' => false])
            ->add('observationsObjectifsPasses', null, [ "attr"=> ["maxlength" => "4096"], 'required' => false,])
            ->add('docAnnexeBilan', ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' =>false,
                    'multiple' => false,
                ])
            ->add('contexteAnneeEcoulee', null, ['required' => false])
            ->add('objectifsEvalues',
                CollectionType::class,
                [
                    'entry_type' => ObjectifEvalueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['echelleObjectifEvalue' => $crep::$echelleObjectifEvalue],
                ]
            )
            ->add('autresObjectifs',
                CollectionType::class,
                [
                    'entry_type' => AutreObjectifType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )

            ->add('natureDossiersTravaux', null, ['required' => false])
            ->add('resultatsObtenusParAgent', null, ['required' => false])
            ->add('contexteResultats', null, ['required' => false])

            ->add('docAnnexeObjectifsAvenir', ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'placeholder' => null,
                    'required' =>false,
                    'multiple' => false,
                ])
            ->add('contexteObjectifsAvenir', null, [
                "attr"=> ["maxlength" => "4096"],
                'required' => false,])
            ->add('objectifsFuturs',
                CollectionType::class,
                [
                    'entry_type' => ObjectifFuturType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            // IV
            ->add('competencesActions',
                CollectionType::class,
                [
                    'entry_type' => CrepMcc02CompetenceType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesActions', null, ['required' => false])


            // V
            ->add('souhaitEvolutionCarriere', null, ['required' => false])
            ->add('mobilitePoste', CrepMcc02MobilitePosteType::class, ['required' => false])

            ->add('mobiliteGeographique', CrepMcc02MobiliteGeographiqueType::class, ['required' => false])

            ->add('evolutionProfessionnelleEnvisagee')
            ->add('souhaitEntretienCarriere', ChoiceType::class, [
                'choices' => [
                    'Oui'       => 1,
                    'Non'       => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ])


            ->add('dateEntreePoste',
            		DateType::class,
            		array(
            				'label' => false,
            				'widget' => 'single_text',
            				'input'  => 'datetime',
            				'format' => 'dd/MM/yyyy',
            				'required' => false,
            		)
            )
            ->add('nomUsageShd', null, ['required' => false])
            ->add('prenomShd', null, ['required' => false])
            ->add('corpsShd', null, ['required' => false])
            ->add('gradeShd', null, ['required' => false])
            ->add('posteOccupeShd', null, ['required' => false])
            ->add('dateEntreePosteOccupeShd',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input'  => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )

            ->add('affectationShd', null, ['required' => false])
            ->add('posteOccupeShd', null, ['required' => false])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
        	'selectTypologieFormation' => null,
        ));
    }
}
