<?php

namespace AppBundle\Form\Crep\CrepMso5;

use AppBundle\Form\ObjectifFuturParentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMso5AutreObjectifFuturType extends ObjectifFuturParentType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('echeance')
            ->remove('observationsEventuelles')
            ->remove('indicateurs');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso5\CrepMso5AutresObjectifsFutur',
            'echelleObjectifEvalue' => null,
        ));
    }
}
