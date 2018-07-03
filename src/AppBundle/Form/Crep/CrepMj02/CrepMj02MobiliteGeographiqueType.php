<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 29/06/2018
 * Time: 11:41
 */

namespace AppBundle\Form\Crep\CrepMj02;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMj02MobiliteGeographiqueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('choix', null, ['required' => false, 'label' => 'Mobilité géographique'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MobiliteGeographique'
        ));
    }
}