<?php

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepDgacAutreCompetenceProfessionnelleType extends CrepDgacCompetenceProfessionnelleType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
        ->add('libelle', null, [
        		'attr' => ['class' => 'fieldCollection',
        				'maxlength' => '4096', ],
        		'required' => false,
        ])
        ->add('niveauRequis', ChoiceType::class, [
        		'choices' => [
        				'A développer' => 0,
        				'En cours d\'acquisition' => 1,
        				'Maitrisée' => 2,
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
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgacAutreCompetenceProfessionnelle',
        ));
    }
}
