<?php

namespace AppBundle\Form\Crep\CrepEddMindef;

use AppBundle\Entity\Crep\CrepEdd\CrepEdd;
use AppBundle\Form\Crep\CrepEdd\CrepEddType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Form\Crep\CrepType;

class CrepEddMindefType extends CrepEddType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('competencesActions',
                CollectionType::class,
                [
                    'entry_type' => CrepEddMindefCompetenceActionType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )


            ->add('observationsCompetencesActions', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesRelations',
                CollectionType::class,
                [
                    'entry_type' => CrepEddMindefCompetenceRelationType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesRelations', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesSituations',
                CollectionType::class,
                [
                    'entry_type' => CrepEddMindefCompetenceSituationType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesSituations', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesRequises',
                CollectionType::class,
                [
                    'entry_type' => CrepEddMindefCompetenceRequiseType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesRequises', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('competencesDemontrees',
                CollectionType::class,
                [
                    'entry_type' => CrepEddMindefCompetenceDemontreeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('observationsCompetencesDemontrees', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindef',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }

}
