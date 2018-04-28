<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MobiliteExterneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horsMinistere')
            ->add('priorite', ChoiceType::class, array(
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
            ],
                'required' => false,
        ))
            ->add('choix')
            ->add('ministere')
            ->add('anneeDepart')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MobiliteExterne',
        ));
    }
}
