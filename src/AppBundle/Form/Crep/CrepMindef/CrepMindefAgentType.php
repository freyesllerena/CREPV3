<?php

namespace AppBundle\Form\Crep\CrepMindef;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Crep\CrepType;

class CrepMindefAgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsAgentObjectifsFuturs')
            ->add('observationsAgentProjetProfessionnel')
            ->add('observationsVisaAgent')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMindef\CrepMindef',
        ));
    }
}
