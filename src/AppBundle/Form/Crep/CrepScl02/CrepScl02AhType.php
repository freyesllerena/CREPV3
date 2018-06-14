<?php

namespace AppBundle\Form\Crep\CrepScl02;

use AppBundle\Form\Crep\CrepType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepScl02AhType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsAh', null,["attr"=> ["maxlength" => "4096"], 'required' => false])
            ->add('qualiteAh', null, ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepScl02\CrepScl02',
        ));
    }
}
