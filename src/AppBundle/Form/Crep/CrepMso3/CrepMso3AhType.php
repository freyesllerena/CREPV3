<?php

namespace AppBundle\Form\Crep\CrepMso3;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Crep\CrepType;

class CrepMso3AhType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsConduiteEntretienAh', null, ['required' => false])
            ->add('observationsAppreciationsPorteesAh', null, ['required' => false])
            ->add('observationsEventuellesAh', null, ['required' => false])
            ->add('fonctionAh', null, ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso3\CrepMso3',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
