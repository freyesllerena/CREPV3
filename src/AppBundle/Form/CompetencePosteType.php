<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompetencePosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'libelle',
                TextareaType::class,
                [
                    'label' => false,
                ]
            )
            ->add(
                'niveauRequis',
                ChoiceType::class,
                [
                    'label' => false,
                    'choices' => [
                        'S' => 0,
                        'A' => 1,
                        'M' => 2,
                        'E' => 3,
                    ],
                    'attr' => [
                        'class' => 'flat',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add(
                'niveauAcquis',
                ChoiceType::class,
                [
                    'label' => false,
                    'choices' => [
                        'S' => 0,
                        'A' => 1,
                        'M' => 2,
                        'E' => 3,
                    ],
                    'attr' => [
                        'class' => 'flat',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CompetencePoste',
        ));
    }
}
