<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/09/2018
 * Time: 02:45
 */

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Crep\CrepDgac\CrepDgacMobilitePoste;

class CrepDgacMobilitePosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('memeService', null, ['required' => false, 'label' => ' Au sein du service'])
            ->add('horsInterRegion', null, ['required' => false, 'label' => ' Hors inter région'])
            ->add('region', null, ['required' => false, 'label' => ' Région'])
            ->add('dansLeDepartement', null, ['required' => false, 'label' => ' Dans le département (DDE, SN…)'])
            ->add('dansInterRegion', null, ['required' => false, 'label' => ' Dans inter région (CIFP…)'])
            ->add('international', null, ['required' => false, 'label' => ' International'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgacMobilitePoste'
        ));
    }
}
