<?php

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CrepDgacCompetenceSyntheseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('niveauRequis', ChoiceType::class, [
        		'choices' => [
        				'faible' => 0,
        				'moyen' => 1,
        				'fort' => 2,
        				'excellent' => 3,
        		],
        		'expanded' => true,
        		'multiple' => false,
        		'attr' => ['class' => 'fieldCollection'],
        ])
        ->add('appreciation', null, [
        		'required' => false, ]);
        
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgacCompetenceSynthese',
        ));
    }
}
