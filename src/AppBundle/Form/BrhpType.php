<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BrhpType extends PersonneType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $perimetresBrhp = $options['perimetresBrhp'];

        $builder
        ->add('perimetresBrhp', EntityType::class, array(
                'class' => 'AppBundle:PerimetreBrhp',
                'choices' => $perimetresBrhp,
                'expanded' => false,
                'multiple' => true,
        ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Brhp',
            'perimetresBrhp' => null,
            'typeAction' => null,
        ));
    }
}
