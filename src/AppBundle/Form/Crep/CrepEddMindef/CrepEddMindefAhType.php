<?php

namespace AppBundle\Form\Crep\CrepEddMindef;

use AppBundle\Form\Crep\CrepEdd\CrepEddAhType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepType;

class CrepEddMindefAhType extends CrepEddAhType

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
            'data_class' => 'AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindef',
        ));
    }
}
