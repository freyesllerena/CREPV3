<?php

namespace AppBundle\Form\Crep\CrepMso5\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMso5FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $anneeEvaluee = $options['annee_evaluee'];

        $builder->add('libelle')
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
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso5\CrepMso5Formation',
            'annee_evaluee' => null,
        ));
    }
}
