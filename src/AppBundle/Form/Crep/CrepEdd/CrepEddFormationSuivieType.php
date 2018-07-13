<?php

namespace AppBundle\Form\Crep\CrepEdd;

use AppBundle\Form\FormationSuivieType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CrepEddFormationSuivieType extends FormationSuivieType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $anneeEvaluee = $options['anneeEvaluation'];

        parent::buildForm($builder, $options);

        $builder

            ->remove('date')
            ->add('annee', ChoiceType::class, [
                'choices' => [
                    $anneeEvaluee => $anneeEvaluee,
                    $anneeEvaluee - 1 => $anneeEvaluee - 1,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection'],
                'placeholder' => '',
            ])
            ->add('type', null, ['attr' => ['maxlength' => '10','class' => 'fieldCollection']])
            ->add('commentaires', TextareaType::class, ['attr' => ['maxlength' => '200','class' => 'fieldCollection']])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEddFormationSuivie',
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
