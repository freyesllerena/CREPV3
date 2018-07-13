<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 12/07/2018
 * Time: 14:13
 */

namespace AppBundle\Form\Crep\CrepMj02\Formations;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CrepMj02FormationAnneeAvenirType
 * @package AppBundle\Form\Crep\CrepMj02\Formations
 */
class CrepMj02FormationAnneeAvenirType extends CrepMj02FormationType
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
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02FormationAnneeAvenir',
            'annee_evaluee' => null,
        ));
    }
}