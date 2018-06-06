<?php

namespace AppBundle\Form\Crep\CrepMcc02\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('demandeeAgent', CheckboxType::class, [
//                'choices' => [
//                    'Oui' => 1,
//                    'Non' => 0,
//                ],
////                'expanded' => false,
//                'multiple' => false,
                'required' => false,
            ])
            ->add('avisShd', CheckboxType::class, [
//                'choices' => [
//                    'Oui' => 1,
//                    'Non' => 0,
//                ],
//                'expanded' => false,
//                'multiple' => false,
                'required' => false,
            ])
            ->add('propositionAh', CheckboxType::class, [
//                'choices' => [
//                    'Oui' => 1,
//                    'Non' => 0,
//                ],
//                'expanded' => false,
//                'multiple' => false,
                'required' => false,
            ])
            ->add('cpf', CheckboxType::class, [
//                'choices' => [
//                    'Oui' => 1,
//                    'Non' => 0,
//                ],
//                'expanded' => false,
//                'multiple' => false,
                'required' => false,
            ])
            ->add('echeance', ChoiceType::class, [
                'choices' => [
                    $anneeEvaluee + 1 => $anneeEvaluee + 1,
                    $anneeEvaluee + 2 => $anneeEvaluee + 2,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 80px;'],
                'required' => false,
                'placeholder' => '',
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
