<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ObjectifEvalueParentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
        $builder
            ->add('libelle', TextareaType::class, array(
                    'attr' => array(
                            'class' => 'fieldCollection',
                            'maxlength' => '4096',
                    ),
            ))
            ->add('indicateurs', TextareaType::class, array(
                    'attr' => array(
                            'class' => 'fieldCollection',
                            'maxlength' => '4096',
                    ),
            ))
            ->add('resultat', null, array(
                    'attr' => array(
                            'class' => 'fieldCollection',
                            'maxlength' => '4096',
                    ),
            ))
            ->add('resultatObtenu', ChoiceType::class, [
                    'choices' => $echelleObjectifEvalue,
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => array(
                            'class' => 'fieldCollection',
                    ),
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ObjectifEvalueParent',
            'echelleObjectifEvalue' => null,
        ));
    }
}
