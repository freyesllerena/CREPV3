<?php

namespace AppBundle\Form\Crep\CrepEdd;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\ObjectifEvalueParentType;

class ObjectifEvalueCollectifType extends ObjectifEvalueParentType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEddObjectifEvalueCollectif',
            'echelleObjectifEvalue' => null,
        ));
    }
}
