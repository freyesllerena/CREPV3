<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AutreObjectifParentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextareaType::class, array(
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
            ->add('indicateurs', TextareaType::class, array(
                'attr' => array(
                    'class' => 'fieldCollection',
                    'maxlength' => '4096',
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02AutreObjectif'
        ));
    }
}
