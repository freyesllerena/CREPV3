<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMindef01AgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsAgentObjectifsPasses', null, [
                                'attr' => ['maxlength' => '4096'], ])
            ->add('observationsVisaAgent', null, [
                                'attr' => ['maxlength' => '4096'], ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMindef01\CrepMindef01',
        ));
    }
}
