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
                    'instatisfait' => 0,
                    'peu satisfait' => 1,
                    'moyennement satisfait' => 2,
                    'satisfait' => 3,
                    'très satisfait' => 4,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 80px; width: 20%'],
                'placeholder' => ''
            ])
            ->add('utilisationFormation', ChoiceType::class, [
                'choices' => [
                    'Oui' => 0,
                    'Non' => 1,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 80px; width: 20%'],
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
                        'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 80px; width: 20%'],
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
