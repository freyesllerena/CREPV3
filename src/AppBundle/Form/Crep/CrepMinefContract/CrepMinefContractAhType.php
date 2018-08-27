<?php

namespace AppBundle\Form\Crep\CrepMinefContract;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Crep\CrepType;

class CrepMinefContractAhType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsAh', null, [
                                'attr' => ['maxlength' => '4096'], ])
            ->add('qualiteAh', null, ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMinefContract\CrepMinefContract',
        ));
    }
}
