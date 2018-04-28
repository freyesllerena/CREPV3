<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MobiliteGeographiqueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region')
            ->add('departement')
            ->add('ville')
            ->add(
                'priorite',
                ChoiceType::class,
                array(
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                    ],
                        'required' => false,
                )
            )
            ->add(
                'choix',
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
            ->add('anneeDepart')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MobiliteGeographique',
        ));
    }
}
