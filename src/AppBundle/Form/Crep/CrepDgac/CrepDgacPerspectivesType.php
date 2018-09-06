<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 06/09/2018
 * Time: 14:15
 */

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Crep\CrepDgac\CrepDgacPerspectives;

class CrepDgacPerspectivesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tempsPartiel', null, ['required' => false, 'label' => ' Temps partiel'])
            ->add('congesFormation', null, ['required' => false, 'label' => ' Congés de formation'])
            ->add('retraite', null, ['required' => false, 'label' => ' Retraite'])
            ->add('disponibilite', null, ['required' => false, 'label' => ' Disponibilité'])
            ->add('concours', null, ['required' => false, 'label' => ' Concours'])
            ->add('autres', null, ['required' => false, 'label' => ' Autres'])
            ->add('detachement', null, ['required' => false, 'label' => ' Détachement'])
            ->add('cpa', null, ['required' => false, 'label' => ' CPA'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgacPerspectives'
        ));
    }
}