<?php

namespace AppBundle\Form\Crep\CrepMj01;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Crep\CrepMj01\Competences\CrepMj01CompetenceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationSuivieType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationSolliciteeType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationEnvisageeType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Entity\Crep\CrepMj01\CrepMj01;

class CrepMj01Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMj01 */
        $crep = $builder->getData();
        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $tableauNotesAgent = [];

        for ($i = 1; $i <= 20; ++$i) {
            $tableauNotesAgent[$i.'/20'] = $i;
        }

        $builder
            ->add('nomUsage', null, ['required' => false])
            ->add('nomNaissance')
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
            ->add('corps', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('posteOccupe', null, ['required' => false])
            ->add('service', null, ['required' => false])
            ->add('affectation', null, ['required' => false])
            ->add(
                'dateEntreePoste',
                    DateType::class,
                    array(
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                    )
            )
            ->add('nomUsageShd', null, ['required' => false])
            ->add('prenomShd', null, ['required' => false])
            ->add('affectationShd', null, ['required' => false])
            ->add('posteOccupeShd', null, ['required' => false])
            ->add('serviceShd', null, ['required' => false])
            ->add('descriptionFonctions', null, ['required' => false])
            ->add('motifAbsenceEntretien', null, ['required' => false])
            ->add('observationsShdObjectifsEvalues', null, ['required' => false])
            ->add(
                'competencesProfessionnelles',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMj01CompetenceType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add('margeEvolutionCompetencesProfessionnelles', ChoiceType::class, [
                     'choices' => [2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add(
                'aptitudesProfessionnelles',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMj01CompetenceType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add('margeEvolutionAptitudesProfessionnelles', ChoiceType::class, [
                    'choices' => [2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add(
                'qualitesProfessionnelles',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMj01CompetenceType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add('margeEvolutionQualitesProfessionnelles', ChoiceType::class, [
                    'choices' => [2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add(
                'capacitesEncadrements',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMj01CompetenceType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add('margeEvolutionCapacitesEncadrement', ChoiceType::class, [
                    'choices' => [2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('margeEvolutionGlobale', ChoiceType::class, [
                    'choices' => [2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('niveauPerformanceGlobale', ChoiceType::class, [
                    'choices' => [5, 4, 3, 2, 1, 0],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('observationsCompetencesProfessionnelles', null, ['required' => false])
            ->add('observationsAptitudesesProfessionnelles', null, ['required' => false])
            ->add('observationsQualitesRelationnelles', null, ['required' => false])
            ->add('observationsCapacitesEncadrement', null, ['required' => false])
            ->add('observationsGlobale', null, ['required' => false])
            ->add('noteAgent', ChoiceType::class, [
                    'choices' => $tableauNotesAgent,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
            ])

            ->add('observationsShd', TextareaType::class, ['required' => false])
            ->add('lieu', null, ['required' => false])
            ->add('objectifsService', TextareaType::class, ['required' => false])
            ->add('perspectivesEvolutionService', TextareaType::class, ['required' => false])
            ->add('perspectivesEvolutionFonction', TextareaType::class, ['required' => false])
            ->add(
                'crepMj01FormationsSuivies',
                    CollectionType::class,
                    [
                            'label' => false,
                            'entry_type' => CrepMj01FormationSuivieType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'formationsSollicitees',
                    CollectionType::class,
                    [
                            'label' => false,
                            'entry_type' => CrepMj01FormationSolliciteeType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'formationsEnvisagees',
                    CollectionType::class,
                    [
                            'label' => false,
                            'entry_type' => CrepMj01FormationEnvisageeType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add('observationsShdFormation', TextareaType::class, ['required' => false])
            ->add('connaissancesInstitution', TextareaType::class, ['required' => false])
            ->add('connaissancesProfessionnelles', TextareaType::class, ['required' => false])
            ->add('experienceEncadrement', TextareaType::class, ['required' => false])
            ->add('capacitesDecisions', TextareaType::class, ['required' => false])
            ->add('mobiliteFonctionnelleOuGeographique', TextareaType::class, ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj01\CrepMj01',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
