<?php

namespace AppBundle\Form\Crep\CrepMso3\Formations;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMso3FormationN1Type extends CrepMso3FormationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('formationSuivie', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => null,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso3\CrepMso3FormationN1',
            'annee_evaluee' => null,
        ));
    }
}
