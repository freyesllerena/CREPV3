<?php

namespace AppBundle\Form\Crep\CrepMcc02\Formations;

use AppBundle\Form\FormationSuivieType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMcc02FormationSuivieType extends FormationSuivieType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $anneeEvaluee = $options['annee_evaluee'];

        $builder
            ->add('annee', ChoiceType::class,
                ['choices' => [
                    $anneeEvaluee-1 => $anneeEvaluee-1,
                    $anneeEvaluee => $anneeEvaluee,
                    ],
                'expanded' => false,
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
            'data_class' => 'AppBundle\Entity\FormationSuivie',
            'ministere' => null,
            'annee_evaluee' => null,
        ));
    }

}
