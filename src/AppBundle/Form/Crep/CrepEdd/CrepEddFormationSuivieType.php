<?php

namespace AppBundle\Form\Crep\CrepEdd;

use Symfony\Component\Form\AbstractType;
use AppBundle\Form\FormationSuivieType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormTypeInterface;


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
            ->remove('type')

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
            ->add('libelle2', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('duree', null, ['attr' => ['class' => 'fieldCollection']])
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
