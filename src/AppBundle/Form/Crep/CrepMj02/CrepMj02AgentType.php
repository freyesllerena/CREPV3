<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 04/07/2018
 * Time: 10:13
 */

namespace AppBundle\Form\Crep\CrepMj02;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CrepMj02AgentType
 * @package AppBundle\Form\Crep\CrepMj02
 */
class CrepMj02AgentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('observationsAgentObjectifsEvalues', TextareaType::class, ['required' => false])
            ->add('observationsVisaAgent', null, [
                'attr' => ['maxlength' => '4096'], ])
//            ->add('observationsAgentProjetProfessionnel', TextareaType::class, [
//                'attr' => ['maxlength' => '4096'],
//                'required' => false
//            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02',
            'echelleObjectifEvalue' => null,
            'globalObjectifEvalue' => null,
//            'echelleNiveauSame' => null,
//            'selectTypologieFormation' => null,
        ));
    }
}
