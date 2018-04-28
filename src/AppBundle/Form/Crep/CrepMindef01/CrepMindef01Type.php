<?php

namespace AppBundle\Form\Crep\CrepMindef01;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\MotivationsMobiliteType;
use AppBundle\Form\DemandeFormationProfessionnelleType;

class CrepMindef01Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMindef01 */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['echelleNiveauSame'] = $crep::$echelleNiveauSame;
        $options['selectTypologieFormation'] = $crep::$selectTypologieFormation;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $builder
            ->add('matriculeAlliance', null, ['required' => false])
            ->add('nomNaissance')
            ->add('nomUsage', null, ['required' => false])
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
            ->add('corps', null, ['required' => false])
            ->add(
                'dateEntreeCorps',
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
            ->add(
                'dateEntreeGrade',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
            ->add('echelon', null, ['required' => false])
            ->add(
                'dateEntreeEchelon',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
             ->add('categorieAgent', null, ['required' => false])
             ->add('categorieShd', null, ['required' => false])
            ->add('codePosteAlliance', null, ['required' => false])
            ->add('nomNaissanceShd')
            ->add('nomUsageShd', null, ['required' => false])
            ->add('prenomShd')
            ->add('corpsShd', null, ['required' => false])
            ->add('gradeShd', null, ['required' => false])
            ->add('affectationSigleAgent', null, ['required' => false])
            ->add('affectationClairAgent', null, ['required' => false])
            ->add('posteOccupeAgent', null, ['required' => false])
            ->add(
                'dateEntreePosteOccupeAgent',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add('posteOccupeShd', null, ['required' => false])
            ->add('pointsActualisesFichePoste', null, ['required' => false])
            ->add(
                'fichePoseAJour',
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
            ->add('autresActivites', null, ['required' => false])
            ->add('resultatAutresActivites')
            ->add('nbAgentsEncadresA', TextType::class)
            ->add('nbAgentsEncadresB', TextType::class)
            ->add('nbAgentsEncadresC', TextType::class)
            ->add('contexteObjectifsAnneeEnCours')
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
                ]
            )
            ->add(
                'souhaitEvolutionProfessionnelle',
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
            ->add('capitalDif', TextType::class)
            ->add('capitalDifMobilisable', TextType::class)
            ->add('capitalDifEstimation', TextType::class)
            ->add(
                'evaluationGlobale',
                ChoiceType::class,
                [
                    'choices' => [
                        'Insuffisant' => 0,
                        'Partiel' => 1,
                        'Conforme' => 2,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('aptitudesExercerFonctionsSupperieures')
            ->add('appreciationLitteraleShd')
            ->add(
                'competencesManageriales',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepMindef01CompetenceManagerialeType::class,
//                     'allow_add' => true,
//                     'allow_delete' => true,
//                     'by_reference' => false,
                ]
            )
            ->add(
                'competencesTransverses',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepMindef01CompetenceTransverseType::class,
//                     'allow_add' => true,
//                     'allow_delete' => true,
//                     'by_reference' => false,
                ]
            )

            //////////////////////////////////////////////////////////////////////////////////////////////////////
            ->add('mobiliteOrganisme1')
            ->add('mobiliteOrganisme2')
            ->add('mobiliteOrganisme3')
            ->add('mobiliteOrganisme4')

            ->add('mobilitePoste1')
            ->add('mobilitePoste2')
            ->add('mobilitePoste3')
            ->add('mobilitePoste4')

            ->add('mobiliteZoneGeo1')
            ->add('mobiliteZoneGeo2')
            ->add('mobiliteZoneGeo3')
            ->add('mobiliteZoneGeo4')

            ->add('motivationsMobilite', MotivationsMobiliteType::class)
            ->add('demandeFormationProfessionnelle', DemandeFormationProfessionnelleType::class)
            ->add(
                'techniques',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => TechniqueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
             ->add(
                 'autresDomaines',
                 CollectionType::class,
                    [
                        'label' => false,
                        'entry_type' => AutreDomaineType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ]
             )

            ////////////////////////////////////////////////////////////////////////////////////////////////////
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMindef01\CrepMindef01',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
        ));
    }
}
