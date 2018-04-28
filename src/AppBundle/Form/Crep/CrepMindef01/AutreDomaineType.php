<?php

namespace AppBundle\Form\Crep\CrepMindef01;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AutreDomaineType extends AbstractType
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
                            'maxlength' => '4096', ], ])

        ->add('niveauAcquis', ChoiceType::class, [
            'choices' => [
                '0' => 0,
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
            ],
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'fieldCollection'],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMindef01\AutreDomaine',
        ));
    }
}
