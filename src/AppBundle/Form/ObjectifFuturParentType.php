<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectifFuturParentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('echeance', null, [
                    'attr' => ['class' => 'fieldCollection',
                                'maxlength' => '255', ], ])

            ->add('libelle', null, [
                    'attr' => ['class' => 'fieldCollection',
                                'maxlength' => '4096', ], ])

            ->add('resultat', null, [
                    'attr' => ['class' => 'fieldCollection',
                                'maxlength' => '4096', ], ])

            ->add('observationsEventuelles', null, [
                    'attr' => ['class' => 'fieldCollection',
                                'maxlength' => '4096', ], ])
            ->add('indicateurs', null, [
                    'attr' => ['class' => 'fieldCollection',
                            'maxlength' => '4096', ], ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ObjectifFuturParent',
        ));
    }
}
