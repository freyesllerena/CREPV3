<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContraintePosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('niveauDifficulte', ChoiceType::class, [
                    'choices' => [
                        'Faibles' => 0,
                        'Moyennes' => 1,
                        'Fortes' => 2,
                        'Très fortes' => 3,
                        'Non pertinent' => 4,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'attr' => ['class' => 'fieldCollection'],
                ])
        ->add('observations', null, [
                    'attr' => ['class' => 'fieldCollection',
                              'maxlength' => '4096', ], ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ContraintePoste',
        ));
    }
}
