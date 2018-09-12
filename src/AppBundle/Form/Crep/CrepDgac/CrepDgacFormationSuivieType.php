<?php

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CrepDgacFormationSuivieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('libelle', null, [
	        		'attr' => ['class' => 'fieldCollection',
	        				'maxlength' => '4096', ],
	        		'required' => false,
	        ])
            ->add('satisfaction', ChoiceType::class, [
                'choices' => [
                    'Instatisfait (1)' => 1,
                    'Peu satisfait (2)' => 2,
                    'Moyennement satisfait (3)' => 3,
                    'Satisfait (4)' => 4,
                    'Excellent (5)' => 5,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 100px; width: 25%'],
                'placeholder' => ''
            ])
            ->add('utilisationFormation', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 100px; width: 25%'],
                'placeholder' => ''
            ])
            ->add('commentaireAgent', TextareaType::class, [
                'attr' => ['class' => 'fieldCollection',
                    'maxlength' => '4096', ],
                'required' => false,
            ])
	    	->add('utilisationDocumentation',
	    			ChoiceType::class,
	    			[
                        'choices' => [
                                'Oui' => true,
                                'Non' => false,
                        ],
                        'expanded' => false,
                        'multiple' => false,
                        'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 100px; width: 25%'],
                        'placeholder' => ''
	    			]
	    	)
            ->add('formationComplementaire', TextareaType::class, [
                'attr' => ['class' => 'fieldCollection',
                    'maxlength' => '4096', ],
                'required' => false,
            ])
            ->add('commentaires', TextareaType::class, [
                'attr' => ['class' => 'fieldCollection',
                    'maxlength' => '4096', ],
                'required' => false,
            ])
        ;
        
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgacFormationSuivie',
        ));
    }
}
