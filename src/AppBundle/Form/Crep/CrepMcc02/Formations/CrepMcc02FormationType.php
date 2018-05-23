<?php

namespace AppBundle\Form\Crep\CrepMcc02\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMcc02FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $anneeEvaluee = $options['annee_evaluee'];

        $builder->add('libelle', null,
            array('label' => false)
        )
            ->add('commentaires')
            ->add('demandeeAgent', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ])
            ->add('avisShd', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ])
            ->add('propositionAh', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ])
            ->add('cpf', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ])
            ->add('echeance', ChoiceType::class, [
                'choices' => [
                    $anneeEvaluee + 1 => $anneeEvaluee + 1,
                    $anneeEvaluee + 2 => $anneeEvaluee + 2,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null,
            ]);





    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02Formation',
            'annee_evaluee' => null,
        ));
    }
}
