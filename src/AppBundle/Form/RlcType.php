<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RlcType extends PersonneType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $perimetresRlc = $options['perimetresRlc'];

        $builder
        ->add('perimetresRlc', EntityType::class, array(
                'class' => 'AppBundle:PerimetreRlc',
                'choices' => $perimetresRlc,
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
            'data_class' => 'AppBundle\Entity\Rlc',
            'perimetresRlc' => null,
            'typeAction' => null,
        ));
    }
}
