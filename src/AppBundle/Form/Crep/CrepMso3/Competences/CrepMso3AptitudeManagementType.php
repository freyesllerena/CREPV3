<?php

namespace AppBundle\Form\Crep\CrepMso3\Competences;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMso3AptitudeManagementType extends CrepMso3CompetenceType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('niveau', ChoiceType::class, [
                'choices' => [3, 2, 1, 0],
                'expanded' => true,
                'multiple' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso3\CrepMso3AptitudeManagementAgent',
        ));
    }
}
