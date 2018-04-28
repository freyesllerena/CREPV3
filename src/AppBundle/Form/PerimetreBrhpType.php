<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PerimetreBrhpType extends PerimetreType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $perimetresRlc = $options['perimetresRlc'];
        $unitesOrganisationnelles = $options['unitesOrganisationnelles'];

        $builder
        ->add('perimetreRlc', EntityType::class, array(
                                                'class' => 'AppBundle:PerimetreRlc',
                                                'choices' => $perimetresRlc,
        ))
        ->add('unitesOrganisationnelles', EntityType::class, array(
            'class' => 'AppBundle\Entity\UniteOrganisationnelle',
            'choices' => $unitesOrganisationnelles,
            'multiple' => true,
            'by_reference' => false,
            'required' => false,
        ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PerimetreBrhp',
            'perimetresRlc' => null,
            'unitesOrganisationnelles' => null,
        ));
    }
}
