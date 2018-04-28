<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MotivationsMobiliteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'projetProfessionnel',
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
            ->add('choix')
            ->add(
                'reorganisation',
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
                'rapprochementFamilial',
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
            ->add('autre', null, ['required' => false])
            ->add('echeance')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MotivationsMobilite',
        ));
    }
}
